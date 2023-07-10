<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class AuthSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
//                'user' => \App\GraphQL\Queries\User\UserQuery::class,
//                'users' => \App\GraphQL\Queries\User\UsersQuery::class,
                'me' => \App\GraphQL\Queries\Auth\MeQuery::class,
            ],

            'mutation' => [
                "registerUser" => \App\GraphQL\Mutations\Auth\RegisterUserMutation::class,
                "loginUser" => \App\GraphQL\Mutations\Auth\LoginUserMutation::class,
                "resetUserPassword" => \App\GraphQL\Mutations\Auth\ResetUserPasswordMutation::class,
                "logoutMutation" => \App\GraphQL\Mutations\Auth\LogoutMutation::class,
            ],

            'types' => [
                "RegisterUserInput" => \App\GraphQL\InputObject\RegisterUserInput::class,
                "AuthPayload" => \App\GraphQL\Types\Auth\AuthPayload::class,
                "ResetPasswordPayload" => \App\GraphQL\Types\Auth\ResetPasswordPayload::class,
//                "UpdateUserPayload"
//                "VerifyEmailPayload"
//                "TwoFactorAuthPayload"
            ],

            'middleware' => null,

            'method' => ['POST'],

            'execution_middleware' => null,
        ];
    }
}
