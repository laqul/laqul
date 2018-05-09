<?php

namespace App\GraphQL\Query;

use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;
use Folklore\GraphQL\Support\Traits\ShouldValidate;

class UserNotificationsQuery extends Query
{
    use ShouldValidate;
    
    protected $attributes = [
        'name' => 'UserNotificationsQuery',
        'description' => 'Las notificaciones del usuario'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('NotificationType'));
    }

    public function args()
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limite de notificaciones, minimo uno, maximo 20',
                'rules' => ['required', 'numeric', 'min:1', 'max:20']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        if (isset($args['limit'])) {
            $limit = $args['limit'];
        } else {
            $limit = 10;
        }
        return Auth::user()->notifications()->where('open', false)->orderby('created_at', 'desc')->limit($limit)->get();
    }
}
