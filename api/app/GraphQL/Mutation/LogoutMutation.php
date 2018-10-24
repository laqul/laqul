<?php

namespace App\GraphQL\Mutation;

use Auth;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class LogoutMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LogoutQuery',
        'description' => 'Revoca los tokens del usuario autenticado'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('SuccessType'));
    }

    public function args()
    {
        return [
            'type' => [
                'name' => 'type',
                'type' => Type::nonNull(Type::string()),
                'description' => 'logout revoca el token actual, o logout-all revoca los tokens de todos los dispositivos del usuario',
                'rules' => ['required', 'in:logout,logoutAll']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        switch ($args['type']) {
            case 'logout':
                $this->logout();
                break;
            case 'logoutAll':
                $this->logoutAll();
                break;
        }
        return [['success' => true]];
    }

    private function logout()
    {
        $accessToken = Auth::user()->token();
        DB::transaction(function () use ($accessToken) {
            DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
            $accessToken->revoke();
        });
        return true;
    }

    private function logoutAll()
    {
        $tokens = Auth::user()->tokens()->where('revoked', false)->pluck('id')->toArray();
        if (count($tokens)) {
            DB::transaction(function () use ($tokens) {
                Auth::user()->tokens()->where('revoked', false)->update(['revoked' => true]);
                DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $tokens)->update(['revoked' => true]);
            });
        }
        return true;
    }
}
