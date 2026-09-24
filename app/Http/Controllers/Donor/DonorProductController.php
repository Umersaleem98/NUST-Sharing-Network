<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class DonorProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | My Products
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->search
        );

        $categoryId =
            $request->category_id;

        $status =
            $request->status;


        /*
        |--------------------------------------------------------------------------
        | Only Current Donor Products
        |--------------------------------------------------------------------------
        */

        $products = Product::with([
            'category',
            'creator',
        ])
            ->where(
                'user_id',
                Auth::id()
            )

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        function ($subQuery) use ($search) {

                            $subQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )

            /*
            |--------------------------------------------------------------------------
            | Category Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                $categoryId,
                function ($query) use ($categoryId) {

                    $query->where(
                        'category_id',
                        $categoryId
                    );
                }
            )

            /*
            |--------------------------------------------------------------------------
            | Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $status,
                    [
                        'active',
                        'inactive',
                    ],
                    true
                ),
                function ($query) use ($status) {

                    $query->where(
                        'status',
                        $status
                    );
                }
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();


        return view(
            'pages.donor.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Product
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::where(
            'status',
            'active'
        )
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',

                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ], [
            'name.required' =>
                'Product name is required.',

            'category_id.required' =>
                'Please select a category.',

            'category_id.exists' =>
                'Selected category does not exist.',

            'image.image' =>
                'The uploaded file must be an image.',

            'image.mimes' =>
                'Image must be JPG, JPEG, PNG or WEBP.',

            'image.max' =>
                'Product image must not exceed 2 MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        $imageName =
            null;


        if ($request->hasFile('image')) {

            /*
            |--------------------------------------------------------------------------
            | Shared Product Image Directory
            |--------------------------------------------------------------------------
            |
            | We keep the same directory used by the admin product module so
            | Admin can display donor-created products without changing paths.
            |
            */

            $destinationPath =
                public_path(
                    'admins/images/products'
                );


            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }


            $image =
                $request->file('image');


            $imageName =
                time()
                .'_donor_'
                .Str::random(12)
                .'.'
                .$image->getClientOriginalExtension();


            $image->move(
                $destinationPath,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        |
        | user_id automatically identifies the donor who created the product.
        |
        */

        Product::create([
            'user_id' =>
                Auth::id(),

            'category_id' =>
                $request->category_id,

            'name' =>
                trim(
                    $request->name
                ),

            'description' =>
                $request->description,

            'image' =>
                $imageName,

            'status' =>
                $request->status,
        ]);


        return redirect()
            ->route('donor.products.index')
            ->with(
                'success',
                'Product added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Ownership Protection
        |--------------------------------------------------------------------------
        */

        if (
            (int) $product->user_id !==
            (int) Auth::id()
        ) {

            abort(
                403,
                'You are not authorized to edit this product.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        |
        | Include active categories plus the currently selected category in case
        | an admin later marked that category inactive.
        |
        */

        $categories = Category::where(
            'status',
            'active'
        )
            ->orWhere(
                'id',
                $product->category_id
            )
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
        Product $product
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ownership Protection
        |--------------------------------------------------------------------------
        */

        if (
            (int) $product->user_id !==
            (int) Auth::id()
        ) {

            abort(
                403,
                'You are not authorized to update this product.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',

                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Replace Product Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($product->image) {

                $oldImagePath =
                    public_path(
                        'admins/images/products/'
                        .$product->image
                    );


                if (
                    File::exists(
                        $oldImagePath
                    )
                ) {

                    File::delete(
                        $oldImagePath
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Product Directory
            |--------------------------------------------------------------------------
            */

            $destinationPath =
                public_path(
                    'admins/images/products'
                );


            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Upload New Image
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file('image');


            $imageName =
                time()
                .'_donor_'
                .Str::random(12)
                .'.'
                .$image->getClientOriginalExtension();


            $image->move(
                $destinationPath,
                $imageName
            );


            $product->image =
                $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->category_id =
            $request->category_id;


        $product->name =
            trim(
                $request->name
            );


        $product->description =
            $request->description;


        $product->status =
            $request->status;


        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        |
        | Do not update user_id.
        | This keeps the product linked to the original donor.
        |
        */

        $product->save();


        return redirect()
            ->route('donor.products.index')
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

    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Ownership Protection
        |--------------------------------------------------------------------------
        */

        if (
            (int) $product->user_id !==
            (int) Auth::id()
        ) {

            abort(
                403,
                'You are not authorized to delete this product.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product Image
        |--------------------------------------------------------------------------
        */

        if ($product->image) {

            $imagePath =
                public_path(
                    'admins/images/products/'
                    .$product->image
                );


            if (
                File::exists(
                    $imagePath
                )
            ) {

                File::delete(
                    $imagePath
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        return redirect()
            ->route('donor.products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}