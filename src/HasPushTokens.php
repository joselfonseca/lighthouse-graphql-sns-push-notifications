<?php

namespace Joselfonseca\LighthouseSnsPushNotifications;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasPushTokens
{
    public function pushTokens() : BelongsTo
    {
        return $this->belongsTo(PushToken::class);
    }
}
