<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class ResetUserPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'resetUserPassword',
        'description' => 'Resets a user password',
    ];

    public function type(): Type
    {
        return GraphQL::type('ResetPasswordPayload');
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of the user',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The new password of the user',
            ],
            'password_confirmation' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The confirmation of the new password of the user',
            ],
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The token for resetting the password',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::where('email', $args['email'])->first();

        if (!$user) {
            throw new \Exception('User not found');
        }

        $response = Password::reset($args, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($response !== Password::PASSWORD_RESET) {
            throw new \Exception('Invalid token');
        }

        return [
            'message' => __("Password reset successfully"),
        ];
    }
}
