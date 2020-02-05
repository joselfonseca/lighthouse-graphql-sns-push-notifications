<?php

namespace Joselfonseca\LighthouseSnsPushNotifications\Tests;

use Joselfonseca\LighthouseSnsPushNotifications\Providers\SnsPushNotificationsServiceProvider;
use Laravel\Passport\PassportServiceProvider;
use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    use MakesGraphQLRequests;
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            LighthouseServiceProvider::class,
            PassportServiceProvider::class,
            SnsPushNotificationsServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:gG84rusPbDk6AGOjbj5foirqMZm6tdD2fKZrbP0BS+A=');
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('lighthouse.schema.register', __DIR__.'/schema.graphql');
        $app['config']->set('auth.guards', [
            'web' => [
                'driver'   => 'session',
                'provider' => 'users',
            ],
            'api' => [
                'driver'   => 'passport',
                'provider' => 'users',
            ],
        ]);
        $app['config']->set('auth.providers', [
            'users' => [
                'driver' => 'eloquent',
                'model'  => User::class,
            ],
        ]);
    }

    public function test_assert_true()
    {
        $this->assertTrue(true);
    }
}
