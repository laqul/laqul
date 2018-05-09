<?php

namespace App\Http\Controllers\Api\Auth\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\User\User;
use App\Models\Auth\Social\SocialAccount;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class SocialController extends Controller
{
    public function redirect(Request $request, $platform)
    {
        return response()->json(['redirect' => Socialite::driver($platform)->stateless()->with(['state' => $platform])->redirect()->getTargetUrl()]);
    }

    private function validateRequest(Request $request, $platform)
    {
        $request->validate([
            'client_id' => 'bail|required|string|min:36',
            'client_secret' => 'bail|required|string|min:36',
            'code' => 'bail|required|string|min:80',
            'timezone' => 'required|min:2|max:50|in:' . implode(',', \DateTimeZone::listIdentifiers())
        ]);
        $request->validate([
            'client_id' => [
                'required',
                Rule::exists('oauth_clients', 'id')->where(function ($query) use ($request) {
                    $query->where('secret', $request->client_secret);
                })]
        ]);
    }

    private function registerIfNotExist(Request $request, $platform, $providerUser)
    {
        $user = User::where('client_id', $request->client_id)->where('email', $providerUser->email)->first();
        $new_password = str_random(40);

        if (!$user) {
            DB::transaction(function () use ($request, $platform, $providerUser, $new_password) {
                $user = User::create([
                    'client_id' => $request->client_id,
                    'name' => title_case($providerUser->name),
                    'email' => $providerUser->email,
                    'password' => bcrypt($new_password),
                    'timezone' => $request->timezone
                ]);
                SocialAccount::updateOrCreate([
                    'user_id' => $user->id,
                    'provider' => $platform
                ], [
                    'password' => bcrypt($new_password)
                ]);
            });
        } else {
            SocialAccount::updateOrCreate([
                'user_id' => $user->id,
                'provider' => $platform
            ], [
                'password' => bcrypt($new_password)
            ]);
        }
        return ['username' => $providerUser->email, 'password' => $new_password];
    }

    private function makeTokens(Request $request, $credentials, $platform)
    {
        $request->request->add([
            'grant_type'    => 'password',
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'platform' => $platform
        ]);
        $tokenRequest = Request::create('api/auth/token', 'post');
        return Route::dispatch($tokenRequest);
    }

    public function login(Request $request, $platform)
    {
        $this->validateRequest($request, $platform);
        $providerUser = Socialite::driver($platform)->stateless()->user();
        $user_credentials = $this->registerIfNotExist($request, $platform, $providerUser);
        return $this->makeTokens($request, $user_credentials, $platform);
    }
}
