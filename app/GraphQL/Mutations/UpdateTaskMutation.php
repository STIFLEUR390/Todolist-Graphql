<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Models\Task;
class UpdateTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateTask'
    ];

    public function type(): Type
    {
        return GraphQL::type('Task');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::nonNull(Type::int()),
            ],
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
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, $args): Task
    {
        $task = Task::findOrFail($args['id']);
        $task->title = $args['title'];
        if(!empty($args['description'])) { $task->description = $args['description']; }
        if(!empty($args['due_date'])) { $task->due_date = $args['due_date']; }
        if(!empty($args['priority'])) { $task->priority = $args['priority']; }

        if(!empty($args['user_id'])) {
            $user = User::findOrFail($args['user_id']);
            $task->user_id = $args['user_id'];
        }
        $task->save();

        return $task;
    }
}
