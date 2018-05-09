<?php

namespace App\Models\Auth\PasswordReset;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['user_id', 'token'];
    protected $primaryKey = 'user_id';
}
