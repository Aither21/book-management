<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (
            password_verify($request->token, $passwordReset->token) &&
            !Carbon::parse($passwordReset->created_at)->diffInHours(Carbon::parse())
        ) {
            return redirect('reset-password/confirm/' . $request->token);
        }
        // 期限切れ,token,emailが違う場合はパスワード再発行画面にリダイレクト
        return redirect('forgot-password');
    }
}
