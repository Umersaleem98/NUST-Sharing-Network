<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRequestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Request Management
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $requests = ProductRequest::with([
            'product.category',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ])
            ->latest()
            ->paginate(10);

        $requestStats = [
            'total' => ProductRequest::count(),

            'pending' => ProductRequest::where(
                'admin_status',
                'pending'
            )->count(),

            'approved' => ProductRequest::where(
                'admin_status',
                'approved'
            )->count(),

            'rejected' => ProductRequest::where(
                'admin_status',
                'rejected'
            )->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Beneficiaries And Donors On Current Page
        |--------------------------------------------------------------------------
        */

        $beneficiaryIds = $requests
            ->getCollection()
            ->pluck('beneficiary_id')
            ->filter()
            ->unique()
            ->values();

        $donorIds = $requests
            ->getCollection()
            ->pluck('donor_id')
            ->filter()
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Beneficiary Request History
        |--------------------------------------------------------------------------
        */

        $beneficiaryRequestHistory = ProductRequest::with([
            'product.category',
        ])
            ->whereIn('beneficiary_id', $beneficiaryIds)
            ->latest()
            ->get()
            ->groupBy('beneficiary_id');

        $beneficiaryRequestStats = [];

        foreach ($beneficiaryRequestHistory as $beneficiaryId => $history) {
            $pending = 0;
            $approved = 0;
            $rejected = 0;

            foreach ($history as $historyRequest) {
                if ($historyRequest->admin_status === 'pending') {
                    $pending++;
                }

                if ($historyRequest->admin_status === 'approved') {
                    $approved++;
                }

                if (
                    $historyRequest->admin_status === 'rejected'
                    || $historyRequest->donor_status === 'rejected'
                ) {
                    $rejected++;
                }
            }

            $beneficiaryRequestStats[$beneficiaryId] = [
                'total' => $history->count(),
                'pending' => $pending,
                'approved' => $approved,
                'rejected' => $rejected,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Donor Request History
        |--------------------------------------------------------------------------
        */

        $donorRequestHistory = ProductRequest::with([
            'product.category',
        ])
            ->whereIn('donor_id', $donorIds)
            ->latest()
            ->get()
            ->groupBy('donor_id');

        $donorRequestStats = [];

        foreach ($donorRequestHistory as $donorId => $history) {
            $waiting = 0;
            $approved = 0;
            $rejected = 0;

            foreach ($history as $historyRequest) {
                if (
                    $historyRequest->admin_status === 'approved'
                    && $historyRequest->donor_status === 'pending'
                ) {
                    $waiting++;
                }

                if (
                    in_array(
                        $historyRequest->donor_status,
                        ['approved', 'accepted'],
                        true
                    )
                ) {
                    $approved++;
                }

                if ($historyRequest->donor_status === 'rejected') {
                    $rejected++;
                }
            }

            $donorRequestStats[$donorId] = [
                'total' => $history->count(),
                'waiting' => $waiting,
                'approved' => $approved,
                'rejected' => $rejected,
            ];
        }

        return view(
            'pages.admin.requests.index',
            compact(
                'requests',
                'requestStats',
                'beneficiaryRequestHistory',
                'beneficiaryRequestStats',
                'donorRequestHistory',
                'donorRequestStats'
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

        $productRequest = ProductRequest::findOrFail($id);

        $newStatus = $validated['admin_status'];

        if ($productRequest->admin_status === $newStatus) {
            return back()->with(
                'info',
                'No changes were made because the request already has this status.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Admin Decision
        |--------------------------------------------------------------------------
        */

        $productRequest->admin_status = $newStatus;

        /*
        |--------------------------------------------------------------------------
        | Admin Rejected
        |--------------------------------------------------------------------------
        |
        | A rejected request must not remain approved by the donor and the
        | beneficiary must not retain access to donor information.
        |
        */

        if ($newStatus === 'rejected') {
            $productRequest->donor_status = 'pending';
            $productRequest->donor_information_allowed = false;
        }

        /*
        |--------------------------------------------------------------------------
        | Admin Approved
        |--------------------------------------------------------------------------
        |
        | Keep a previous final donor decision if one exists. New decisions use
        | approved/rejected; accepted is retained here only for legacy records.
        |
        */

        if (
            $newStatus === 'approved'
            && ! in_array(
                $productRequest->donor_status,
                ['approved', 'accepted', 'rejected'],
                true
            )
        ) {
            $productRequest->donor_status = 'pending';
        }

        $productRequest->save();

        return back()->with(
            'success',
            $newStatus === 'approved'
                ? 'Request approved successfully and is ready for donor review.'
                : 'Request rejected successfully.'
        );
    }
}
