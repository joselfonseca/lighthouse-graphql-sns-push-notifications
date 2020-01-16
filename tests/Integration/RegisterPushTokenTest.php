<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\Tests\Integration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Joselfonseca\LighthouseSnsPushNotifications\Tests\TestCase;
use Joselfonseca\LighthouseSnsPushNotifications\Tests\User;
use Laravel\Passport\Passport;

class RegisterPushTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_register_push_token()
    {
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
                user {
                    id
                }
                push_token
                endpoint_arn
            }
        }')->assertJson([
            'user' => [
                'id' => $user->id
            ],
            'push_token' => '1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn'
        ]);
        $this->assertDatabaseHas('users_push_tokens', [
            'user_id' => $user->id,
            'push_token' => '1238798syd7f897dsyf8nsdtf787dtnf8s7dtfn'
        ]);
    }
}
