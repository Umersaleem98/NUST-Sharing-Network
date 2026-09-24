<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProductRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Requests
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $adminStatus =
            $request->admin_status;

        $donorStatus =
            $request->donor_status;

        $search =
            trim(
                (string) $request->search
            );


        $requests = ProductRequest::with([
            'product.category',
            'product.creator',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->whereHas(
                        'product',
                        function ($productQuery) use ($search) {

                            $productQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )

                    ->orWhereHas(
                        'beneficiary',
                        function ($beneficiaryQuery) use ($search) {

                            $beneficiaryQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'qalam_id',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | Admin Status
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
            | Donor Status
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


        /*
        |--------------------------------------------------------------------------
        | Dashboard Counts
        |--------------------------------------------------------------------------
        */

        $totalRequests =
            ProductRequest::count();


        $pendingRequests =
            ProductRequest::where(
                'admin_status',
                'pending'
            )->count();


        $approvedRequests =
            ProductRequest::where(
                'admin_status',
                'approved'
            )->count();


        $rejectedRequests =
            ProductRequest::where(
                'admin_status',
                'rejected'
            )->count();


        $acceptedByDonor =
            ProductRequest::where(
                'donor_status',
                'accepted'
            )->count();


        return view(
            'pages.admins.product-requests.index',
            compact(
                'requests',
                'totalRequests',
                'pendingRequests',
                'approvedRequests',
                'rejectedRequests',
                'acceptedByDonor'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | View Request
    |--------------------------------------------------------------------------
    */

    public function show(ProductRequest $productRequest)
    {
        $productRequest->load([
            'product.category',
            'product.creator',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ]);


        return view(
            'pages.admins.product-requests.show',
            compact('productRequest')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Request
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        ProductRequest $productRequest
    ) {
        $request->validate([
            'admin_message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        if (
            $productRequest->admin_status !==
            'pending'
        ) {

            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Product Must Still Be Active
        |--------------------------------------------------------------------------
        */

        if (
            !$productRequest->product ||
            $productRequest->product->status !== 'active'
        ) {

            return back()->with(
                'error',
                'This product is no longer available.'
            );
        }


        $productRequest->admin_status =
            'approved';


        $productRequest->admin_message =
            $request->admin_message;


        /*
        |--------------------------------------------------------------------------
        | Donor Status Remains Pending
        |--------------------------------------------------------------------------
        |
        | After admin approval, the donor will now be able to see it.
        |
        */

        $productRequest->donor_status =
            'pending';


        $productRequest->save();


        return redirect()
            ->route(
                'admin.product.requests.show',
                $productRequest
            )
            ->with(
                'success',
                'Request approved successfully. It is now visible to the donor.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Request
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        ProductRequest $productRequest
    ) {
        $request->validate([
            'admin_message' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'admin_message.required' =>
                'Please provide a reason for rejecting the request.',
        ]);


        if (
            $productRequest->admin_status !==
            'pending'
        ) {

            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }


        $productRequest->admin_status =
            'rejected';


        $productRequest->admin_message =
            $request->admin_message;


        $productRequest->save();


        return redirect()
            ->route(
                'admin.product.requests.index'
            )
            ->with(
                'success',
                'Request rejected successfully.'
            );
    }
}