<?php

namespace App\Http\Controllers;

use App\Models\User;

class OurImpectController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Overall Community Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalDonors = User::where('role', 'donor')->count();

        $totalBeneficiaries = User::where('role', 'beneficiary')->count();


        /*
        |--------------------------------------------------------------------------
        | Active Community
        |--------------------------------------------------------------------------
        */

        $activeUsers = User::where(
            'account_status',
            'active'
        )->count();

        $activeDonors = User::where('role', 'donor')
            ->where('account_status', 'active')
            ->count();

        $activeBeneficiaries = User::where('role', 'beneficiary')
            ->where('account_status', 'active')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Verified Community
        |--------------------------------------------------------------------------
        */

        $verifiedUsers = User::whereNotNull(
            'email_verified_at'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.home.ourimpact.index',
            compact(
                'totalUsers',
                'totalDonors',
                'totalBeneficiaries',
                'activeUsers',
                'activeDonors',
                'activeBeneficiaries',
                'verifiedUsers'
            )
        );
    }
}