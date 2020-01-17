<?php

namespace Joselfonseca\LighthouseSnsPushNotifications;


/**
 * Trait ToSnsNotification
 * @package Joselfonseca\LighthouseSnsPushNotifications
 */
trait ToSnsNotification
{
    /**
     * To AWS SNS.
     *
     * @param [type] $notifiable
     */
    public function toSnsPushNotification($notifiable)
    {
        return [
            'arn' => $notifiable->endpoint_arn,
            'title' => 'here the title',
            'body' => 'here the body',
            'data' => [
                'id' => $notifiable->id,
            ],
        ];
    }
}
