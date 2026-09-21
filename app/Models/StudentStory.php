<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentStory extends Model
{
    protected $fillable = [
        'student_name',
        'program',
        'story_type',
        'support_type',
        'story',
        'image',
        'image_alt',
        'is_featured',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Active Stories
    |--------------------------------------------------------------------------
    */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Featured Stories
    |--------------------------------------------------------------------------
    */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Ordered Stories
    |--------------------------------------------------------------------------
    */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'desc');
    }
}