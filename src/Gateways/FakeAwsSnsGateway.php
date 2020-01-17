<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Gateways;


/**
 * Class FakeAwsSnsGateway
 * @package Joselfonseca\LighthouseSnsPushNotifications\Gateways
 */
class FakeAwsSnsGateway implements AwsSnsGatewayContract
{
    /**
     * @param $user
     * @param $push_token
     * @return array
     */
    public function registerPushToken($user, $push_token)
    {
        return ['EndpointArn' => 'aws::arn::example'];
    }

}
