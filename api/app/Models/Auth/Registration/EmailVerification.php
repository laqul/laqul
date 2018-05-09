<?php

namespace App\Models\Auth\Registration;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = ['client_id', 'email', 'code'];
}
