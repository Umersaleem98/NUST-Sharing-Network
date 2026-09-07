<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DonorTermAcceptance;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard according to authenticated user role.
     */
    public function index()
    {
        $user = Auth::user();

        $user->load([
            'beneficiaryProfile',
            'donorProfile',
            'termAcceptance',
        ]);

        return match ($user->role) {
            'admin' => $this->adminDashboard($user),
            'donor' => $this->donorDashboard($user),
            'beneficiary' => $this->beneficiaryDashboard($user),
            default => abort(403, 'Unauthorized dashboard access.'),
        };
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    private function adminDashboard(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalAdmins = User::where('role', 'admin')->count();

        $totalDonors = User::where('role', 'donor')->count();

        $totalBeneficiaries = User::where(
            'role',
            'beneficiary'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Account Status Statistics
        |--------------------------------------------------------------------------
        */

        $activeUsers = User::where(
            'account_status',
            'active'
        )->count();

        $suspendedUsers = User::where(
            'account_status',
            'suspended'
        )->count();

        $blockedUsers = User::where(
            'account_status',
            'blocked'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Product Statistics
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalCategories = Category::count();


        /*
        |--------------------------------------------------------------------------
        | Request Statistics
        |--------------------------------------------------------------------------
        */

        $totalRequests = ProductRequest::count();


        // Admin decisions
        $pendingAdmin = ProductRequest::where(
            'admin_status',
            'pending'
        )->count();

        $approvedByAdmin = ProductRequest::where(
            'admin_status',
            'approved'
        )->count();

        $rejectedByAdmin = ProductRequest::where(
            'admin_status',
            'rejected'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Donor Decisions
        |--------------------------------------------------------------------------
        |
        | Your current project contains both "accepted" and "approved"
        | values in donor_status. Both are counted as accepted here.
        |
        */

        $pendingDonor = ProductRequest::where(
            'donor_status',
            'pending'
        )->count();

        $acceptedByDonor = ProductRequest::whereIn(
            'donor_status',
            [
                'accepted',
                'approved',
            ]
        )->count();

        $rejectedByDonor = ProductRequest::where(
            'donor_status',
            'rejected'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Request Completion / Success
        |--------------------------------------------------------------------------
        */

        $completedRequests = ProductRequest::where(
            'admin_status',
            'approved'
        )
            ->whereIn(
                'donor_status',
                [
                    'accepted',
                    'approved',
                ]
            )
            ->count();


        $requestSuccessRate = $totalRequests > 0
            ? round(
                ($completedRequests / $totalRequests) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Current Month Statistics
        |--------------------------------------------------------------------------
        */

        $newUsersThisMonth = User::whereYear(
            'created_at',
            now()->year
        )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->count();


        $newProductsThisMonth = Product::whereYear(
            'created_at',
            now()->year
        )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->count();


        $newRequestsThisMonth = ProductRequest::whereYear(
            'created_at',
            now()->year
        )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Chart Data
        |--------------------------------------------------------------------------
        */

        $usersChart = [
            $totalAdmins,
            $totalDonors,
            $totalBeneficiaries,
        ];


        $accountStatusChart = [
            $activeUsers,
            $suspendedUsers,
            $blockedUsers,
        ];


        $requestChart = [
            $pendingAdmin,
            $approvedByAdmin,
            $rejectedByAdmin,
        ];


        $donorDecisionChart = [
            $acceptedByDonor,
            $rejectedByDonor,
            $pendingDonor,
        ];


        /*
        |--------------------------------------------------------------------------
        | Monthly Requests
        |--------------------------------------------------------------------------
        */

        $monthlyRequests = ProductRequest::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupBy(
                DB::raw('MONTH(created_at)')
            )
            ->pluck(
                'total',
                'month'
            );


        $requestMonths = [];

        $requestCounts = [];


        for ($month = 1; $month <= 12; $month++) {

            $requestMonths[] = Carbon::create()
                ->month($month)
                ->format('M');

            $requestCounts[] =
                (int) ($monthlyRequests[$month] ?? 0);
        }


        /*
        |--------------------------------------------------------------------------
        | Monthly User Registrations
        |--------------------------------------------------------------------------
        */

        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->groupBy(
                DB::raw('MONTH(created_at)')
            )
            ->pluck(
                'total',
                'month'
            );


        $userRegistrationCounts = [];


        for ($month = 1; $month <= 12; $month++) {

            $userRegistrationCounts[] =
                (int) ($monthlyUsers[$month] ?? 0);
        }


        /*
        |--------------------------------------------------------------------------
        | Recent Users
        |--------------------------------------------------------------------------
        */

        $recentUsers = User::with([
            'beneficiaryProfile',
            'donorProfile',
        ])
            ->latest()
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Products
        |--------------------------------------------------------------------------
        */

        $recentProducts = Product::with([
            'user',
            'category',
        ])
            ->latest()
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Requests
        |--------------------------------------------------------------------------
        */

        $recentRequests = ProductRequest::with([
            'product',
            'beneficiary.beneficiaryProfile',
            'donor.donorProfile',
        ])
            ->latest()
            ->take(8)
            ->get();


        return view(
            'dashboard',
            compact(
                'user',

                'totalUsers',
                'totalAdmins',
                'totalDonors',
                'totalBeneficiaries',

                'activeUsers',
                'suspendedUsers',
                'blockedUsers',

                'totalProducts',
                'totalCategories',

                'totalRequests',
                'pendingAdmin',
                'approvedByAdmin',
                'rejectedByAdmin',

                'pendingDonor',
                'acceptedByDonor',
                'rejectedByDonor',

                'completedRequests',
                'requestSuccessRate',

                'newUsersThisMonth',
                'newProductsThisMonth',
                'newRequestsThisMonth',

                'usersChart',
                'accountStatusChart',
                'requestChart',
                'donorDecisionChart',

                'requestMonths',
                'requestCounts',
                'userRegistrationCounts',

                'recentUsers',
                'recentProducts',
                'recentRequests'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DONOR DASHBOARD
    |--------------------------------------------------------------------------
    */

    private function donorDashboard(User $user)
    {
        $profile = $user->donorProfile;


        /*
        |--------------------------------------------------------------------------
        | Profile Completion
        |--------------------------------------------------------------------------
        */

        $profileFields = [
            $user->name,
            $user->email,
            $user->phone,
            $user->image,

            $profile?->organization,
            $profile?->designation,
            $profile?->country,
            $profile?->address,
        ];


        $profileCompletion =
            $this->calculateProfileCompletion(
                $profileFields
            );


        /*
        |--------------------------------------------------------------------------
        | Product Statistics
        |--------------------------------------------------------------------------
        */

        $myProducts = Product::where(
            'user_id',
            $user->id
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Incoming Requests
        |--------------------------------------------------------------------------
        */

        $incomingRequests = ProductRequest::where(
            'donor_id',
            $user->id
        )
            ->where(
                'admin_status',
                'approved'
            )
            ->count();


        $pendingRequests = ProductRequest::where(
            'donor_id',
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
            ->count();


        $acceptedRequests = ProductRequest::where(
            'donor_id',
            $user->id
        )
            ->whereIn(
                'donor_status',
                [
                    'accepted',
                    'approved',
                ]
            )
            ->count();


        $rejectedRequests = ProductRequest::where(
            'donor_id',
            $user->id
        )
            ->where(
                'donor_status',
                'rejected'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Decision Rate
        |--------------------------------------------------------------------------
        */

        $decidedRequests =
            $acceptedRequests +
            $rejectedRequests;


        $responseRate = $incomingRequests > 0
            ? round(
                ($decidedRequests / $incomingRequests)
                * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Recent Products
        |--------------------------------------------------------------------------
        */

        $recentProducts = Product::with([
            'category',
        ])
            ->where(
                'user_id',
                $user->id
            )
            ->latest()
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Incoming Requests
        |--------------------------------------------------------------------------
        */

        $recentIncomingRequests =
            ProductRequest::with([
                'product',
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
                ->take(6)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Donor Chart
        |--------------------------------------------------------------------------
        */

        $donorRequestChart = [
            $pendingRequests,
            $acceptedRequests,
            $rejectedRequests,
        ];


        return view(
            'dashboard',
            compact(
                'user',
                'profile',
                'profileCompletion',

                'myProducts',
                'incomingRequests',
                'pendingRequests',
                'acceptedRequests',
                'rejectedRequests',

                'responseRate',

                'recentProducts',
                'recentIncomingRequests',
                'donorRequestChart'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BENEFICIARY DASHBOARD
    |--------------------------------------------------------------------------
    */

    private function beneficiaryDashboard(User $user)
    {
        $profile =
            $user->beneficiaryProfile;


        /*
        |--------------------------------------------------------------------------
        | Profile Completion
        |--------------------------------------------------------------------------
        */

        $profileFields = [
            $user->name,
            $user->email,
            $user->phone,
            $user->image,
            $user->qalam_id,

            $profile?->gender,
            $profile?->institution,
            $profile?->degree_level,
            $profile?->degree_program,
            $profile?->department,
            $profile?->semester,
            $profile?->cgpa,
            $profile?->enrollment_year,
            $profile?->graduation_year,

            $profile?->father_status,
            $profile?->guardian_profession,
            $profile?->monthly_income,

            $profile?->province,
            $profile?->domicile,
            $profile?->home_address,
        ];


        $profileCompletion =
            $this->calculateProfileCompletion(
                $profileFields
            );


        /*
        |--------------------------------------------------------------------------
        | Request Statistics
        |--------------------------------------------------------------------------
        */

        $myRequests = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )->count();


        $pending = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )
            ->where(
                'admin_status',
                'pending'
            )
            ->count();


        $approved = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )
            ->where(
                'admin_status',
                'approved'
            )
            ->count();


        $adminRejected = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )
            ->where(
                'admin_status',
                'rejected'
            )
            ->count();


        $accepted = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )
            ->whereIn(
                'donor_status',
                [
                    'accepted',
                    'approved',
                ]
            )
            ->count();


        $donorPending = ProductRequest::where(
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
            ->count();


        $donorRejected = ProductRequest::where(
            'beneficiary_id',
            $user->id
        )
            ->where(
                'donor_status',
                'rejected'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Success Rate
        |--------------------------------------------------------------------------
        */

        $successRate = $myRequests > 0
            ? round(
                ($accepted / $myRequests) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Recent Requests
        |--------------------------------------------------------------------------
        */

        $recentMyRequests =
            ProductRequest::with([
                'product',
                'donor.donorProfile',
            ])
                ->where(
                    'beneficiary_id',
                    $user->id
                )
                ->latest()
                ->take(8)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | Beneficiary Chart
        |--------------------------------------------------------------------------
        */

        $beneficiaryRequestChart = [
            $pending,
            $approved,
            $adminRejected,
        ];


        $beneficiaryDonorChart = [
            $donorPending,
            $accepted,
            $donorRejected,
        ];


        return view(
            'dashboard',
            compact(
                'user',
                'profile',
                'profileCompletion',

                'myRequests',
                'pending',
                'approved',
                'adminRejected',

                'accepted',
                'donorPending',
                'donorRejected',

                'successRate',

                'recentMyRequests',

                'beneficiaryRequestChart',
                'beneficiaryDonorChart'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROFILE COMPLETION HELPER
    |--------------------------------------------------------------------------
    */

    private function calculateProfileCompletion(
        array $fields
    ): int {
        if (count($fields) === 0) {
            return 0;
        }

        $completed = collect($fields)
            ->filter(
                fn ($field) =>
                    ! is_null($field)
                    &&
                    trim((string) $field) !== ''
            )
            ->count();

        return (int) round(
            ($completed / count($fields)) * 100
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCEPT DONOR TERMS
    |--------------------------------------------------------------------------
    */

    public function acceptTerms()
    {
        $donorId = Auth::id();


        $acceptance =
            DonorTermAcceptance::where(
                'donor_id',
                $donorId
            )->first();


        if (! $acceptance) {

            DonorTermAcceptance::create([
                'donor_id' => $donorId,
                'accepted' => 1,
                'accepted_at' => now(),
            ]);
        }


        return redirect()
            ->back()
            ->with(
                'success',
                'Terms accepted successfully.'
            );
    }
}