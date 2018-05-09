<?php

namespace App\GraphQL\Mutation;

use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;
use App\Models\User\MessagingToken;

class SaveFcmTokenMutation extends Mutation
{
    protected $attributes = [
        'name' => 'saveFcmTokenMutation',
        'description' => 'Guarda el token de firebase cloud messaging asociado al usuario'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('SuccessType'));
    }

    public function args()
    {
        return [
            'token' => [
                'name' => 'token',
                'type' => Type::nonNull(Type::string()),
                'description' => 'Token de firebase cloud messaging',
                'rules' => ['required', 'string', 'min:152']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        return [['success' => $this->save($args['token'])]];
    }

    private function save($_token)
    {
        $token = MessagingToken::where('token', $_token)->first();
        if ($token) {
            return true;
        }
        $user = Auth::user();
        MessagingToken::create([
            'token' => $_token,
            'user_id' => $user->id
        ]);
        return true;
    }
}
