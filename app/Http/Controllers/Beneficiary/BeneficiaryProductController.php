<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BeneficiaryProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Available Products
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
            ],

            'search' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $productsQuery = Product::with('category')
            ->where('status', 'active');


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['category_id'])) {

            $productsQuery->where(
                'category_id',
                $validated['category_id']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['search'])) {

            $search = trim(
                $validated['search']
            );

            if ($search !== '') {

                $productsQuery->whereAny(
                    [
                        'name',
                        'description',
                    ],
                    'like',
                    '%' . $search . '%'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        $products = $productsQuery
            ->latest()
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::orderBy('name')
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
    | Product Details
    |--------------------------------------------------------------------------
    */

    public function show(int $id): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Product
        |--------------------------------------------------------------------------
        */

        $product = Product::with('category')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Check Existing Request
        |--------------------------------------------------------------------------
        */

        $requestExists = ProductRequest::where(
            'product_id',
            $product->id
        )
            ->where(
                'beneficiary_id',
                $user->id
            )
            ->exists();


        /*
        |--------------------------------------------------------------------------
        | Related Products
        |--------------------------------------------------------------------------
        */

        $relatedProducts = Product::with('category')
            ->where('status', 'active')
            ->where(
                'category_id',
                $product->category_id
            )
            ->where(
                'id',
                '!=',
                $product->id
            )
            ->latest()
            ->limit(6)
            ->get();


        return view(
            'pages.beneficiary.products.show',
            compact(
                'product',
                'requestExists',
                'relatedProducts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Send Product Request
    |--------------------------------------------------------------------------
    */

    public function sendRequest(int $id): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Authenticated Beneficiary
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Check Product Availability
        |--------------------------------------------------------------------------
        */

        if ($product->status !== 'active') {

            return back()->with(
                'error',
                'This product is currently unavailable and cannot be requested.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Request
        |--------------------------------------------------------------------------
        */

        $requestAlreadyExists = ProductRequest::where(
            'product_id',
            $product->id
        )
            ->where(
                'beneficiary_id',
                $user->id
            )
            ->exists();


        if ($requestAlreadyExists) {

            return back()->with(
                'error',
                'You have already submitted a request for this product.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product Request
        |--------------------------------------------------------------------------
        |
        | Workflow:
        |
        | Beneficiary Request
        |       ↓
        | Admin = Pending
        |       ↓
        | Admin Approves
        |       ↓
        | Donor = Pending
        |       ↓
        | Donor Approves / Rejects
        |
        */

        $productRequest = new ProductRequest();

        $productRequest->beneficiary_id =
            $user->id;

        $productRequest->product_id =
            $product->id;

        $productRequest->donor_id =
            $product->user_id;

        $productRequest->admin_status =
            'pending';

        $productRequest->donor_status =
            'pending';

        $productRequest->donor_information_allowed =
            false;

        $productRequest->save();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('beneficiary.my.requests')
            ->with(
                'success',
                'Your product request has been submitted successfully and is awaiting administrator approval.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | My Requests
    |--------------------------------------------------------------------------
    */

    public function myRequests(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Authenticated Beneficiary
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Beneficiary Requests
        |--------------------------------------------------------------------------
        */

        $requests = ProductRequest::with([
            'product.category',
            'donor.donorProfile',
        ])
            ->where(
                'beneficiary_id',
                $user->id
            )
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Protect Donor Information
        |--------------------------------------------------------------------------
        |
        | Donor information is visible only when:
        |
        | 1. Admin approved request
        | 2. Donor approved request
        | 3. Donor explicitly allowed information sharing
        |
        */

        foreach ($requests as $productRequest) {

            $canViewDonorInformation =
                $productRequest->admin_status === 'approved'
                && $productRequest->donor_status === 'approved'
                && (bool) $productRequest->donor_information_allowed;


            if (! $canViewDonorInformation) {

                $productRequest->unsetRelation(
                    'donor'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Request Statistics
        |--------------------------------------------------------------------------
        */

        $requestStats = [

            /*
            |--------------------------------------------------------------------------
            | Total
            |--------------------------------------------------------------------------
            */

            'total' => ProductRequest::where(
                'beneficiary_id',
                $user->id
            )->count(),


            /*
            |--------------------------------------------------------------------------
            | Pending Admin Approval
            |--------------------------------------------------------------------------
            */

            'admin_pending' => ProductRequest::where(
                'beneficiary_id',
                $user->id
            )
                ->where(
                    'admin_status',
                    'pending'
                )
                ->count(),


            /*
            |--------------------------------------------------------------------------
            | Waiting For Donor
            |--------------------------------------------------------------------------
            */

            'awaiting_donor' => ProductRequest::where(
                'beneficiary_id',
                $user->id
            )
                ->where(
                    'admin_status',
                    'approved'
                )
                ->where(
                    'donor_status',
                    'pending'
                )
                ->count(),


            /*
            |--------------------------------------------------------------------------
            | Approved By Donor
            |--------------------------------------------------------------------------
            */

            'accepted' => ProductRequest::where(
                'beneficiary_id',
                $user->id
            )
                ->where(
                    'admin_status',
                    'approved'
                )
                ->where(
                    'donor_status',
                    'approved'
                )
                ->count(),


            /*
            |--------------------------------------------------------------------------
            | Rejected
            |--------------------------------------------------------------------------
            */

            'rejected' => ProductRequest::where(
                'beneficiary_id',
                $user->id
            )
                ->where(function ($query) {

                    $query
                        ->where(
                            'admin_status',
                            'rejected'
                        )
                        ->orWhere(
                            'donor_status',
                            'rejected'
                        );
                })
                ->count(),
        ];


        return view(
            'pages.beneficiary.myrequest.index',
            compact(
                'requests',
                'requestStats'
            )
        );
    }
}