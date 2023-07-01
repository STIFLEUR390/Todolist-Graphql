<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Models\Task;
class CreateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateTask'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'due_date' => [
                'name' => 'due_date',
                'type' => Type::string(),
            ],
            'priority' => [
                'name' => 'priority',
                'type' => Type::int(),
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    public function resolve($root, $args): Task
    {
        $task = new Task([
            'title' => $args['title'],
            'description' => $args['description'] ?? null,
            'due_date' => $args['due_date'] ?? null,
            'priority' => $args['priority'] ?? 0,
        ]);

        $user = User::findOrFail($args['user_id']);
        $user->tasks()->save($task);

        return $task;
    }
}
