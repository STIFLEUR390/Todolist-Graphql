<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A user',
        'model' => User::class,
    ];


    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the user',
            ],
            'profile_photo_path' => [
                'type' => Type::string(),
                'description' => 'The profile photo path of the user',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The date and time the user was created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The date and time the user was last updated',
            ],
            'tasks' => [
                'type' => Type::listOf(GraphQL::type('Task')),
                'description' => 'The tasks associated with the category',
            ],
        ];
    }


}
