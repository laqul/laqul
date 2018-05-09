<?php

namespace App\Models\Auth\Social;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = [
        'user_id', 'password', 'provider'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];
}
