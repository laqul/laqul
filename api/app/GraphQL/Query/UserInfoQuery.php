<?php

namespace App\GraphQL\Query;

use Auth;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;

class UserInfoQuery extends Query
{
    protected $attributes = [
        'name' => 'UserInfoQuery',
        'description' => 'Informacion del usuario autenticado'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('UserType'));
    }

    public function args()
    {
        return [
            
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $user = Auth::user();
        $user->avatar = asset('storage/avatar/'.$user->avatar);
        return [$user];
    }
}
