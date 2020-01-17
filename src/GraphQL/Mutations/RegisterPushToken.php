<?php


namespace Joselfonseca\LighthouseSnsPushNotifications\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Joselfonseca\LighthouseSnsPushNotifications\Gateways\AwsSnsGatewayContract;
use Joselfonseca\LighthouseSnsPushNotifications\PushToken;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Class RegisterPushToken
 * @package Joselfonseca\LighthouseSnsPushNotifications\GraphQL\Mutations
 */
class RegisterPushToken
{

    /**
     * @var AwsSnsGatewayContract
     */
    public $gateway;

    /**
     * RegisterPushToken constructor.
     * @param AwsSnsGatewayContract $gateway
     */
    public function __construct(AwsSnsGatewayContract $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @param $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = $context->user();
        $response = $this->gateway->registerPushToken($user, $args['push_token']);
        $token = PushToken::create([
            'user_id' => $user->id,
            'endpoint_arn' => $response['EndpointArn'],
            'push_token' => $args['push_token'],
            'active' => 1]
        );
        PushToken::where('id', '!=', $token->id)->where('user_id', $user->id)->update(['active' => 0]);
        return $token;
    }
}
