<?php

namespace App\Models\User;

use Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasRoles;

    protected $dates = ['deleted_at'];
    protected $guard_name = 'api';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar', 'password', 'client_id', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'client_id', 'created_at', 'deleted_at', 'updated_at', 'active'
    ];

    public function validateForPassportPasswordGrant($password)
    {
        if (request()->has('platform')) {
            $account = $this->socialAccounts->where('provider', request()->input('platform'))->first();
            if (!$account) {
                return false;
            }
            return Hash::check($password, $account->password);
        }
        return Hash::check($password, $this->getAuthPassword());
    }

    public function findForPassport($username)
    {
        return $this->where('client_id', request()->input('client_id'))
        ->where('email', $username)
        ->where('active', true)->first();
    }

    public function socialAccounts()
    {
        return $this->hasMany('App\Models\Auth\Social\SocialAccount');
    }

    public function messagingTokens()
    {
        return $this->hasMany('App\Models\User\MessagingToken');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\User\Notification');
    }
}
