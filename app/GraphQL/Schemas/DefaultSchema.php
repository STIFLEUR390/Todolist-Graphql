<?php

namespace App\GraphQL\Schemas;

use Rebing\GraphQL\Support\Contracts\ConfigConvertible;

class DefaultSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return [
            'query' => [
                'task' => \App\GraphQL\Queries\Task\TaskQuery::class,
                'tasks' => \App\GraphQL\Queries\Task\TasksQuery::class,
                'tasksPaginate' => \App\GraphQL\Queries\Task\TasksPaginateQuery::class,
                // Category
                'category' => \App\GraphQL\Queries\Category\CategoryQuery::class,
                'categories' => \App\GraphQL\Queries\Category\CategoriesQuery::class,
                'categoriesPaginate' =>  \App\GraphQL\Queries\Category\CategoriesPaginateQuery::class,
                // User
                'user' => \App\GraphQL\Queries\User\UserQuery::class,
                'users' => \App\GraphQL\Queries\User\UsersQuery::class,
                'usersPaginate' =>  \App\GraphQL\Queries\User\UsersPaginateQuery::class,
            ],

            'mutation' => [
                // Task
                'createTask' => \App\GraphQL\Mutations\Task\CreateTaskMutation::class,
                'updateTask' => \App\GraphQL\Mutations\Task\UpdateTaskMutation::class,
                'deleteBook' => \App\GraphQL\Mutations\Task\DeleteTaskMutation::class,
                // Category
                'createCategory' => \App\GraphQL\Mutations\Category\CreateCategoryMutation::class,
                'updateCategory' => \App\GraphQL\Mutations\Category\UpdateCategoryMutation::class,
                'deleteCategory' => \App\GraphQL\Mutations\Category\DeleteCategoryMutation::class,
                // User
                'createUser' => \App\GraphQL\Mutations\User\CreateUserMutation::class,
                'updateUser' => \App\GraphQL\Mutations\User\UpdateUserMutation::class,
                'deleteUser' => \App\GraphQL\Mutations\User\DeleteUserMutation::class,
            ],

            'types' => [
                "TaskPriority" => \App\GraphQL\Enums\TaskPriorityEnum::class,
                "TaskFilter" => \App\GraphQL\Enums\TaskFilterEnumType::class,
//                "Upload" => \Rebing\GraphQL\Support\UploadType::class,
//                "UserFilterInput" => \App\GraphQL\InputObject\UserFilterInput::class,
            ],

            'middleware' => null,

            'method' => ['POST'],

            'execution_middleware' => null,
        ];
    }
}
