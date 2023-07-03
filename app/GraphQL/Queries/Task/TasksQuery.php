<?php

namespace App\GraphQL\Queries\Task;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
    ];

    public function args(): array
    {
        return [
            'filter' => [
                'name' => 'filter',
                'type' => GraphQL::type('TaskFilter'),
                'description' => 'Filter for tasks',
                'defaultValue' => 'all',
            ],
        ];
    }
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Task'));
    }

    public function resolve($root, $args)
    {
        $query = Task::query();

        switch ($args['filter']) {
            case 'completed':
                $query->where('completed', true);
                break;
            case 'incomplete':
                $query->where('completed', false);
                break;
            default:
                break;
        }

        return $query->get();
    }
}
