<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Art;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_lvl',
        'surname',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function arts()
    {
        return $this->hasMany(Art::class, 'user_id', 'id');
    }

    public function isAdministrator()
    {
        return $this->permission_lvl >= 100;
    }

    public function isAdministratorStrict()
    {
        return $this->permission_lvl == 100;
    }

    public function isSuperAdmin()
    {
        return $this->permission_lvl == 1000;
    }
}
