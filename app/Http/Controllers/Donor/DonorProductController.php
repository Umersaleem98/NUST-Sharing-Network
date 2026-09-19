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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class DonorProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product List
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $products = Product::query()
            ->with([
                'category',
                'user',
            ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'pages.donor.products.index',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create Product Page
    |--------------------------------------------------------------------------
    */
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
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
                    'required',
                    'file',
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

                'images.array' =>
                    'The product images must be uploaded as valid files.',

                'images.max' =>
                    'You can upload a maximum of 5 product images.',

                'images.*.image' =>
                    'Every uploaded file must be a valid image.',

                'images.*.mimes' =>
                    'Product images must be JPG, JPEG, PNG or WebP files.',

                'images.*.max' =>
                    'Each product image must not exceed 200 KB.',

                'status.required' =>
                    'Please select the product status.',

                'status.in' =>
                    'The selected product status is invalid.',
            ]
        );

        $uploadDirectory = public_path('admins/products');
        $imageNames = [];
        $product = null;
        $transactionStarted = false;

        try {
            /*
            |--------------------------------------------------------------------------
            | Prepare Upload Directory
            |--------------------------------------------------------------------------
            */
            File::ensureDirectoryExists(
                $uploadDirectory,
                0775,
                true
            );

            if (! is_writable($uploadDirectory)) {
                throw new \RuntimeException(
                    'Product image directory is not writable: '
                    . $uploadDirectory
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Upload Images
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = strtolower(
                        $image->extension()
                        ?: $image->getClientOriginalExtension()
                    );

                    if ($extension === 'jpeg') {
                        $extension = 'jpg';
                    }

                    $filename =
                        'product-'
                        . Str::uuid()
                        . '.'
                        . $extension;

                    $image->move(
                        $uploadDirectory,
                        $filename
                    );

                    $imageNames[] = $filename;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create Product
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();
            $transactionStarted = true;

            $product = new Product();

            $product->user_id =
                $request->user()->id;

            $product->category_id =
                $validated['category_id'];

            $product->name =
                trim($validated['name']);

            $product->slug =
                Str::slug($validated['name'])
                . '-'
                . Str::lower(Str::random(8));

            $product->description =
                isset($validated['description'])
                    ? trim($validated['description'])
                    : null;

            $product->images =
                json_encode(
                    $imageNames,
                    JSON_UNESCAPED_SLASHES
                );

            $product->status =
                $validated['status'];

            $product->save();

            DB::commit();
            $transactionStarted = false;
        } catch (Throwable $exception) {
            if ($transactionStarted) {
                DB::rollBack();
            }

            /*
            |--------------------------------------------------------------------------
            | Remove Newly Uploaded Files If Store Fails
            |--------------------------------------------------------------------------
            */
            foreach ($imageNames as $imageName) {
                $imagePath =
                    $uploadDirectory
                    . DIRECTORY_SEPARATOR
                    . $imageName;

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Product could not be created. Please try again.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Notify Administrators
        |--------------------------------------------------------------------------
        |
        | A notification failure must not undo an already-created product.
        |
        */
        try {
            $admins = User::query()
                ->where('role', 'admin')
                ->get();

            if ($admins->isNotEmpty()) {
                Notification::send(
                    $admins,
                    new ProductCreatedNotification(
                        $product,
                        $request->user()
                    )
                );
            }
        } catch (Throwable $exception) {
            report($exception);
        }

        return redirect()
            ->route('donor.product.index')
            ->with(
                'success',
                'Product created successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Product Page
    |--------------------------------------------------------------------------
    */
    public function edit(int $id): View
    {
        $product = Product::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $categories = Category::query()
            ->orderBy('name')
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
        $product = Product::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

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

                'price' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'status' => [
                    'nullable',
                    'in:active,inactive',
                ],

                'images' => [
                    'nullable',
                    'array',
                    'max:5',
                ],

                'images.*' => [
                    'required',
                    'file',
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

                'price.numeric' =>
                    'The product price must be a valid number.',

                'price.min' =>
                    'The product price cannot be negative.',

                'status.in' =>
                    'The selected product status is invalid.',

                'images.max' =>
                    'You can upload a maximum of 5 product images.',

                'images.*.image' =>
                    'Every uploaded file must be a valid image.',

                'images.*.mimes' =>
                    'Product images must be JPG, JPEG, PNG or WebP files.',

                'images.*.max' =>
                    'Each product image must not exceed 200 KB.',
            ]
        );

        $uploadDirectory =
            public_path('admins/products');

        $oldImageNames =
            json_decode(
                $product->images ?: '[]',
                true
            );

        if (! is_array($oldImageNames)) {
            $oldImageNames = [];
        }

        $newImageNames = [];
        $transactionStarted = false;

        try {
            /*
            |--------------------------------------------------------------------------
            | Upload New Images Only When Supplied
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('images')) {
                File::ensureDirectoryExists(
                    $uploadDirectory,
                    0775,
                    true
                );

                if (! is_writable($uploadDirectory)) {
                    throw new \RuntimeException(
                        'Product image directory is not writable: '
                        . $uploadDirectory
                    );
                }

                foreach ($request->file('images') as $image) {
                    $extension = strtolower(
                        $image->extension()
                        ?: $image->getClientOriginalExtension()
                    );

                    if ($extension === 'jpeg') {
                        $extension = 'jpg';
                    }

                    $filename =
                        'product-'
                        . Str::uuid()
                        . '.'
                        . $extension;

                    $image->move(
                        $uploadDirectory,
                        $filename
                    );

                    $newImageNames[] = $filename;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();
            $transactionStarted = true;

            $nameChanged =
                $product->name !==
                trim($validated['name']);

            $product->category_id =
                $validated['category_id'];

            $product->name =
                trim($validated['name']);

            if ($nameChanged) {
                $product->slug =
                    Str::slug($validated['name'])
                    . '-'
                    . Str::lower(Str::random(8));
            }

            $product->description =
                isset($validated['description'])
                    ? trim($validated['description'])
                    : null;

            if (
                array_key_exists(
                    'price',
                    $validated
                )
            ) {
                $product->price =
                    $validated['price'];
            }

            if (
                array_key_exists(
                    'status',
                    $validated
                )
                && $validated['status'] !== null
            ) {
                $product->status =
                    $validated['status'];
            }

            if ($request->hasFile('images')) {
                $product->images =
                    json_encode(
                        $newImageNames,
                        JSON_UNESCAPED_SLASHES
                    );
            }

            $product->save();

            DB::commit();
            $transactionStarted = false;

            /*
            |--------------------------------------------------------------------------
            | Delete Previous Images After Successful Database Update
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('images')) {
                foreach ($oldImageNames as $oldImageName) {
                    $oldImagePath =
                        $uploadDirectory
                        . DIRECTORY_SEPARATOR
                        . basename($oldImageName);

                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
            }
        } catch (Throwable $exception) {
            if ($transactionStarted) {
                DB::rollBack();
            }

            /*
            |--------------------------------------------------------------------------
            | Remove Newly Uploaded Files If Update Fails
            |--------------------------------------------------------------------------
            */
            foreach ($newImageNames as $newImageName) {
                $newImagePath =
                    $uploadDirectory
                    . DIRECTORY_SEPARATOR
                    . $newImageName;

                if (File::exists($newImagePath)) {
                    File::delete($newImagePath);
                }
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Product could not be updated. Please try again.'
                );
        }

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
        $product = Product::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $imageNames =
            json_decode(
                $product->images ?: '[]',
                true
            );

        if (! is_array($imageNames)) {
            $imageNames = [];
        }

        $transactionStarted = false;

        try {
            DB::beginTransaction();
            $transactionStarted = true;

            $product->delete();

            DB::commit();
            $transactionStarted = false;
        } catch (Throwable $exception) {
            if ($transactionStarted) {
                DB::rollBack();
            }

            report($exception);

            return back()->with(
                'error',
                'Product could not be deleted. It may still be linked to an existing request.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Product Images After Database Delete
        |--------------------------------------------------------------------------
        */
        $uploadDirectory =
            public_path('admins/products');

        foreach ($imageNames as $imageName) {
            $imagePath =
                $uploadDirectory
                . DIRECTORY_SEPARATOR
                . basename($imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()
            ->route('donor.product.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}
