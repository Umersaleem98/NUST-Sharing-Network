<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductCreatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DonorProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product List
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );

        $products = Product::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view(
            'pages.donor.products.index',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Product
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );

        $categories = Category::orderBy('name')
            ->get();

        return view(
            'pages.donor.products.create',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],

                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],

                'images' => [
                    'nullable',
                    'array',
                    'max:5',
                ],

                'images.*' => [
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],

                'status' => [
                    'required',
                    'in:active,inactive',
                ],
            ],
            [
                'category_id.required' =>
                    'Please select a product category.',

                'category_id.exists' =>
                    'The selected category does not exist.',

                'name.required' =>
                    'Please enter the product name.',

                'name.min' =>
                    'The product name must contain at least 3 characters.',

                'description.max' =>
                    'The product description cannot exceed 3000 characters.',

                'images.max' =>
                    'You can upload a maximum of 5 product images.',

                'images.*.image' =>
                    'Every uploaded file must be a valid image.',

                'images.*.mimes' =>
                    'Product images must be JPG, JPEG, PNG or WebP.',

                'images.*.max' =>
                    'Each product image must not exceed 200 KB.',

                'status.required' =>
                    'Please select the product status.',

                'status.in' =>
                    'The selected product status is invalid.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Product Images
        |--------------------------------------------------------------------------
        |
        | Physical Location:
        |
        | public/admins/products/
        |
        | Database:
        |
        | ["product-uuid.jpg", "product-uuid.webp"]
        |
        */

        $imageNames = [];

        if ($request->hasFile('images')) {

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

                if ($extension === 'jpeg') {
                    $extension = 'jpg';
                }

                $imageName =
                    'product-'
                    . Str::uuid()
                    . '.'
                    . $extension;

                $image->move(
                    $uploadPath,
                    $imageName
                );

                $imageNames[] = $imageName;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create([
            'user_id' => $user->id,

            'category_id' =>
                $validated['category_id'],

            'name' =>
                trim($validated['name']),

            'slug' =>
                Str::slug($validated['name'])
                . '-'
                . Str::lower(Str::random(8)),

            'description' =>
                ! empty($validated['description'])
                    ? trim($validated['description'])
                    : null,

            'images' =>
                $imageNames,

            'status' =>
                $validated['status'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Administrators
        |--------------------------------------------------------------------------
        */

        $admins = User::where('role', 'admin')
            ->where('id', '!=', $user->id)
            ->get();

        if ($admins->isNotEmpty()) {

            Notification::send(
                $admins,
                new ProductCreatedNotification($product)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('donor.product.index')
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

    public function edit(int $id): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );

        $product = Product::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $categories = Category::orderBy('name')
            ->get();

        return view(
            'pages.donor.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $id
    ): RedirectResponse {

        $user = $request->user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Find Donor Product
        |--------------------------------------------------------------------------
        */

        $product = Product::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],

                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:3000',
                ],

                'status' => [
                    'required',
                    'in:active,inactive',
                ],

                'images' => [
                    'nullable',
                    'array',
                    'max:5',
                ],

                'images.*' => [
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],
            ],
            [
                'category_id.required' =>
                    'Please select a product category.',

                'category_id.exists' =>
                    'The selected category does not exist.',

                'name.required' =>
                    'Please enter the product name.',

                'name.min' =>
                    'The product name must contain at least 3 characters.',

                'description.max' =>
                    'The product description cannot exceed 3000 characters.',

                'status.required' =>
                    'Please select the product status.',

                'status.in' =>
                    'The selected product status is invalid.',

                'images.max' =>
                    'You can upload a maximum of 5 product images.',

                'images.*.image' =>
                    'Every uploaded file must be a valid image.',

                'images.*.mimes' =>
                    'Product images must be JPG, JPEG, PNG or WebP.',

                'images.*.max' =>
                    'Each product image must not exceed 200 KB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Current Images
        |--------------------------------------------------------------------------
        */

        $oldImages = $product->images ?? [];

        $newImages = [];


        /*
        |--------------------------------------------------------------------------
        | Upload Replacement Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

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

                if ($extension === 'jpeg') {
                    $extension = 'jpg';
                }

                $imageName =
                    'product-'
                    . Str::uuid()
                    . '.'
                    . $extension;

                $image->move(
                    $uploadPath,
                    $imageName
                );

                $newImages[] = $imageName;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Update Slug Only When Name Changes
        |--------------------------------------------------------------------------
        */

        if (
            $product->name !==
            trim($validated['name'])
        ) {

            $product->slug =
                Str::slug($validated['name'])
                . '-'
                . Str::lower(Str::random(8));
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->category_id =
            $validated['category_id'];

        $product->name =
            trim($validated['name']);

        $product->description =
            ! empty($validated['description'])
                ? trim($validated['description'])
                : null;

        $product->status =
            $validated['status'];


        /*
        |--------------------------------------------------------------------------
        | Replace Images Only When New Images Were Uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            $product->images =
                $newImages;
        }


        $product->save();


        /*
        |--------------------------------------------------------------------------
        | Delete Old Images After Successful Product Update
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            foreach ($oldImages as $oldImage) {

                $oldImagePath = public_path(
                    'admins/products/'
                    . basename($oldImage)
                );

                if (File::exists($oldImagePath)) {

                    File::delete($oldImagePath);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('donor.product.index')
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

    public function destroy(int $id): RedirectResponse
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Keep Image Names Before Deleting Product
        |--------------------------------------------------------------------------
        */

        $images = $product->images ?? [];


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        /*
        |--------------------------------------------------------------------------
        | Delete Product Images
        |--------------------------------------------------------------------------
        */

        foreach ($images as $image) {

            $imagePath = public_path(
                'admins/products/'
                . basename($image)
            );

            if (File::exists($imagePath)) {

                File::delete($imagePath);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('donor.product.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}