<?php

namespace Joselfonseca\LighthouseSnsPushNotifications\Tests;

use Joselfonseca\LighthouseSnsPushNotifications\Gateways\AwsSnsGatewayContract;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\FakeAwsSnsGateway;
use Laravel\Passport\Passport;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__.'/../tests/migrations'));
        Passport::routes();
        Passport::loadKeysFrom(__DIR__.'/storage/');
    }

}
