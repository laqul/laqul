<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'color', 'title', 'body', 'payload'];

    protected $casts = [
        'payload' => 'object',
        'created_at' => 'string'
    ];

    protected $hidden = [
        'user_id', 'updated_at'
    ];
}
