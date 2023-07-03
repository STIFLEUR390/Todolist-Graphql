<?php

namespace App\GraphQL\Mutations\Task;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Models\Task;
class DeleteTaskMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteTask',
        'description' => 'Delete a book'
    ];

//    public function type(): Type
//    {
//        return GraphQL::type('Task');
//    }

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:tasks,id']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $task = Task::findOrFail($args['id']);

        return  $task->delete() ? true : false;
    }
}
