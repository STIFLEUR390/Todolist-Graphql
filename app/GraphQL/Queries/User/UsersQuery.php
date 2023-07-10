<?php

namespace App\GraphQL\Queries\User;

use App\Http\Resources\UserCollection;
use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Builders\CustomQueryBuilder;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'page' => [
                'type' => Type::int(),
                'description' => 'The page number to retrieve',
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'The number of items per page',
            ],
            'sort' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The fields to sort by',
            ],
            'filter' => [
                'type' => GraphQL::type('UserFilterInput'),
                'description' => 'The fields to filter by',
            ],
            'include' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'The relationships to include',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $allowedSorts = ['name', 'created_at', 'updated_at'];
        $allowedFilters = ['name', 'email'];
        $allowedIncludes = ['tasks'];
        $queryBuilder = new CustomQueryBuilder(User::class, $args, $allowedSorts, $allowedFilters, $allowedIncludes);

        $results = $queryBuilder->whereNotNull('email')
            ->paginate($args['limit'] ?? 10, ['*'], 'page', $args['page'] ?? 1);

//        return $results->items();
        return new UserCollection($results);
    }

//    public function resolve($root, $args)
//    {
//        $query = User::query();
//
//        return $query->latest()->get();
//    }
}
