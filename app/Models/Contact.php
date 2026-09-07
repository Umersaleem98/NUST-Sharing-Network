<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
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
    ];

    protected $casts = [
        'privacy' => 'boolean',
    ];
}
