<?php

namespace App\Http\Controllers\Api\Auth\Login;

use Firebase\JWT\JWT;
use Laravel\Passport\Passport;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class CustomAccessTokenController extends AccessTokenController
{
    /**
         * Hooks in before the AccessTokenController issues a token
         *
         *
         * @param  ServerRequestInterface $request
         * @return mixed
         */
    public function issueUserToken(ServerRequestInterface $request)
    {
        $result = $this->issueToken($request);
        $content = json_decode($result->content(), true);
        $httpRequest = request();
        if (config('auth.firebaseToken.generate') && json_last_error() == JSON_ERROR_NONE && isset($content['access_token']) && ($httpRequest->grant_type == 'password' || $httpRequest->grant_type == 'refresh_token')) {
            $token = $this->firebaseToken($content);
            $result->setContent(array_merge($content, ['firebase_token' => $token]));
        }
        return $result;
    }

    private function getKeys()
    {
        list($publicKey, $privateKey) = [
            Passport::keyPath('oauth-public.key'),
            Passport::keyPath('firebase-private.key'),
        ];
        return ['public' => file_get_contents($publicKey), 'private' => file_get_contents($privateKey)];
    }

    private function firebaseToken($content)
    {
        $keys = $this->getKeys();
        $decoded = JWT::decode($content['access_token'], $keys['public'], ['RS256']);
        $payload = [
          "iss" => config('auth.firebaseToken.serviceAccountEmail'),
          "sub" => config('auth.firebaseToken.serviceAccountEmail'),
          "aud" => config('auth.firebaseToken.aud'),
          "iat" => $decoded->iat,
          "exp" => $decoded->exp,  // Maximum expiration time is one hour
          "uid" => $decoded->sub
          /* "claims" => array(
            "premium_account" => $is_premium_account
          ) */
          ];
        return JWT::encode($payload, $keys['private'], "RS256");
    }
}
