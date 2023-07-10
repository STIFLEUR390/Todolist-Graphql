<?php

namespace App\GraphQL\Types\Auth;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UpdateUserPayload extends GraphQLType
{
    protected $attributes = [
        'name'          => 'User',
        'description'   => 'A user',
        'model'         => User::class,
    ];

    public function fields(): array
    {
        return [
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'The user of the quest'
            ]
        ];
    }
}
