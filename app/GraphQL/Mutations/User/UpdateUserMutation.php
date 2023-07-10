<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use App\Trait\UploadFile;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateUserMutation extends Mutation
{
    use UploadFile;

    protected $attributes = [
        'name' => 'updateUser',
        'description' => 'Updates a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::nonNull(Type::int()),
            ],
            'name' => [
                'name' => 'name',
                'type' =>  Type::nonNull(Type::string()),
            ],
            'email' => [
                'name' => 'email',
                'type' =>  Type::nonNull(Type::string()),
            ],
            'photo' => [
                'name' => 'photo',
                'type' => GraphQL::type('Upload'),
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'id' => ['required', Rule::exists('users', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($args['id'])],
            'photo' => ['nullable', 'image', 'max:1500'],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        $user->name = $args['name'];
        $user->email = $args['email'];
        if (!empty($args['profilePicture'])){
            $user->profile_photo_path = $this->uploadFile($args['profilePicture'], 'user', $user->profile_photo_path);
        }
        $user->save();

        return $user;
    }
}
