<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_type',
        'subject',
        'inquiry_type',
        'message',
        'privacy',
        'status',
        'read_at',
    ];

    protected $casts = [
        'privacy' => 'boolean',
        'read_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | New Messages
    |--------------------------------------------------------------------------
    */

    public function scopeNew(Builder $query): Builder
    {
        return $query->where(
            'status',
            'new'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Read Messages
    |--------------------------------------------------------------------------
    */

    public function scopeRead(Builder $query): Builder
    {
        return $query->where(
            'status',
            'read'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Resolved Messages
    |--------------------------------------------------------------------------
    */

    public function scopeResolved(Builder $query): Builder
    {
        return $query->where(
            'status',
            'resolved'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Latest Messages
    |--------------------------------------------------------------------------
    */

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->latest();
    }
}