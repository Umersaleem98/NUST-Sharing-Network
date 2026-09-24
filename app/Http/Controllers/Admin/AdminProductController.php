<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Products List
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


        $products = Product::with([
            'category',
            'creator',
        ])

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                }
            )

            ->when(
                $categoryId,
                function ($query) use ($categoryId) {

                    $query->where(
                        'category_id',
                        $categoryId
                    );
                }
            )

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


        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();


        return view(
            'pages.admins.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Page
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
            'pages.admins.products.create',
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
            | Public Folder
            |--------------------------------------------------------------------------
            */

            $destinationPath =
                public_path(
                    'admins/images/products'
                );


            /*
            |--------------------------------------------------------------------------
            | Create Folder If Missing
            |--------------------------------------------------------------------------
            */

            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Generate Unique Image Name
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file('image');


            $imageName =
                time()
                .'_'
                .Str::random(10)
                .'.'
                .$image->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Move Image
            |--------------------------------------------------------------------------
            */

            $image->move(
                $destinationPath,
                $imageName
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
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
            ->route('admin.products.index')
            ->with(
                'success',
                'Product created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Page
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories = Category::orderBy(
            'name'
        )->get();


        return view(
            'pages.admins.products.edit',
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
        | Replace Image
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
            | Destination Path
            |--------------------------------------------------------------------------
            */

            $destinationPath =
                public_path(
                    'admins/images/products'
                );


            /*
            |--------------------------------------------------------------------------
            | Create Directory
            |--------------------------------------------------------------------------
            */

            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | New Image
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file('image');


            $imageName =
                time()
                .'_'
                .Str::random(10)
                .'.'
                .$image->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Move New Image
            |--------------------------------------------------------------------------
            */

            $image->move(
                $destinationPath,
                $imageName
            );


            /*
            |--------------------------------------------------------------------------
            | Update Image Name
            |--------------------------------------------------------------------------
            */

            $product->image =
                $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product Information
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
        | Keep Original Creator
        |--------------------------------------------------------------------------
        |
        | user_id is intentionally not changed.
        |
        */

        $product->save();


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

    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Image
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
            ->route('admin.products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}