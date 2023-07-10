<?php

namespace App\GraphQL\Mutations\Auth;

use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkMutation extends Mutation
{
    protected $attributes = [
        'name' => 'PasswordResetLink'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email')],
        ];
    }

    public function resolve($root, array $args)
    {
        $status = Password::sendResetLink( $args);
        return $status === Password::RESET_LINK_SENT;
    }

}
