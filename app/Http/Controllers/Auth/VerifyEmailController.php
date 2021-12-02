<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Verified;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Laravel\Fortify\Http\Requests\VerifyEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verify($id) {
        $user = User::findOrFail($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            return request()->wantsJson()
                ? new JsonResponse('', 204)
                : redirect(url(env('SPA_URL')).'/?verified=1');
        }
        //if user is already verified
        return request()->wantsJson()
            ? new JsonResponse('', 204)
            : redirect(url(env('SPA_URL')).'/?verified=1');
    }

    public function resend() {
        if(request()->user()->hasVerifiedEmail()){
          
            return response([
                'data' => [
                    'message' => 'Your email is already verified!',
                ]
            ]);
        }
        
        request()->user()->sendEmailVerificationNotification();
        return response([
            'data' => [
                'message' => 'Email has been sent!',
            ]
        ]);
    }
}