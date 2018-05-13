<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class UpdateUserInfoMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserInfoMutation',
        'description' => 'Actualiza la informacion del usuario autenticado'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('UserType'));
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'description' => 'Nombre del usuario'
            ],
            'timezone' => [
                'name' => 'timezone',
                'type' => Type::string(),
                'description' => 'Zona horaria del usuario'
            ]
        ];
    }

    public function rules()
    {
        return [
            'name' => 'string|min:4|max:30',
            'timezone' => 'string|min:2|max:50|in:' . implode(',', \DateTimeZone::listIdentifiers())
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = Auth::user();
        if (isset($args['name']) || isset($args['timezone'])) { // Cuando haya mas parametros que modificar se agregan aqui, por el momento solo hay uno
            if (isset($args['name'])) { // Luego se separan individualmente
                $user->name = title_case($args['name']);
            }
            if (isset($args['timezone'])) {
                $user->timezone = $args['timezone'];
            }
            $user->save();
        }
        return [$user];
    }
}
