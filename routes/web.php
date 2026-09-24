<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductRequestController;
use App\Http\Controllers\Admin\AdminStudentStoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Beneficiary\BeneficiaryProductsController;
use App\Http\Controllers\Beneficiary\BeneficiaryProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Donor\DonorProductController;
use App\Http\Controllers\Donor\DonorProductRequestController;
use App\Http\Controllers\Donor\DonorProfileController;
use App\Http\Controllers\ExploreNeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OurImpectController;
use Illuminate\Support\Facades\Route;







Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore-needs',[HomeController::class, 'exploreNeed'])->name('explore.needs');
Route::get('/our-impact',[HomeController::class, 'ourImpact'])->name('our.impact');
Route::get('/student-stories',[HomeController::class, 'studentStories'])->name('student-stories.index');

Route::post(
    '/contact-us',
    [HomeController::class, 'contactStore']
)->name('contact.store');


Route::middleware('auth')->group(function () {

    Route::patch(
        '/notifications/{notification}/read',
        [NotificationController::class, 'markAsRead']
    )->name('notifications.read');


    Route::patch(
        '/notifications/read-all',
        [NotificationController::class, 'markAllAsRead']
    )->name('notifications.read-all');

});



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'loginPage']
)->name('login');


Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.submit');


Route::get(
    '/register',
    [AuthController::class, 'registerPage']
)->name('register');


Route::post(
    '/register',
    [AuthController::class, 'register']
)->name('register.submit');


/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get(
    '/email/verify',
    [AuthController::class, 'verificationNotice']
)->name('verification.notice');


Route::get(
    '/email/verify/{user}/{token}',
    [AuthController::class, 'verifyEmail']
)
    ->middleware('throttle:6,1')
    ->name('verification.verify');


Route::post(
    '/email/verification/resend',
    [AuthController::class, 'resendVerification']
)
    ->middleware('throttle:3,1')
    ->name('verification.resend');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');



/*
|--------------------------------------------------------------------------
| Admin Users
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/users',
    [AdminUserController::class, 'index']
)
    ->middleware('role:admin')
    ->name('admin.users.index');


Route::post(
    '/admin/users',
    [AdminUserController::class, 'store']
)
    ->middleware('role:admin')
    ->name('admin.users.store');


/*
|--------------------------------------------------------------------------
| Import
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/users/import',
    [AdminUserController::class, 'import']
)
    ->middleware('role:admin')
    ->name('admin.users.import');


Route::get(
    '/admin/users/import/template',
    [AdminUserController::class, 'downloadTemplate']
)
    ->middleware('role:admin')
    ->name('admin.users.import.template');


/*
|--------------------------------------------------------------------------
| Selected Export
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/users/export-selected',
    [AdminUserController::class, 'exportSelected']
)
    ->middleware('role:admin')
    ->name('admin.users.export.selected');


/*
|--------------------------------------------------------------------------
| Selected Delete
|--------------------------------------------------------------------------
*/

Route::delete(
    '/admin/users/bulk-delete',
    [AdminUserController::class, 'bulkDestroy']
)
    ->middleware('role:admin')
    ->name('admin.users.bulk.destroy');


/*
|--------------------------------------------------------------------------
| Edit User Page
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/users/{user}/edit',
    [AdminUserController::class, 'edit']
)
    ->middleware('role:admin')
    ->name('admin.users.edit');


/*
|--------------------------------------------------------------------------
| Update User
|--------------------------------------------------------------------------
*/

Route::put(
    '/admin/users/{user}',
    [AdminUserController::class, 'update']
)
    ->middleware('role:admin')
    ->name('admin.users.update');


/*
|--------------------------------------------------------------------------
| Delete User
|--------------------------------------------------------------------------
*/

Route::delete(
    '/admin/users/{user}',
    [AdminUserController::class, 'destroy']
)
    ->middleware('role:admin')
    ->name('admin.users.destroy');


    /*
|--------------------------------------------------------------------------
| Admin Categories
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/categories',
    [AdminCategoryController::class, 'index']
)
    ->middleware('role:admin')
    ->name('admin.categories.index');


Route::get(
    '/admin/categories/create',
    [AdminCategoryController::class, 'create']
)
    ->middleware('role:admin')
    ->name('admin.categories.create');


Route::post(
    '/admin/categories',
    [AdminCategoryController::class, 'store']
)
    ->middleware('role:admin')
    ->name('admin.categories.store');


Route::get(
    '/admin/categories/{category}/edit',
    [AdminCategoryController::class, 'edit']
)
    ->middleware('role:admin')
    ->name('admin.categories.edit');


Route::put(
    '/admin/categories/{category}',
    [AdminCategoryController::class, 'update']
)
    ->middleware('role:admin')
    ->name('admin.categories.update');


Route::delete(
    '/admin/categories/{category}',
    [AdminCategoryController::class, 'destroy']
)
    ->middleware('role:admin')
    ->name('admin.categories.destroy');

    /*
|--------------------------------------------------------------------------
| Admin Products
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/products',
    [AdminProductController::class, 'index']
)
    ->middleware('role:admin')
    ->name('admin.products.index');


Route::get(
    '/admin/products/create',
    [AdminProductController::class, 'create']
)
    ->middleware('role:admin')
    ->name('admin.products.create');


Route::post(
    '/admin/products',
    [AdminProductController::class, 'store']
)
    ->middleware('role:admin')
    ->name('admin.products.store');


Route::get(
    '/admin/products/{product}/edit',
    [AdminProductController::class, 'edit']
)
    ->middleware('role:admin')
    ->name('admin.products.edit');


Route::put(
    '/admin/products/{product}',
    [AdminProductController::class, 'update']
)
    ->middleware('role:admin')
    ->name('admin.products.update');


Route::delete(
    '/admin/products/{product}',
    [AdminProductController::class, 'destroy']
)
    ->middleware('role:admin')
    ->name('admin.products.destroy');

/*
|--------------------------------------------------------------------------
| Admin Product Requests
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/product-requests',
    [AdminProductRequestController::class, 'index']
)
    ->middleware('role:admin')
    ->name('admin.product.requests.index');


Route::get(
    '/admin/product-requests/{productRequest}',
    [AdminProductRequestController::class, 'show']
)
    ->middleware('role:admin')
    ->name('admin.product.requests.show');


Route::patch(
    '/admin/product-requests/{productRequest}/approve',
    [AdminProductRequestController::class, 'approve']
)
    ->middleware('role:admin')
    ->name('admin.product.requests.approve');


Route::patch(
    '/admin/product-requests/{productRequest}/reject',
    [AdminProductRequestController::class, 'reject']
)
    ->middleware('role:admin')
    ->name('admin.product.requests.reject');


    Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth',
        'role:admin',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Contact Messages
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/contacts',
            [AdminContactController::class, 'index']
        )->name('contacts.index');


        Route::get(
            '/contacts/{contact}',
            [AdminContactController::class, 'show']
        )->name('contacts.show');


        Route::patch(
            '/contacts/{contact}/resolve',
            [AdminContactController::class, 'resolve']
        )->name('contacts.resolve');


        Route::delete(
            '/contacts/{contact}',
            [AdminContactController::class, 'destroy']
        )->name('contacts.destroy');

    });


    /*
|--------------------------------------------------------------------------
| Admin Student Stories
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/student-stories',
    [AdminStudentStoryController::class, 'index']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.index');


Route::get(
    '/admin/student-stories/create',
    [AdminStudentStoryController::class, 'create']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.create');


Route::post(
    '/admin/student-stories',
    [AdminStudentStoryController::class, 'store']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.store');


Route::get(
    '/admin/student-stories/{studentStory}',
    [AdminStudentStoryController::class, 'show']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.show');


Route::get(
    '/admin/student-stories/{studentStory}/edit',
    [AdminStudentStoryController::class, 'edit']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.edit');


Route::put(
    '/admin/student-stories/{studentStory}',
    [AdminStudentStoryController::class, 'update']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.update');


Route::delete(
    '/admin/student-stories/{studentStory}',
    [AdminStudentStoryController::class, 'destroy']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student-stories.destroy');


    /*
|--------------------------------------------------------------------------
| Donor Profile
|--------------------------------------------------------------------------
*/

Route::get(
    '/donor/profile',
    [DonorProfileController::class, 'show']
)
    ->middleware('role:donor')
    ->name('donor.profile.show');


Route::get(
    '/donor/profile/edit',
    [DonorProfileController::class, 'edit']
)
    ->middleware('role:donor')
    ->name('donor.profile.edit');


Route::put(
    '/donor/profile',
    [DonorProfileController::class, 'update']
)
    ->middleware('role:donor')
    ->name('donor.profile.update');

    /*
|--------------------------------------------------------------------------
| Donor Products
|--------------------------------------------------------------------------
*/

Route::get(
    '/donor/products',
    [DonorProductController::class, 'index']
)
    ->middleware('role:donor')
    ->name('donor.products.index');


Route::get(
    '/donor/products/create',
    [DonorProductController::class, 'create']
)
    ->middleware('role:donor')
    ->name('donor.products.create');


Route::post(
    '/donor/products',
    [DonorProductController::class, 'store']
)
    ->middleware('role:donor')
    ->name('donor.products.store');


Route::get(
    '/donor/products/{product}/edit',
    [DonorProductController::class, 'edit']
)
    ->middleware('role:donor')
    ->name('donor.products.edit');


Route::put(
    '/donor/products/{product}',
    [DonorProductController::class, 'update']
)
    ->middleware('role:donor')
    ->name('donor.products.update');


Route::delete(
    '/donor/products/{product}',
    [DonorProductController::class, 'destroy']
)
    ->middleware('role:donor')
    ->name('donor.products.destroy');


    /*
|--------------------------------------------------------------------------
| Donor Product Requests
|--------------------------------------------------------------------------
*/

Route::get(
    '/donor/product-requests',
    [DonorProductRequestController::class, 'index']
)
    ->middleware('role:donor')
    ->name('donor.product.requests.index');


Route::get(
    '/donor/product-requests/{productRequest}',
    [DonorProductRequestController::class, 'show']
)
    ->middleware('role:donor')
    ->name('donor.product.requests.show');


Route::patch(
    '/donor/product-requests/{productRequest}/accept',
    [DonorProductRequestController::class, 'accept']
)
    ->middleware('role:donor')
    ->name('donor.product.requests.accept');


Route::patch(
    '/donor/product-requests/{productRequest}/reject',
    [DonorProductRequestController::class, 'reject']
)
    ->middleware('role:donor')
    ->name('donor.product.requests.reject');


    /*
|--------------------------------------------------------------------------
| Beneficiary Profile
|--------------------------------------------------------------------------
*/

Route::get(
    '/beneficiary/profile',
    [BeneficiaryProfileController::class, 'index']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.profile.index');


Route::get(
    '/beneficiary/profile/edit',
    [BeneficiaryProfileController::class, 'edit']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.profile.edit');


Route::put(
    '/beneficiary/profile',
    [BeneficiaryProfileController::class, 'update']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.profile.update');

    /*
|--------------------------------------------------------------------------
| Beneficiary Products
|--------------------------------------------------------------------------
*/

Route::get(
    '/beneficiary/products',
    [BeneficiaryProductsController::class, 'index']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.products.index');


Route::post(
    '/beneficiary/products/{product}/request',
    [BeneficiaryProductsController::class, 'storeRequest']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.products.request');


/*
|--------------------------------------------------------------------------
| Beneficiary Product Requests
|--------------------------------------------------------------------------
*/

Route::get(
    '/beneficiary/requests',
    [BeneficiaryProductsController::class, 'myRequests']
)
    ->middleware('role:beneficiary')
    ->name('beneficiary.requests.index');