<?php

namespace Joselfonseca\LighthouseSnsPushNotifications\Tests;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Joselfonseca\LighthouseSnsPushNotifications\HasPushTokens;

/**
 * Class User.
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasPushTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
}
