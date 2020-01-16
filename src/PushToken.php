<?php

namespace Joselfonseca\LighthouseSnsPushNotifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PushToken
 * @package Joselfonseca\LighthouseSnsPushNotifications
 */
class PushToken extends Model
{
    /**
     * @var string
     */
    protected $table = "users_push_tokens";

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'push_token', 'endpoint_arn', 'active'];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
