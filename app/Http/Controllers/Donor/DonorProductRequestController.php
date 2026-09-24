<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorProductRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Approved Requests
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | Donor can ONLY see:
    |
    | admin_status = approved
    | donor_id = current donor
    |
    */

    public function index(Request $request)
    {
        $status =
            $request->status;


        $requests = ProductRequest::with([
            'product.category',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ])

            /*
            |--------------------------------------------------------------------------
            | Only Current Donor
            |--------------------------------------------------------------------------
            */

            ->where(
                'donor_id',
                Auth::id()
            )


            /*
            |--------------------------------------------------------------------------
            | Admin Must Approve First
            |--------------------------------------------------------------------------
            */

            ->where(
                'admin_status',
                'approved'
            )


            /*
            |--------------------------------------------------------------------------
            | Donor Status
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $status,
                    [
                        'pending',
                        'accepted',
                        'rejected',
                    ],
                    true
                ),
                function ($query) use ($status) {

                    $query->where(
                        'donor_status',
                        $status
                    );
                }
            )


            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'pages.donor.product-requests.index',
            compact('requests')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | View Approved Request
    |--------------------------------------------------------------------------
    */

    public function show(ProductRequest $productRequest)
    {
        /*
        |--------------------------------------------------------------------------
        | Ownership
        |--------------------------------------------------------------------------
        */

        if (
            (int) $productRequest->donor_id !==
            (int) Auth::id()
        ) {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Must Be Admin Approved
        |--------------------------------------------------------------------------
        */

        if (
            $productRequest->admin_status !==
            'approved'
        ) {

            abort(404);
        }


        $productRequest->load([
            'product.category',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ]);


        return view(
            'pages.donor.product-requests.show',
            compact('productRequest')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Accept
    |--------------------------------------------------------------------------
    */

    public function accept(
        Request $request,
        ProductRequest $productRequest
    ) {
        if (
            (int) $productRequest->donor_id !==
            (int) Auth::id()
        ) {

            abort(403);
        }


        if (
            $productRequest->admin_status !==
            'approved'
        ) {

            abort(404);
        }


        if (
            $productRequest->donor_status !==
            'pending'
        ) {

            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }


        $request->validate([
            'donor_message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        $productRequest->donor_status =
            'accepted';


        $productRequest->donor_message =
            $request->donor_message;


        $productRequest->save();


        /*
        |--------------------------------------------------------------------------
        | Product Is No Longer Available
        |--------------------------------------------------------------------------
        */

        if ($productRequest->product) {

            $productRequest->product->status =
                'inactive';

            $productRequest->product->save();
        }


        return redirect()
            ->route(
                'donor.product.requests.index'
            )
            ->with(
                'success',
                'Request accepted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        ProductRequest $productRequest
    ) {
        if (
            (int) $productRequest->donor_id !==
            (int) Auth::id()
        ) {

            abort(403);
        }


        if (
            $productRequest->admin_status !==
            'approved'
        ) {

            abort(404);
        }


        if (
            $productRequest->donor_status !==
            'pending'
        ) {

            return back()->with(
                'error',
                'This request has already been reviewed.'
            );
        }


        $request->validate([
            'donor_message' => [
                'required',
                'string',
                'max:1000',
            ],
        ], [
            'donor_message.required' =>
                'Please provide a reason for rejecting this request.',
        ]);


        $productRequest->donor_status =
            'rejected';


        $productRequest->donor_message =
            $request->donor_message;


        $productRequest->save();


        return redirect()
            ->route(
                'donor.product.requests.index'
            )
            ->with(
                'success',
                'Request rejected successfully.'
            );
    }
}