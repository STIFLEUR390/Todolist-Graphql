<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LoginUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'loginUser',
        'description' => 'Se connecte à un utilisateur',
    ];

    public function type(): Type
    {
        return GraphQL::type('AuthPayload');
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "L'e-mail de l'utilisateur",
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => "Le mot de passe de l'utilisateur",
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required', 'email', Rule::exists('users', 'email')],
        ];
    }

    public function resolve($root, $args): array
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];

        if (!Auth::attempt($credentials)) {
            throw new \Exception(__("The provided credentials do not match our records."));
        }

        $user = Auth::user();
        Auth::login($user);

        return [
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => $user,
        ];
    }
}
