<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryProfile;
use App\Models\Category;
use App\Models\DonorProfile;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user =
            Auth::user();


        $role =
            $user->role;



        /*
        |--------------------------------------------------------------------------
        | Common Notification Data
        |--------------------------------------------------------------------------
        */

        $notifications =
            $user
                ->notifications()
                ->latest()
                ->limit(8)
                ->get();


        $unreadNotificationsCount =
            $user
                ->unreadNotifications()
                ->count();



        /*
        |--------------------------------------------------------------------------
        | Base Dashboard Data
        |--------------------------------------------------------------------------
        */

        $data = [

            'user' =>
                $user,

            'role' =>
                $role,

            'notifications' =>
                $notifications,

            'unreadNotificationsCount' =>
                $unreadNotificationsCount,

        ];



        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {


            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            $data['totalUsers'] =
                User::count();


            $data['totalAdmins'] =
                User::where(
                    'role',
                    'admin'
                )
                ->count();


            $data['totalDonors'] =
                User::where(
                    'role',
                    'donor'
                )
                ->count();


            $data['totalBeneficiaries'] =
                User::where(
                    'role',
                    'beneficiary'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Account Status
            |--------------------------------------------------------------------------
            */

            $data['activeProfiles'] =
                User::where(
                    'profile_status',
                    'active'
                )
                ->count();


            $data['suspendedProfiles'] =
                User::where(
                    'profile_status',
                    'suspended'
                )
                ->count();


            $data['blockedProfiles'] =
                User::where(
                    'profile_status',
                    'blocked'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Profile Statistics
            |--------------------------------------------------------------------------
            */

            $data['donorProfiles'] =
                DonorProfile::count();


            $data['beneficiaryProfiles'] =
                BeneficiaryProfile::count();


            $data['donorsWithoutProfile'] =
                User::where(
                    'role',
                    'donor'
                )
                ->whereDoesntHave(
                    'donorProfile'
                )
                ->count();


            $data['beneficiariesWithoutProfile'] =
                User::where(
                    'role',
                    'beneficiary'
                )
                ->whereDoesntHave(
                    'beneficiaryProfile'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */

            $data['totalCategories'] =
                Category::count();


            $data['activeCategories'] =
                Category::where(
                    'status',
                    'active'
                )
                ->count();


            $data['inactiveCategories'] =
                Category::where(
                    'status',
                    'inactive'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */

            $data['totalProducts'] =
                Product::count();


            $data['activeProducts'] =
                Product::where(
                    'status',
                    'active'
                )
                ->count();


            $data['inactiveProducts'] =
                Product::where(
                    'status',
                    'inactive'
                )
                ->count();


            $data['donorProducts'] =
                Product::whereHas(
                    'creator',
                    function ($query) {

                        $query->where(
                            'role',
                            'donor'
                        );
                    }
                )
                ->count();


            $data['adminProducts'] =
                Product::whereHas(
                    'creator',
                    function ($query) {

                        $query->where(
                            'role',
                            'admin'
                        );
                    }
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Product Requests
            |--------------------------------------------------------------------------
            */

            $data['totalRequests'] =
                ProductRequest::count();


            $data['pendingAdminRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'pending'
                )
                ->count();


            $data['approvedAdminRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'approved'
                )
                ->count();


            $data['rejectedAdminRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'rejected'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Donor Request Status
            |--------------------------------------------------------------------------
            */

            $data['pendingDonorRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'approved'
                )
                ->whereNotNull(
                    'donor_id'
                )
                ->where(
                    'donor_status',
                    'pending'
                )
                ->count();


            $data['acceptedDonorRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'approved'
                )
                ->where(
                    'donor_status',
                    'accepted'
                )
                ->count();


            $data['rejectedDonorRequests'] =
                ProductRequest::where(
                    'admin_status',
                    'approved'
                )
                ->where(
                    'donor_status',
                    'rejected'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Institution Wise Beneficiaries
            |--------------------------------------------------------------------------
            */

            $data['institutionWise'] =
                BeneficiaryProfile::select(
                    'institution'
                )
                ->selectRaw(
                    'COUNT(*) as total'
                )
                ->whereNotNull(
                    'institution'
                )
                ->where(
                    'institution',
                    '!=',
                    ''
                )
                ->groupBy(
                    'institution'
                )
                ->orderByDesc(
                    'total'
                )
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Category Product Statistics
            |--------------------------------------------------------------------------
            */

            $data['categoryProductStats'] =
                Category::withCount([

                    'products',

                    'products as active_products_count' =>
                        function ($query) {

                            $query->where(
                                'status',
                                'active'
                            );
                        },

                    'products as inactive_products_count' =>
                        function ($query) {

                            $query->where(
                                'status',
                                'inactive'
                            );
                        },

                ])
                ->orderByDesc(
                    'products_count'
                )
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Users
            |--------------------------------------------------------------------------
            */

            $data['latestUsers'] =
                User::latest()
                    ->limit(8)
                    ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Products
            |--------------------------------------------------------------------------
            */

            $data['latestProducts'] =
                Product::with([
                    'category',
                    'creator',
                ])
                ->latest()
                ->limit(8)
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Requests
            |--------------------------------------------------------------------------
            */

            $data['latestRequests'] =
                ProductRequest::with([

                    'product.category',

                    'beneficiary',

                    'donor',

                ])
                ->latest()
                ->limit(8)
                ->get();


            return view(
                'dashboard',
                $data
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Donor Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'donor') {


            $donorProfile =
                $user->donorProfile;


            $data['donorProfile'] =
                $donorProfile;



            /*
            |--------------------------------------------------------------------------
            | Profile Completion
            |--------------------------------------------------------------------------
            */

            $profileFields = [

                $user->name,

                $user->email,

                $donorProfile?->phone,

                $donorProfile?->organization,

                $donorProfile?->designation,

                $donorProfile?->country,

                $donorProfile?->state,

                $donorProfile?->city,

                $donorProfile?->profile_image,

            ];


            $completedFields =
                collect(
                    $profileFields
                )
                ->filter(
                    function ($value) {

                        return
                            $value !== null &&
                            $value !== '';
                    }
                )
                ->count();


            $data['profileCompletion'] =
                count($profileFields) > 0
                    ? (int) round(
                        (
                            $completedFields /
                            count($profileFields)
                        ) * 100
                    )
                    : 0;



            /*
            |--------------------------------------------------------------------------
            | My Products
            |--------------------------------------------------------------------------
            */

            $data['myProducts'] =
                Product::where(
                    'user_id',
                    $user->id
                )
                ->count();


            $data['myActiveProducts'] =
                Product::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    'active'
                )
                ->count();


            $data['myInactiveProducts'] =
                Product::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    'inactive'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | My Approved Requests
            |--------------------------------------------------------------------------
            */

            $donorRequestQuery =
                ProductRequest::where(
                    'donor_id',
                    $user->id
                )
                ->where(
                    'admin_status',
                    'approved'
                );


            $data['myTotalRequests'] =
                (clone $donorRequestQuery)
                    ->count();


            $data['myPendingRequests'] =
                (clone $donorRequestQuery)
                    ->where(
                        'donor_status',
                        'pending'
                    )
                    ->count();


            $data['myAcceptedRequests'] =
                (clone $donorRequestQuery)
                    ->where(
                        'donor_status',
                        'accepted'
                    )
                    ->count();


            $data['myRejectedRequests'] =
                (clone $donorRequestQuery)
                    ->where(
                        'donor_status',
                        'rejected'
                    )
                    ->count();



            /*
            |--------------------------------------------------------------------------
            | Category Statistics
            |--------------------------------------------------------------------------
            */

            $data['myCategoryStats'] =
                Category::whereHas(
                    'products',
                    function ($query) use ($user) {

                        $query->where(
                            'user_id',
                            $user->id
                        );
                    }
                )
                ->withCount([

                    'products as products_count' =>
                        function ($query) use ($user) {

                            $query->where(
                                'user_id',
                                $user->id
                            );
                        },

                ])
                ->orderByDesc(
                    'products_count'
                )
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Products
            |--------------------------------------------------------------------------
            */

            $data['latestMyProducts'] =
                Product::with(
                    'category'
                )
                ->where(
                    'user_id',
                    $user->id
                )
                ->latest()
                ->limit(8)
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Requests
            |--------------------------------------------------------------------------
            */

            $data['latestDonorRequests'] =
                ProductRequest::with([

                    'product.category',

                    'beneficiary.beneficiaryProfile',

                ])
                ->where(
                    'donor_id',
                    $user->id
                )
                ->where(
                    'admin_status',
                    'approved'
                )
                ->latest()
                ->limit(8)
                ->get();


            return view(
                'dashboard',
                $data
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Beneficiary Dashboard
        |--------------------------------------------------------------------------
        */

        if ($role === 'beneficiary') {


            $beneficiaryProfile =
                $user->beneficiaryProfile;


            $data['beneficiaryProfile'] =
                $beneficiaryProfile;



            /*
            |--------------------------------------------------------------------------
            | Profile Completion
            |--------------------------------------------------------------------------
            */

            $profileFields = [

                $user->name,

                $user->email,

                $user->qalam_id,

                $beneficiaryProfile?->phone,

                $beneficiaryProfile?->gender,

                $beneficiaryProfile?->institution,

                $beneficiaryProfile?->degree,

                $beneficiaryProfile?->enrollment_year,

                $beneficiaryProfile?->graduation_year,

                $beneficiaryProfile?->father_status,

                $beneficiaryProfile?->guardian_profession,

                $beneficiaryProfile?->monthly_income,

                $beneficiaryProfile?->province,

                $beneficiaryProfile?->domicile,

                $beneficiaryProfile?->home_address,

                $beneficiaryProfile?->profile_image,

            ];


            $completedFields =
                collect(
                    $profileFields
                )
                ->filter(
                    function ($value) {

                        return
                            $value !== null &&
                            $value !== '';
                    }
                )
                ->count();


            $data['profileCompletion'] =
                count($profileFields) > 0
                    ? (int) round(
                        (
                            $completedFields /
                            count($profileFields)
                        ) * 100
                    )
                    : 0;



            /*
            |--------------------------------------------------------------------------
            | Available Products
            |--------------------------------------------------------------------------
            */

            $data['availableProducts'] =
                Product::where(
                    'status',
                    'active'
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | Available Categories
            |--------------------------------------------------------------------------
            */

            $data['availableCategories'] =
                Category::where(
                    'status',
                    'active'
                )
                ->whereHas(
                    'products',
                    function ($query) {

                        $query->where(
                            'status',
                            'active'
                        );
                    }
                )
                ->count();



            /*
            |--------------------------------------------------------------------------
            | My Requests
            |--------------------------------------------------------------------------
            */

            $beneficiaryRequestQuery =
                ProductRequest::where(
                    'beneficiary_id',
                    $user->id
                );


            $data['myRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->count();


            $data['myAdminPendingRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->where(
                        'admin_status',
                        'pending'
                    )
                    ->count();


            $data['myAdminApprovedRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->where(
                        'admin_status',
                        'approved'
                    )
                    ->count();


            $data['myAdminRejectedRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->where(
                        'admin_status',
                        'rejected'
                    )
                    ->count();


            $data['myDonorAcceptedRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->where(
                        'admin_status',
                        'approved'
                    )
                    ->where(
                        'donor_status',
                        'accepted'
                    )
                    ->count();


            $data['myDonorRejectedRequests'] =
                (clone $beneficiaryRequestQuery)
                    ->where(
                        'admin_status',
                        'approved'
                    )
                    ->where(
                        'donor_status',
                        'rejected'
                    )
                    ->count();



            /*
            |--------------------------------------------------------------------------
            | Available Products Category Wise
            |--------------------------------------------------------------------------
            */

            $data['availableCategoryStats'] =
                Category::where(
                    'status',
                    'active'
                )
                ->withCount([

                    'products as active_products_count' =>
                        function ($query) {

                            $query->where(
                                'status',
                                'active'
                            );
                        },

                ])
                ->having(
                    'active_products_count',
                    '>',
                    0
                )
                ->orderByDesc(
                    'active_products_count'
                )
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Available Products
            |--------------------------------------------------------------------------
            */

            $data['latestAvailableProducts'] =
                Product::with([
                    'category',
                    'creator',
                ])
                ->where(
                    'status',
                    'active'
                )
                ->latest()
                ->limit(8)
                ->get();



            /*
            |--------------------------------------------------------------------------
            | Latest Requests
            |--------------------------------------------------------------------------
            */

            $data['latestMyRequests'] =
                ProductRequest::with([
                    'product.category',
                    'donor',
                ])
                ->where(
                    'beneficiary_id',
                    $user->id
                )
                ->latest()
                ->limit(8)
                ->get();


            return view(
                'dashboard',
                $data
            );
        }



        /*
        |--------------------------------------------------------------------------
        | Unsupported Role
        |--------------------------------------------------------------------------
        */

        abort(
            403,
            'Unauthorized dashboard access.'
        );
    }
}