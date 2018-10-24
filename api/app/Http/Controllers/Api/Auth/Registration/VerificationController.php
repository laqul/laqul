<?php

namespace App\Http\Controllers\Api\Auth\Registration;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Auth\Registration\EmailVerification;
use App\Mail\EmailVerification as EmailVerificationCode;

class VerificationController extends Controller
{
    private function validateRequest(Request $request) {
        $request->validate([
            'client_id' => 'bail|required|string|exists:oauth_clients,id',
            'email' => ['required','email',
              Rule::unique('users')->where(function ($query) use ($request) {
                  return $query->where('client_id', $request->client_id);
              })]
        ]);
    }

    public function generateCode(Request $request){
        $this->validateRequest($request);
        $code = substr(uniqid(str_random(87)), 0, 100);
        EmailVerification::updateOrCreate(
          ['client_id' => $request->client_id, 'email' => $request->email],
          ['code' => $code]);
        Mail::to($request->email)->send(new EmailVerificationCode($code));
        return response()->json(['success' => true]);
    }
}
