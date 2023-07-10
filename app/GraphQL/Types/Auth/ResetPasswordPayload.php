<?php

namespace App\GraphQL\Types\Auth;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ResetPasswordPayload extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ResetPasswordPayload',
        'description'   => 'A user',
    ];

    public function fields(): array
    {
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The message',
            ],
        ];
    }
}
