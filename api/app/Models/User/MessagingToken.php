<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class MessagingToken extends Model
{
    protected $fillable = ['user_id', 'token'];
    
    protected $primaryKey = 'token';

    public $incrementing = false;
}
