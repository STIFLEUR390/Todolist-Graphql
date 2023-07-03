<?php

namespace App\GraphQL\Types;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'A category',
        'model' => Category::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The ID of the category',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the category',
            ],
            'slug' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the category',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'The date and time the category was created',
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'The date and time the category was last updated',
            ],
            'tasks' => [
                'type' => Type::listOf(GraphQL::type('Task')),
                'description' => 'The tasks associated with the category',
            ],
        ];
    }
}
