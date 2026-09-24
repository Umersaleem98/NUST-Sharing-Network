<?php

namespace App\Models;

use App\Models\BeneficiaryProfile;
use App\Models\Category;
use App\Models\DonorProfile;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'qalam_id',
        'password',
        'role',
        'profile_status',
        'email_verified_at',
        'email_verification_token',
        'email_verification_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_token_expires_at' => 'datetime',
    ];


/*
|--------------------------------------------------------------------------
| Created Products
|--------------------------------------------------------------------------
*/

public function createdProducts(): HasMany
{
    return $this->hasMany(
        Product::class,
        'user_id'
    );
}


/*
|--------------------------------------------------------------------------
| Created Categories
|--------------------------------------------------------------------------
*/

public function createdCategories(): HasMany
{
    return $this->hasMany(
        Category::class,
        'user_id'
    );
}
    

/*
|--------------------------------------------------------------------------
| Beneficiary Profile
|--------------------------------------------------------------------------
*/

public function beneficiaryProfile(): HasOne
{
    return $this->hasOne(
        BeneficiaryProfile::class,
        'user_id'
    );
}

/*
|--------------------------------------------------------------------------
| Donor Profile
|--------------------------------------------------------------------------
*/

public function donorProfile(): HasOne
{
    return $this->hasOne(
        DonorProfile::class
    );
}

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

public function products(): HasMany
{
    return $this->hasMany(
        Product::class,
        'user_id'
    );
}


/*
|--------------------------------------------------------------------------
| Beneficiary Product Requests
|--------------------------------------------------------------------------
*/

public function beneficiaryProductRequests(): HasMany
{
    return $this->hasMany(
        ProductRequest::class,
        'beneficiary_id'
    );
}


/*
|--------------------------------------------------------------------------
| Donor Product Requests
|--------------------------------------------------------------------------
*/

public function donorProductRequests(): HasMany
{
    return $this->hasMany(
        ProductRequest::class,
        'donor_id'
    );
}
}


