<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DonorRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Donor Requests
    |--------------------------------------------------------------------------
    */

    public function donorRequests(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Authenticated Donor
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Get Approved Requests Assigned To Donor
        |--------------------------------------------------------------------------
        */

        $requests = ProductRequest::with([
            'product.category',
            'beneficiary.beneficiaryProfile',
        ])
            ->where('donor_id', $user->id)
            ->where('admin_status', 'approved')
            ->latest()
            ->paginate(10);


        return view(
            'pages.donor.request.index',
            compact('requests')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Request
    |--------------------------------------------------------------------------
    */

    public function updateRequestStatus(
        Request $request,
        int $id
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Authenticated Donor
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

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
                'donor_status' => [
                    'nullable',
                    'required_without_all:message,donor_information_allowed',
                    'in:pending,approved,rejected',
                ],

                'message' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'donor_information_allowed' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'donor_status.required_without_all' =>
                    'Please select a request status, enter a message, or update information access.',

                'donor_status.in' =>
                    'Please select a valid request status.',

                'message.string' =>
                    'The message must contain valid text.',

                'message.max' =>
                    'The message cannot exceed 1000 characters.',

                'donor_information_allowed.boolean' =>
                    'The donor information permission is invalid.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Find Donor Request
        |--------------------------------------------------------------------------
        |
        | Donor can only update:
        |
        | 1. Their own request
        | 2. A request approved by admin
        |
        */

        $productRequest = ProductRequest::where('id', $id)
            ->where('donor_id', $user->id)
            ->where('admin_status', 'approved')
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Update Donor Status
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['donor_status'])) {

            $productRequest->donor_status =
                $validated['donor_status'];
        }


        /*
        |--------------------------------------------------------------------------
        | Automatically Revoke Information Access
        |--------------------------------------------------------------------------
        |
        | Beneficiary should not see donor information when request is:
        |
        | pending
        | rejected
        |
        */

        if (
            in_array(
                $productRequest->donor_status,
                ['pending', 'rejected'],
                true
            )
        ) {
            $productRequest->donor_information_allowed = false;
        }


        /*
        |--------------------------------------------------------------------------
        | Donor Information Permission
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'donor_information_allowed',
                $validated
            )
        ) {

            $allowInformation = $request->boolean(
                'donor_information_allowed'
            );


            /*
            |--------------------------------------------------------------------------
            | Information Can Only Be Shared After Approval
            |--------------------------------------------------------------------------
            */

            if (
                $allowInformation
                && $productRequest->donor_status !== 'approved'
            ) {
                return back()->with(
                    'error',
                    'Approve the request before allowing the beneficiary to view your information.'
                );
            }


            $productRequest->donor_information_allowed =
                $allowInformation;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Donor Message
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'message',
                $validated
            )
        ) {

            $productRequest->message =
                filled($validated['message'])
                    ? trim($validated['message'])
                    : null;
        }


        /*
        |--------------------------------------------------------------------------
        | Save Request
        |--------------------------------------------------------------------------
        */

        $productRequest->save();


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                'donor_information_allowed',
                $validated
            )
        ) {

            return back()->with(
                'success',
                $productRequest->donor_information_allowed
                    ? 'Beneficiary can now view your donor information.'
                    : 'Beneficiary access to your donor information has been revoked.'
            );
        }


        return back()->with(
            'success',
            'Request updated successfully.'
        );
    }
}