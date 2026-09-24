<?php

namespace App\Models;

use App\Models\ProductRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'image',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Product Creator
    |--------------------------------------------------------------------------
    |
    | user_id identifies the Admin or Donor who created the product.
    |
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

public function productRequests(): HasMany
{
    return $this->hasMany(
        ProductRequest::class,
        'product_id'
    );
}

    }