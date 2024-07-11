<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class VerificationController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
//        $code= "你好";

      $code = rand(100000, 999999); // 生成六位验证码
        $email = $request->input('email');

        Mail::to($email)->send(new VerificationMail($code));

//        Mail::to($email)->send(new VerificationMail($code));

        return response()->json(['message' => '验证码已发送']);
    }
}

