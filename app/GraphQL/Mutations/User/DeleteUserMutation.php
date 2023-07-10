<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteUser',
        'description' => 'deletes a user'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:users,id']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);

        return (bool)$user->delete();
    }
}
