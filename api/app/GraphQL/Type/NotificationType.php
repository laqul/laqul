<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as BaseType;
use GraphQL;

class NotificationType extends BaseType
{
    protected $attributes = [
        'name' => 'NotificationType',
        'description' => 'Notificacion'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'El id de la notificacion'
            ],
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Tipo de notificacion'
            ],
            'color' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Color de la notificacion'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Titulo de la notificacion'
            ],
            'body' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Mensaje de la notificacion'
            ],
            'payload' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Datos de la notificacion'
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Fecha de creacion de la notificacion'
            ]
        ];
    }

    public function resolvePayloadField($root, $args)
    {
        return json_encode($root->payload);
    }
}
