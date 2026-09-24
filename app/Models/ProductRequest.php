<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'beneficiary_id',
        'donor_id',
        'beneficiary_message',
        'admin_status',
        'admin_message',
        'donor_status',
        'donor_message',
    ];


    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Beneficiary
    |--------------------------------------------------------------------------
    */

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'beneficiary_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Donor
    |--------------------------------------------------------------------------
    */

    public function donor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'donor_id'
        );
    }
}