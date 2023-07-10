<?php

namespace App\GraphQL\Queries\Auth;

use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Query;
class MeQuery extends Query
{
    protected $attributes = [
        'name' => 'me',
    ];

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        // true, if logged in
        return Auth::guard('sanctum')->check();
    }

    public function type(): Type
    {
        return \Rebing\GraphQL\Support\Facades\GraphQL::type('User');
    }

    public function args(): array
    {
        return [
        ];
    }

    public function resolve($root, $args)
    {
        $user_id = Auth::guard('sanctum')->id();
        return User::findOrFail($user_id);
    }
}
