<?php

namespace App\GraphQL\Mutations\Task;

use App\Models\Category;
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
                'type' => GraphQL::type('TaskPriority'),
            ],
            'reminder_date' => [
                'name' => 'reminder_date',
                'type' => Type::string(),
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['exists:users,id']
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::nonNull(Type::int()),
                'rules' => ['exists:categories,id']
            ],
        ];
    }

    public function validationAttributes(array $args = []): array
    {
        return [
            'user_id' => 'user',
            'category_id' => 'category',
        ];
    }

    public function resolve($root, $args): Task
    {
        $task = new Task([
            'title' => $args['title'],
            'description' => $args['description'] ?? null,
            'due_date' => $args['due_date'] ?? null,
            'reminder_date' => $args['reminder_date'] ?? null,
            'priority' => $args['priority'] ?? 0,
        ]);

        $user = User::findOrFail($args['user_id']);
        $user->tasks()->save($task);

        $category = Category::findOrFail($args['category_id']);
        $category->tasks()->save($task);

        return $task;
    }
}
