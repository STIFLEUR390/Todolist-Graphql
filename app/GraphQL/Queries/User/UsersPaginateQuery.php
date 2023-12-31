<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use App\Trait\Search;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
class UsersPaginateQuery extends Query
{
    use Search;

    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('User'));
//        return GraphQL::paginate('User');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::nonNull(Type::int()),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'search' => [
                'name' => 'search',
                'type' => Type::string(),
            ],
            'sortBy' => [
                'name' => 'sortBy',
                'type' => Type::string(),
            ],
            'sortType' => [
                'name' => 'sortType',
                'type' => Type::string(),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'limit' => ['required'],
            'page' => ['required'],
            'sortType' => ['nullable', 'in:asc,desc'],
        ];
    }

    public function validationAttributes(array $args = []): array
    {
        return [
            'sortType' => 'sort column',
            'sortBy' => 'sort direction',
        ];
    }

    public function resolve($root, array $args)
    {
        $item = User::first();
        $attributes = array_keys($item->getOriginal());
        $sortBy = $args['sortBy'] ?? null;
        $sortType = $args['sortType'] ?? null;
        $search = $args['search'] ?? null;
        $query = User::with(['tasks'])->select($attributes);
        if (!empty($search)) {
            $query = $this->globalSearch($query, User::class, rawurldecode($search), 'LIKE');
        }

        if (!empty($sortBy) && !empty($sortType) && $sortType != 'null') {
            $query->orderBy($sortBy, $sortType);
        }
        return $query->paginate($args['limit'], ['*'], 'page', $args['page'] ?? 1);
    }
}
