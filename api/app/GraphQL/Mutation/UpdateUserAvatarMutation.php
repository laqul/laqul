<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Image;
use Validator;
use Auth;

class UpdateUserAvatarMutation extends Mutation
{
    protected $attributes = [
        'name' => 'saveUserAvatarMutation',
        'description' => 'Actualiza el avatar del usuario'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('UserType'));
    }

    public function args()
    {
        return [
            'image' => [
                'name' => 'image',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password actual del usuario'
            ]
        ];
    }

    public function rules()
    {
        Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
            if (in_array($type, $parameters)) {
                return true;
            }
            return false;
        });
        return [
            'image' => 'required|image64:jpeg,jpg,png'
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = Auth::user();
        $avatar_name = md5($user->email.$user->id).'.jpg';
        Image::make($args['image'])->save(storage_path('app/public/avatar/') . $avatar_name);
        $user->avatar = $avatar_name;
        $user->save();
        $user->avatar = asset('storage/avatar/' . $user->avatar);
        return [$user];
    }
}
