<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Validator;
use Hash;
use Auth;

class UpdateUserPasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserPasswordMutation',
        'description' => 'Actualiza el password del usuario autenticado'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('SuccessType'));
    }

    public function args()
    {
        return [
            'current_password' => [
                'name' => 'current_password',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Password actual del usuario'
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Nuevo password'
            ],
            'password_confirmation' => [
                'name' => 'password_confirmation',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Confirmacion del nuevo password'
            ]
        ];
    }

    public function rules()
    {
        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });
        $user = Auth::user();
        return [
            'current_password' => 'required|min:8|max:30|current_password:' . $user->password,
            'password' => 'required|min:8|max:30|confirmed'
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = Auth::user();
        $user->password = bcrypt($args['password']);
        $user->save();
        return [['success' => true]];
    }
}
