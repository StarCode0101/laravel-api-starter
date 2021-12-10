<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TwoFactorAuthController extends Controller
{
    public function confirm(Request $request)
    {
        $confirmed = $request->user()->confirmTwoFactorAuth($request->code);

        if (!$confirmed) {
            return $request->wantsJson()
            ? new JsonResponse('Invalid Two Factor Authentication code', 403)
            : back()->with('status','Invalid Two Factor Authentication code');

        }

        return $request->wantsJson()
        ? new JsonResponse('Two factor authentication code has been setup succesfully', 200)
        : back()->with('status', 'Two factor authentication code has been setup succesfully');
        
    }
}