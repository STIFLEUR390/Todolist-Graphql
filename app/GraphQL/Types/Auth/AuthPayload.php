<?php

namespace App\GraphQL\Types\Auth;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthPayload extends GraphQLType
{
    protected $attributes = [
        'name'          => 'AuthPayload',
        'description'   => 'The authentication payload',
    ];

    public function fields(): array
    {
        return [
            'token' => [
                'type' => Type::string(),
                'description' => 'The user token',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The authenticated user'
            ]
        ];
    }
}
