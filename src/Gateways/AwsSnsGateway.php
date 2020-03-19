<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Gateways;

use Aws\Sns\SnsClient;

/**
 * Class AwsSnsGateway
 * @package Joselfonseca\LighthouseSnsPushNotifications\Gateways
 */
class AwsSnsGateway implements AwsSnsGatewayContract
{

    /**
     * @param $user
     * @param $push_token
     * @return mixed
     */
    public function registerPushToken($user, $push_token)
    {
        $client = new SnsClient([
            'key'    => config('services.sns.key'),
            'secret' => config('services.sns.secret'),
            'region' => config('services.sns.region'),
            'version' => 'latest',
        ]);
        return $client->createPlatformEndpoint([
            'PlatformApplicationArn' => config('services.sns.platform_arn'),
            'Token' => $push_token,
            'CustomUserData' => json_encode([
                'id' => $user->id
            ])
        ]);
    }
}
