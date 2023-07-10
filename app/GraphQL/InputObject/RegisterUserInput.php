<?php

namespace App\GraphQL\InputObject;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class RegisterUserInput extends InputType
{
    protected $attributes = [
        'name' => 'RegisterUser',
        'description' => 'users'
    ];

    public function fields(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'description' => 'name (250 max chars)',
                'type' => Type::string(),
                'rules' => ['max:250']
            ],
            'email' => [
                'name' => 'email',
                'description' => 'email (250 max chars)',
                'type' => Type::string(),
                'rules' => ['max:250']
            ],
            'password' => [
                'name' => 'password',
                'description' => 'password (250 max chars)',
                'type' => Type::string(),
                'rules' => ['max:250']
            ],
        ];
    }
}
