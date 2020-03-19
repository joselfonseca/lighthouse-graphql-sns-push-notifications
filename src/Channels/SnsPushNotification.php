<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Channels;

use Aws\Sns\SnsClient;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SnsPushNotification
{
    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSnsPushNotification($notifiable);
        $client = new SnsClient([
            'key'    => config('services.sns.key'),
            'secret' => config('services.sns.secret'),
            'region' => config('services.sns.region'),
            'version' => 'latest',
        ]);
        $payload = json_encode([
            'aps' => [
                'alert' => [
                    'title' => $message['title'],
                    'body' => $message['body'],
                ],
            ],
            'custom' => $message['data'],
        ]);
        $result = $client->publish([
            'Message' => json_encode([
                'default' => $message['body'],
                'APNS' => $payload,
                'APNS_SANDBOX' => $payload
            ]),
            'MessageStructure' => 'json',
            'TargetArn' => $message['arn'],
        ]);
        Log::debug(json_encode($result));
    }
}
