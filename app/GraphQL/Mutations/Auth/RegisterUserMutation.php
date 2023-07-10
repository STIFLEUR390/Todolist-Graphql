<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class RegisterUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'RegisterUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('AuthPayload');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'description' => 'name (250 max chars)',
                'type' => Type::string(),
                'rules' => ['string', 'max:250']
            ],
            'email' => [
                'name' => 'email',
                'description' => 'email (250 max chars)',
                'type' => Type::string(),
                'rules' => ['email', 'max:250', Rule::unique('users', 'email')]
            ],
            'password' => [
                'name' => 'password',
                'description' => 'password (250 max chars)',
                'type' => Type::string(),
                'rules' => ['max:250']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);

        Auth::login($user);
        event(new Registered($user));

        return [
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user' => $user,
        ];
    }
}
