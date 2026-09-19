<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class AdminRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Request Management
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $requests = ProductRequest::query()
            ->with([
                'product.category',
                'beneficiary.beneficiaryProfile',
                'donor.donorProfile',
            ])
            ->latest()
            ->paginate(10);

        $requestStats = [
            'total' => ProductRequest::query()->count(),

            'pending' => ProductRequest::query()
                ->where('admin_status', 'pending')
                ->count(),

            'approved' => ProductRequest::query()
                ->where('admin_status', 'approved')
                ->count(),

            'rejected' => ProductRequest::query()
                ->where('admin_status', 'rejected')
                ->count(),
        ];

        return view(
            'pages.admin.requests.index',
            compact(
                'requests',
                'requestStats'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Request Status
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        int $id
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'admin_status' => [
                    'required',
                    'in:approved,rejected',
                ],
            ],
            [
                'admin_status.required' =>
                    'Please select a request decision.',

                'admin_status.in' =>
                    'The selected request decision is invalid.',
            ]
        );

        $productRequest = ProductRequest::query()
            ->findOrFail($id);

        $newStatus =
            $validated['admin_status'];

        if (
            $productRequest->admin_status ===
            $newStatus
        ) {
            return back()->with(
                'info',
                'No changes were made because the request already has this status.'
            );
        }

        try {
            $productRequest->admin_status =
                $newStatus;

            /*
            |--------------------------------------------------------------------------
            | Donor Decision Rule
            |--------------------------------------------------------------------------
            |
            | Rejected by admin:
            | Always reset donor status to pending.
            |
            | Approved by admin:
            | Keep accepted/rejected donor decisions if they already exist.
            | Otherwise keep/reset donor status to pending.
            |
            */
            if ($newStatus === 'rejected') {
                $productRequest->donor_status =
                    'pending';
            }

            if ($newStatus === 'approved') {
                if (
                    ! in_array(
                        $productRequest->donor_status,
                        [
                            'accepted',
                            'rejected',
                        ],
                        true
                    )
                ) {
                    $productRequest->donor_status =
                        'pending';
                }
            }

            $productRequest->save();

            return back()->with(
                'success',
                'Request status updated successfully.'
            );

        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Request status could not be updated. Please try again.'
            );
        }
    }
}
