<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\AwsSnsGatewayContract;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\FakeAwsSnsGateway;
use Joselfonseca\LighthouseSnsPushNotifications\PushToken;
use Joselfonseca\LighthouseSnsPushNotifications\Tests\TestCase;
use Joselfonseca\LighthouseSnsPushNotifications\Tests\User;
use Laravel\Passport\Passport;

class RegisterPushTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_register_push_token()
    {
        $this->app->bind(AwsSnsGatewayContract::class, FakeAwsSnsGateway::class);
        $user = User::create([
            'name' => 'Jose Fonseca',
            'email' => 'jose@example.com',
            'password' => bcrypt('123456789qq')
        ]);
        Passport::actingAs($user);
        $this->graphQL('mutation {
            registerPushToken(input: {
                push_token: "1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn"
            }){
                push_token
                endpoint_arn
            }
        }')->assertJson([
            'data' => [
                'registerPushToken' => [
                    'push_token' => '1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn',
                    'endpoint_arn' => 'aws::arn::example'
                ]
            ]
        ]);
        $this->assertDatabaseHas('users_push_tokens', [
            'user_id' => $user->id,
            'push_token' => '1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn',
            'endpoint_arn' => 'aws::arn::example'
        ]);
    }

    public function test_it_deactivates_all_other_tokens_on_new_registration()
    {
        $this->app->bind(AwsSnsGatewayContract::class, FakeAwsSnsGateway::class);
        $user = User::create([
            'name' => 'Jose Fonseca',
            'email' => 'jose@example.com',
            'password' => bcrypt('123456789qq')
        ]);
        for($i = 0; $i <= 3; $i++) {
            PushToken::create([
                'user_id' => $user->id,
                'push_token' => '1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn',
                'endpoint_arn' => 'aws::arn::example',
                'active' => 1
            ]);
        }
        Passport::actingAs($user);
        $this->graphQL('mutation {
            registerPushToken(input: {
                push_token: "1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn"
            }){
                push_token
                endpoint_arn
            }
        }');
        $inactiveTokens = PushToken::where([
            'user_id' => $user->id,
            'active' => 0
        ])->count();
        $this->assertEquals(4, $inactiveTokens);
        $activeTokens = PushToken::where([
            'user_id' => $user->id,
            'active' => 1
        ])->count();
        $this->assertEquals(1, $activeTokens);
    }
}
