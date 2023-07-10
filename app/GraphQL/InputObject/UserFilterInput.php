<?php

namespace App\GraphQL\InputObject;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class UserFilterInput extends InputType
{
    protected $attributes = [
        'name' => 'UserFilter',
        'description' => 'users filter colomn'
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
        ];
    }
}
