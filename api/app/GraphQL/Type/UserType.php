<?php

namespace App\GraphQL\Type;

use Auth;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;

class UserType extends BaseType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'Usuario'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'El id del usuario'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'El nombre del usuario'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'El email del usuario'
            ],
            'avatar' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Avatar del usuario'
            ],
            'timezone' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Zona horaria del usuario'
            ],
            'userNotifications' => [
                'args' => [
                    'limit' => [
                        'name' => 'limit',
                        'type' => Type::int(),
                        'description' => 'Limite de notificaciones, minimo uno, maximo 20',
                        'rules' => ['required', 'numeric', 'min:1', 'max:20']
                    ]
                ],
                'type'        => Type::listOf(GraphQL::type('NotificationType')),
                'description' => 'Las notificaciones del usuario',
            ]
        ];
    }

    public function resolveUserNotificationsField($root, $args)
    {
        if (isset($args['limit'])) {
            $limit = $args['limit'];
        } else {
            $limit = 10;
        }
        return Auth::user()->notifications()->where('open', false)->orderby('created_at', 'desc')->limit($limit)->get();
    }
}
