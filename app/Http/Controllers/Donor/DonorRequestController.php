<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class DonorRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Donor Requests
    |--------------------------------------------------------------------------
    */
    public function donorRequests(): View
    {
        $requests = ProductRequest::query()
            ->with([
                'product',
                'beneficiary',
                'beneficiary.beneficiaryProfile',
            ])
            ->where(
                'donor_id',
                Auth::id()
            )
            ->where(
                'admin_status',
                'approved'
            )
            ->latest()
            ->paginate(10);

        return view(
            'pages.donor.request.index',
            compact('requests')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Donor Decision / Message / Information Permission
    |--------------------------------------------------------------------------
    */
    public function updateRequestStatus(
        Request $request,
        int $id
    ): RedirectResponse {
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
                    'The selected request status is invalid.',

                'message.string' =>
                    'The message must be valid text.',

                'message.max' =>
                    'The message cannot exceed 1000 characters.',

                'donor_information_allowed.boolean' =>
                    'The information access value is invalid.',
            ]
        );


        $productRequest = ProductRequest::query()
            ->where(
                'id',
                $id
            )
            ->where(
                'donor_id',
                Auth::id()
            )
            ->where(
                'admin_status',
                'approved'
            )
            ->firstOrFail();


        try {
            if (
                array_key_exists(
                    'donor_status',
                    $validated
                )
                && $validated['donor_status'] !== null
            ) {
                $productRequest->donor_status =
                    $validated['donor_status'];
            }


            /*
            |--------------------------------------------------------------------------
            | Lock Information Automatically for Pending / Rejected
            |--------------------------------------------------------------------------
            */
            if (
                in_array(
                    $productRequest->donor_status,
                    [
                        'pending',
                        'rejected',
                    ],
                    true
                )
            ) {
                $productRequest->donor_information_allowed =
                    false;
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
                $allowInformation =
                    (bool) $validated['donor_information_allowed'];

                $requestAccepted =
                    in_array(
                        $productRequest->donor_status,
                        [
                            'approved',
                            'accepted',
                        ],
                        true
                    );

                if (
                    $allowInformation
                    && ! $requestAccepted
                ) {
                    return back()->with(
                        'error',
                        'Accept the request before allowing the beneficiary to view your information.'
                    );
                }

                $productRequest->donor_information_allowed =
                    $allowInformation;
            }


            /*
            |--------------------------------------------------------------------------
            | Donor Message
            |--------------------------------------------------------------------------
            */
            if (
                array_key_exists(
                    'message',
                    $validated
                )
            ) {
                $productRequest->message =
                    ! empty($validated['message'])
                        ? trim($validated['message'])
                        : null;
            }


            $productRequest->save();


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

        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Request could not be updated. Please try again.'
                );
        }
    }
}
