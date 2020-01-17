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
        $client = app(SnsClient::class);
        return $client->createPlatformEndpoint([
            'PlatformApplicationArn' => config('services.aws.sns_platform_arn'),
            'Token' => $push_token['push_token'],
            'CustomUserData' => [
                'id' => $user->id
            ]
        ]);
    }
}
