<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiaryProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'institution',
        'degree',
        'enrollment_year',
        'graduation_year',
        'father_status',
        'guardian_profession',
        'monthly_income',
        'province',
        'domicile',
        'home_address',
        'profile_image',
    ];


    protected $casts = [
        'monthly_income' => 'decimal:2',
        'enrollment_year' => 'integer',
        'graduation_year' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}