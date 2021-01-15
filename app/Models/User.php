<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function articles() {
        return $this->hasMany('App\Models\Article');
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_user');
    }

    // 'string', ['VIEW_ADMIN', 'ADD_ARTICLES']
    public function canDo($permission, $require = false) {
        if(is_array($permission)) {
            foreach($permission as $permName) {

                $permName = $this->canDo($permName);
                if($permName && !$require) {
                    return true;
                }
                else if(!$permName && $require) {
                    return false;
                }

            }
            return $require;
        }
        else {
            foreach($this->roles as $role) {
                foreach($role->perms as $perm) {
                    if(Str::is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }
    }

    // string ['role1', 'role2']
    public function hasRole($name, $require = false) {
        if(is_array($name)) {
            foreach($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if($hasRole && !$require) {
                    return true;
                }
                else if(!$hasRole && $require) {
                    return false;
                }

            }
            return $require;
        }
        else {
            foreach($this->roles as $role) {
                foreach($role->name as $role) {
                    if($role->name == $name) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
