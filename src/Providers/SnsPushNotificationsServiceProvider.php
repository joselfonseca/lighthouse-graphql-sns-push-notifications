<?php

namespace Joselfonseca\LighthouseSnsPushNotifications\Providers;

use Illuminate\Support\ServiceProvider;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\AwsSnsGateway;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\AwsSnsGatewayContract;
use Nuwave\Lighthouse\Events\BuildSchemaString;

class SnsPushNotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (config('lighthouse-sns-push-notifications.migrations', true)) {
            $this->loadMigrationsFrom(__DIR__.'/../../migrations');
        }
        app('events')->listen(
            BuildSchemaString::class,
            function (): string {
                if (config('lighthouse-sns-push-notifications.schema')) {
                    return file_get_contents(config('lighthouse-sns-push-notifications.schema'));
                }

                return file_get_contents(__DIR__.'/../../graphql/push-notifications.graphql');
            }
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->registerConfig();
        $this->app->bind(AwsSnsGatewayContract::class, AwsSnsGateway::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'lighthouse-sns-push-notifications'
        );

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('lighthouse-sns-push-notifications.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../graphql/auth.graphql' => base_path('graphql/push-notifications.graphql'),
        ], 'schema');

        $this->publishes([
            __DIR__.'/../../migrations/2019_11_19_000000_create_users_push_notification_tokens_table.php' => base_path('database/migrations/2019_11_19_000000_create_users_push_notification_tokens_table.php'),
        ], 'migrations');
    }
}
