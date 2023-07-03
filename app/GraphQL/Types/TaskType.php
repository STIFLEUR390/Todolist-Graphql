<?php

namespace App\GraphQL\Types;

use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
class TaskType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Task',
        'description' => 'A task',
        'model' => Task::class,
    ];


    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the task',
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the task',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The description of the task',
            ],
            'due_date' => [
                'type' => Type::string(),
                'description' => 'The due date of the task',
            ],
            'priority' => [
                'type' => GraphQL::type('TaskPriority'),
                'description' => 'The priority of the task',
            ],
            'completed' => [
                'type' => Type::boolean(),
                'description' => 'Whether the task is completed or not',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'create date of the task',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'create date of the task',
            ],
            'category' => [
                'type' => GraphQL::type('Category'),
                'description' => 'The category of the quest'
            ]
        ];
    }
}
