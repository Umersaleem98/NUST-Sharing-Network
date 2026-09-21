<?php

use App\Http\Controllers\Admin\AdminCategorytController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminStoryController;
use App\Http\Controllers\Admin\AdminTrafficReportController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Beneficiary\BeneficiaryProductController;
use App\Http\Controllers\Beneficiary\BeneficiaryProfileController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Donor\DonorProductController;
use App\Http\Controllers\Donor\DonorProfileController;
use App\Http\Controllers\Donor\DonorRequestController;
use App\Http\Controllers\ExploreNeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OurImpectController;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->view(
        'errors.404',
        [],
        404
    );
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore-needs', [ExploreNeedController::class, 'index'])->name('explore.needs');
Route::get('/our-impact', [OurImpectController::class, 'index'])->name('our.impact');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
Route::post('/cookie-accept', [CookieConsentController::class, 'accept'])->middleware('throttle:10,1')->name('cookie.accept');
Route::post('/cookie-reject', [CookieConsentController::class, 'reject'])->middleware('throttle:10,1')->name('cookie.reject');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get(
    '/forgot-password',
    [AuthController::class, 'showForgotPasswordForm']
)
    ->middleware('guest')
    ->name('password.request');


Route::post(
    '/forgot-password',
    [AuthController::class, 'sendPasswordResetLink']
)
    ->middleware([
        'guest',
        'throttle:5,1',
    ])
    ->name('password.email');


Route::get(
    '/reset-password/{token}',
    [AuthController::class, 'showResetPasswordForm']
)
    ->middleware('guest')
    ->name('password.reset');


Route::post(
    '/reset-password',
    [AuthController::class, 'resetPassword']
)
    ->middleware([
        'guest',
        'throttle:5,1',
    ])
    ->name('password.update');
Route::get('/register', [AuthController::class,'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.post');
  Route::get('/email/verify', [AuthController::class,'showEmailVerificationNotice',])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class,'verifyEmail',])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', [
        AuthController::class,
        'resendEmailVerification',
    ])
        ->middleware('throttle:6,1')
        ->name('verification.send');


Route::post('/donor/accept-terms', [DashboardController::class, 'acceptTerms'])
    ->name('donor.accept.terms');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::patch(
            '/notifications/read-all',
            [NotificationController::class, 'markAllAsRead']
        )->name('notifications.read-all');

        Route::patch(
            '/notifications/{id}/read',
            [NotificationController::class, 'markAsRead']
        )->name('notifications.read');

        Route::delete(
            '/notifications/clear-all',
            [NotificationController::class, 'clearAll']
        )->name('notifications.clear-all');
    });



    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->prefix('admin')->group(function () {

        // CATEGORY
        Route::get('category/index', [AdminCategorytController::class, 'index'])->name('admin.category.index');
        Route::get('category/create', [AdminCategorytController::class, 'create'])->name('admin.category.create');
        Route::post('category/store', [AdminCategorytController::class, 'store'])->name('admin.category.store');
        Route::get('category/edit/{id}', [AdminCategorytController::class, 'edit'])->name('admin.category.edit');
        Route::put('category/update/{id}', [AdminCategorytController::class, 'update'])->name('admin.category.update');
        Route::delete('category/delete/{id}', [AdminCategorytController::class, 'destroy'])->name('admin.category.delete');

        // PRODUCTS
        Route::get('products/index', [AdminProductsController::class, 'index'])->name('admin.products.index');
        Route::get('products/create', [AdminProductsController::class, 'create'])->name('admin.products.create');
        Route::post('products/store', [AdminProductsController::class, 'store'])->name('admin.products.store');
        Route::get('product/{id}/edit', [AdminProductsController::class, 'edit'])->name('admin.product.edit');
        Route::put('products/update/{id}', [AdminProductsController::class, 'update'])->name('admin.products.update');
        Route::delete('products/delete/{id}', [AdminProductsController::class, 'destroy'])->name('admin.products.delete');

        // USERS

        /*
|--------------------------------------------------------------------------
| Admin User Management Routes
|--------------------------------------------------------------------------
*/

        Route::get(
            'user/index',
            [AdminUserController::class, 'index']
        )->name('admin.user.index');

        Route::get(
            'user/create',
            [AdminUserController::class, 'create']
        )->name('admin.user.create');

        Route::post(
            'user/store',
            [AdminUserController::class, 'store']
        )->name('admin.user.store');

        Route::get(
            'user/edit/{id}',
            [AdminUserController::class, 'edit']
        )->name('admin.user.edit');

        Route::put(
            'user/update/{id}',
            [AdminUserController::class, 'update']
        )->name('admin.user.update');

        /*
|--------------------------------------------------------------------------
| Activate, suspend or block user
|--------------------------------------------------------------------------
*/

        Route::patch(
            'user/{user}/account-status',
            [AdminUserController::class, 'updateAccountStatus']
        )->name('admin.user.status.update');

        /*
|--------------------------------------------------------------------------
| Delete users
|--------------------------------------------------------------------------
*/

        Route::delete(
            'user/delete/{id}',
            [AdminUserController::class, 'destroy']
        )->name('admin.user.destroy');

        Route::post(
            'user/delete-selected',
            [AdminUserController::class, 'deleteSelected']
        )->name('admin.user.delete.selected');

        /*
|--------------------------------------------------------------------------
| Excel import/export
|--------------------------------------------------------------------------
*/

        Route::post('/admin/users/import/preview', [AdminUserController::class, 'preview'])
            ->name('admin.user.import.preview');

        Route::post('/admin/users/import/confirm', [AdminUserController::class, 'confirm'])
            ->name('admin.user.import.confirm');

        Route::post('/admin/users/import/cancel', [AdminUserController::class, 'cancel'])
            ->name('admin.user.import.cancel');

        Route::get(
            'users/export',
            [AdminUserController::class, 'exportUsers']
        )->name('admin.user.export');

        Route::post(
            'users/export-selected',
            [AdminUserController::class, 'exportSelected']
        )->name('admin.user.export.selected');
        // REQUESTS
        Route::get('requests', [AdminRequestController::class, 'index'])->name('admin.requests');
        Route::post('request/{id}/update', [AdminRequestController::class, 'update'])->name('admin.request.update');

        Route::get('/reports/traffic', [AdminTrafficReportController::class, 'index'])->name('reports.traffic');
    });

Route::get(
    '/admin/contact-messages',
    [AdminContactController::class, 'index']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.contact.index');


/*
|--------------------------------------------------------------------------
| Delete Selected Contact Messages
|--------------------------------------------------------------------------
*/

Route::delete(
    '/admin/contact-messages/delete-selected',
    [AdminContactController::class, 'destroySelected']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.contact.destroy-selected');


/*
|--------------------------------------------------------------------------
| Show Contact Message
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/contact-messages/{contact}',
    [AdminContactController::class, 'show']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.contact.show');


/*
|--------------------------------------------------------------------------
| Update Contact Status
|--------------------------------------------------------------------------
*/

Route::patch(
    '/admin/contact-messages/{contact}/status',
    [AdminContactController::class, 'updateStatus']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.contact.status');


/*
|--------------------------------------------------------------------------
| Delete Single Contact Message
|--------------------------------------------------------------------------
*/

Route::delete(
    '/admin/contact-messages/{contact}',
    [AdminContactController::class, 'destroy']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.contact.destroy');
    

    /*
    |--------------------------------------------------------------------------
    | DONOR ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:donor')->prefix('donor')->group(function () {

        // PRODUCTS
        Route::get('product/index', [DonorProductController::class, 'index'])->name('donor.product.index');
        Route::get('product/create', [DonorProductController::class, 'create'])->name('donor.product.create');
        Route::post('products/store', [DonorProductController::class, 'store'])->name('donor.product.store');
        Route::get('products/edit/{id}', [DonorProductController::class, 'edit'])->name('donor.product.edit');
        Route::put('products/update/{id}', [DonorProductController::class, 'update'])->name('donor.product.update');
        Route::delete('products/delete/{id}', [DonorProductController::class, 'destroy'])->name('donor.products.delete');

        // PROFILE
        Route::get('profile/index', [DonorProfileController::class, 'index'])->name('donor.profile.index');
        Route::post('profile/update', [DonorProfileController::class, 'update'])->name('donor.profile.update');

        // REQUESTS
        Route::get('requests', [DonorRequestController::class, 'donorRequests'])->name('donor.requests');
        Route::post('request/{id}', [DonorRequestController::class, 'updateRequestStatus'])->name('donor.request.update');
    });




    /*
    |--------------------------------------------------------------------------
    | BENEFICIARY ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:beneficiary')->prefix('beneficiary')->group(function () {

        // PRODUCTS
        Route::get('products/index', [BeneficiaryProductController::class, 'index'])->name('beneficiary.products.index');

        Route::get('products/detail/{id}', [BeneficiaryProductController::class, 'show'])
            ->name('beneficiary.products.detail.show');

        // PROFILE
        Route::get('profile/index', [BeneficiaryProfileController::class, 'index'])
            ->name('Beneficiary.profile.index');

        Route::post('profile/update', [BeneficiaryProfileController::class, 'update'])
            ->name('Beneficiary.profile.update');

        // REQUESTS
        Route::post('product/{id}/request', [BeneficiaryProductController::class, 'sendRequest'])
            ->name('product.request.send');

        Route::get('my-requests', [BeneficiaryProductController::class, 'myRequests'])
            ->name('beneficiary.my.requests');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Student Stories
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/student-stories',
    [AdminStoryController::class, 'index']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.index');


Route::get(
    '/admin/student-stories/create',
    [AdminStoryController::class, 'create']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.create');


Route::post(
    '/admin/student-stories',
    [AdminStoryController::class, 'store']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.store');


Route::get(
    '/admin/student-stories/{story}/edit',
    [AdminStoryController::class, 'edit']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.edit');


Route::put(
    '/admin/student-stories/{story}',
    [AdminStoryController::class, 'update']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.update');


Route::delete(
    '/admin/student-stories/{story}',
    [AdminStoryController::class, 'destroy']
)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.student.stories.destroy');