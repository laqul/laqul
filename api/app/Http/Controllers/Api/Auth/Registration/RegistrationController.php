<?php

namespace App\Http\Controllers\Api\Auth\Registration;

use Validator;
use Carbon\Carbon;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Auth\Registration\EmailVerification;

class RegistrationController extends Controller
{
    private function validateRequest(Request $request)
    {
        $request->validate([
            'client_id' => 'bail|required|string|exists:oauth_clients,id',
            'name' => 'bail|required|string|min:4|max:30',
            'code' => ['bail', 'required', 'string', 'size:100',
            Rule::exists('email_verifications')->where(function ($query) {
                $query->where('updated_at', '>=', Carbon::now()->subMinutes(60));
            })],
            'password' => 'required|min:8|max:30|confirmed',
            'timezone' => 'required|min:2|max:50|in:' . implode(',', \DateTimeZone::listIdentifiers())
            ]);
    }

    public function registration(Request $request)
    {
        $this->validateRequest($request);
        $user = null;
        DB::transaction(function () use ($request, &$user) {
            $verification = EmailVerification::where('code', $request->code)->first();
            $user = User::create([
            'client_id' => $verification->client_id,
            'name' => title_case($request->name),
            'email' => $verification->email,
            'password' => bcrypt($request->password),
            'timezone' => $request->timezone
            ]);
            $verification->delete();
        });
        return $user;
    }
}
