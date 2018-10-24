<?php

namespace App\Http\Controllers\Api\Auth\ResetPassword;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Auth\PasswordReset\PasswordReset;

class ForgotController extends Controller
{
    private function validateRequest(Request $request) {
        $request->validate([
            'client_id' => 'bail|required|string|exists:oauth_clients,id',
            'email' => ['bail','required',
              Rule::exists('users')->where(function ($query) use ($request) {
                  $query->where('client_id', $request->client_id)
                  ->where('active', true);
            })]]);
    }
    
    public function generateToken(Request $request){
        $this->validateRequest($request);
        $token = substr(uniqid(str_random(137)), 0, 150);
        DB::transaction(function () use ($request, $token) {
            $user = User::where('client_id', $request->client_id)
            ->where('email', $request->email)
            ->where('active', true)->first();
            PasswordReset::updateOrCreate([
            'user_id' => $user->id],
            ['token' => $token]);
        });
        Mail::to($request->email)->send(new ForgotPassword($token));
        return response()->json(['success' => true]);
    }
}
