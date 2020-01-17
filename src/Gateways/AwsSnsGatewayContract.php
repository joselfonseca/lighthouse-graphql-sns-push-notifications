<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Gateways;


interface AwsSnsGatewayContract
{
    public function registerPushToken($user, $push_token);
}
