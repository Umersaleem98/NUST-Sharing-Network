<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BeneficiaryProductsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Browse Products
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->search
        );


        $categoryId =
            $request->category_id;


        $beneficiaryId =
            Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Active Products
        |--------------------------------------------------------------------------
        */

        $products = Product::with([
            'category',
            'creator',

            'productRequests' => function ($query) use ($beneficiaryId) {

                $query->where(
                    'beneficiary_id',
                    $beneficiaryId
                );
            },
        ])

            /*
            |--------------------------------------------------------------------------
            | Only Active Products
            |--------------------------------------------------------------------------
            */

            ->where(
                'status',
                'active'
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


            ->latest()
            ->paginate(9)
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
            'pages.beneficiary.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Send Product Request
    |--------------------------------------------------------------------------
    */

    public function storeRequest(
        Request $request,
        Product $product
    ) {
        /*
        |--------------------------------------------------------------------------
        | Product Availability
        |--------------------------------------------------------------------------
        */

        if ($product->status !== 'active') {

            return back()->with(
                'error',
                'This product is currently not available.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Request
        |--------------------------------------------------------------------------
        */

        $existingRequest = ProductRequest::where(
            'product_id',
            $product->id
        )
            ->where(
                'beneficiary_id',
                Auth::id()
            )
            ->exists();


        if ($existingRequest) {

            return back()->with(
                'error',
                'You have already submitted a request for this product.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'beneficiary_message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'beneficiary_message.max' =>
                'Your request message must not exceed 1000 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Detect Donor
        |--------------------------------------------------------------------------
        |
        | If a donor created the product, save donor_id.
        | For Admin-created products, donor_id remains null.
        |
        */

        $donorId =
            null;


        if (
            $product->creator &&
            $product->creator->role === 'donor'
        ) {

            $donorId =
                $product->user_id;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Request
        |--------------------------------------------------------------------------
        */

        ProductRequest::create([
            'product_id' =>
                $product->id,

            'beneficiary_id' =>
                Auth::id(),

            'donor_id' =>
                $donorId,

            'beneficiary_message' =>
                $request->beneficiary_message,

            'admin_status' =>
                'pending',

            'donor_status' =>
                'pending',
        ]);


        return redirect()
            ->route(
                'beneficiary.requests.index'
            )
            ->with(
                'success',
                'Your product request has been submitted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | My Requests
    |--------------------------------------------------------------------------
    */

    public function myRequests(Request $request)
    {
        $adminStatus =
            $request->admin_status;


        $donorStatus =
            $request->donor_status;


        $requests = ProductRequest::with([
            'product.category',
            'product.creator',
            'donor',
        ])

            ->where(
                'beneficiary_id',
                Auth::id()
            )


            /*
            |--------------------------------------------------------------------------
            | Admin Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $adminStatus,
                    [
                        'pending',
                        'approved',
                        'rejected',
                    ],
                    true
                ),
                function ($query) use ($adminStatus) {

                    $query->where(
                        'admin_status',
                        $adminStatus
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | Donor Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $donorStatus,
                    [
                        'pending',
                        'accepted',
                        'rejected',
                    ],
                    true
                ),
                function ($query) use ($donorStatus) {

                    $query->where(
                        'donor_status',
                        $donorStatus
                    );
                }
            )


            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'pages.beneficiary.products.my-requests',
            compact('requests')
        );
    }
}