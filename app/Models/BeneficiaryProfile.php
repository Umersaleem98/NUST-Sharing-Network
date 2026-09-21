<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiaryProfile extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',

        // Personal Information
        'gender',

        // Academic Information
        'institution',
        'degree_level',
        'degree_program',
        'department',
        'semester',
        'cgpa',
        'enrollment_year',
        'graduation_year',

        // Family / Guardian Information
        'father_status',
        'guardian_profession',
        'monthly_income',

        // Location Information
        'province',
        'domicile',
        'home_address',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'cgpa' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'enrollment_year' => 'integer',
        'graduation_year' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | User Relationship
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}