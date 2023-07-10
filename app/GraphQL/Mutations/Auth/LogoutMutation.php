<?php

namespace App\GraphQL\Mutations\Auth;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;

class LogoutMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteCategory',
        'description' => 'deletes a category'
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        // true, if logged in
        return Auth::guard('sanctum')->check();
    }

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
        ];
    }

    public function resolve($root, $args)
    {
        // Revoke all tokens...
        $user = Auth::guard('sanctum')->user();
//        $user->tokens()->delete();
//        $user->currentAccessToken()->delete();

        return (bool)$user->tokens()->delete();
    }
}
