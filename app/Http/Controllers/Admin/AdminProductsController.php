<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Products List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::with([
            'category',
            'user',
        ])
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view(
            'pages.admin.products.index',
            compact('products', 'categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|in:active,inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Product Images
        |--------------------------------------------------------------------------
        |
        | Files will be stored in:
        |
        | public/admins/products/
        |
        | Database will contain only:
        |
        | filename.jpg
        |
        */

        $imageNames = [];

        if ($request->hasFile('images')) {

            $uploadPath = public_path('admins/products');

            /*
            |--------------------------------------------------------------------------
            | Create Folder If It Does Not Exist
            |--------------------------------------------------------------------------
            */

            File::ensureDirectoryExists($uploadPath);

            foreach ($request->file('images') as $image) {

                $extension = strtolower(
                    $image->getClientOriginalExtension()
                );

                $filename = Str::uuid()->toString()
                    . '.'
                    . $extension;

                $image->move(
                    $uploadPath,
                    $filename
                );

                $imageNames[] = $filename;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

        $baseSlug = Str::slug($validated['name']);

        if (empty($baseSlug)) {
            $baseSlug = 'product';
        }

        $slug = $baseSlug;

        $counter = 1;

        while (
            Product::where('slug', $slug)->exists()
        ) {

            $slug = $baseSlug . '-' . $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create([
            'user_id' => auth()->id(),

            'category_id' => $validated['category_id'],

            'name' => $validated['name'],

            'slug' => $slug,

            'description' => $validated['description'] ?? null,

            'images' => json_encode($imageNames),

            'status' => $validated['status'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Users
        |--------------------------------------------------------------------------
        */

        $users = User::where(
            'id',
            '!=',
            auth()->id()
        )->get();

        Notification::send(
            $users,
            new ProductCreatedNotification($product)
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::orderBy('name')->get();

        return view(
            'pages.admin.products.edit',
            compact('product', 'categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',

            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'images' => 'nullable|array|max:10',

            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|in:active,inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Images
        |--------------------------------------------------------------------------
        */

        $imageNames = json_decode(
            $product->images ?? '[]',
            true
        ) ?? [];


        /*
        |--------------------------------------------------------------------------
        | Check For New Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Existing Images
            |--------------------------------------------------------------------------
            */

            foreach ($imageNames as $oldImage) {

                /*
                |--------------------------------------------------------------------------
                | Images Created With Previous Storage Version
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | products/abc.jpg
                |
                | Location:
                |
                | storage/app/public/products/abc.jpg
                |
                */

                if (
                    str_starts_with(
                        $oldImage,
                        'products/'
                    )
                ) {

                    Storage::disk('public')->delete(
                        $oldImage
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Images Stored In Public Folder
                |--------------------------------------------------------------------------
                */

                else {

                    $oldImagePath = public_path(
                        'admins/products/' . basename($oldImage)
                    );

                    if (File::exists($oldImagePath)) {

                        File::delete($oldImagePath);
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Upload New Images
            |--------------------------------------------------------------------------
            */

            $imageNames = [];

            $uploadPath = public_path(
                'admins/products'
            );

            File::ensureDirectoryExists(
                $uploadPath
            );

            foreach ($request->file('images') as $image) {

                $extension = strtolower(
                    $image->getClientOriginalExtension()
                );

                $filename = Str::uuid()->toString()
                    . '.'
                    . $extension;

                $image->move(
                    $uploadPath,
                    $filename
                );

                $imageNames[] = $filename;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Unique Slug
        |--------------------------------------------------------------------------
        */

        $baseSlug = Str::slug(
            $validated['name']
        );

        if (empty($baseSlug)) {
            $baseSlug = 'product';
        }

        $slug = $baseSlug;

        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->exists()
        ) {

            $slug = $baseSlug
                . '-'
                . $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([
            'category_id' => $validated['category_id'],

            'name' => $validated['name'],

            'slug' => $slug,

            'description' => $validated['description'] ?? null,

            'images' => json_encode($imageNames),

            'status' => $validated['status'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Get Product Images
        |--------------------------------------------------------------------------
        */

        $images = json_decode(
            $product->images ?? '[]',
            true
        ) ?? [];


        /*
        |--------------------------------------------------------------------------
        | Delete Product Images
        |--------------------------------------------------------------------------
        */

        foreach ($images as $image) {

            /*
            |--------------------------------------------------------------------------
            | Previous Storage Images
            |--------------------------------------------------------------------------
            */

            if (
                str_starts_with(
                    $image,
                    'products/'
                )
            ) {

                Storage::disk('public')->delete(
                    $image
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Public Folder Images
            |--------------------------------------------------------------------------
            */

            else {

                $imagePath = public_path(
                    'admins/products/' . basename($image)
                );

                if (File::exists($imagePath)) {

                    File::delete($imagePath);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}