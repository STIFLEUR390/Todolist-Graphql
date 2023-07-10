<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use App\Trait\UploadFile;
use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CreateUserMutation extends Mutation
{
    use UploadFile;

    protected $attributes = [
        'name' => 'CreateUser',
        'description' => 'Creates a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string()),
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email',Rule::unique('users', 'email')],
            'photo' => ['nullable', 'image', 'max:1500'],
        ];
    }

    public function resolve($root, $args)
    {
        if (empty($args['profilePicture'])){
            $user = new User([
                'name' => $args['name'],
                'email' => $args['email'],
                'password' => bcrypt('12345678'),
            ]);
            $user->save();

            return $user;
        }
        $file = $args['profilePicture'];
        $file_path = $this->uploadFile($file, 'user');

        $user = new User([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => bcrypt('12345678'),
            'profile_photo_path' => $file_path
        ]);
        $user->save();

        return $user;
    }
}
