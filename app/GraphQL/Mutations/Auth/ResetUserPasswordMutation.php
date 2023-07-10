<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
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

    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email'), 'max:255'],
            'password' => ['required', 'string', 'max:100'],
            'password_confirmation' => ['required', 'same:password']
        ];
    }

    public function resolve($root, $args)
    {
        $response = Password::reset($args, function (\App\Models\User $user, $password) {
            $user->password = Hash::make($password);
            $user->save();
            event(new PasswordReset($user));
        });

        if ($response !== Password::PASSWORD_RESET) {
            throw new \Exception(__("Invalid token"));
        }

        return [
            'message' => __("Password reset successfully"),
        ];
    }
}
