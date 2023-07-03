<?php

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateCategory',
        'description' => 'Creates a category'
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name' => ['required', Rule::unique('categories')],
        ];
    }

    public function resolve($root, $args)
    {
        $category = new Category([
            'name' => $args['name'],
            'slug' => Str::slug($args['name']),
        ]);
        $category->save();

        return $category;
    }
}
