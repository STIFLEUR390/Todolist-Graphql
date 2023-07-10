<?php

namespace App\GraphQL\Mutations\Auth;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class VerifyUserEmailMutation extends Mutation
{
    protected $attributes = [
        'name' => 'verifyUserEmail',
        'description' => 'Verifies the email of a user',
    ];

    public function type(): Type
    {
        return GraphQL::type('VerifyEmailPayload');
    }

    public function args(): array
    {
        return [
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The token for verifying the email',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception(__('User not found'));
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->getKey()]
        );

        if (!hash_equals($args['token'], sha1($verificationUrl))) {
            throw new \Exception(__('Invalid token'));
        }

        $user->markEmailAsVerified();

        return [
            'message' => __('Email verified successfully'),
        ];
    }
}
