<?php

namespace Joselfonseca\LighthouseSnsPushNotifications;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPushTokens
{
    public function pushTokens() : HasMany
    {
        return $this->hasMany(PushToken::class);
    }
}
