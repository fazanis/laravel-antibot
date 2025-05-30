<?php

use Illuminate\Support\Facades\Route;

Route::get('captcha/{config?}', [\Mews\Captcha\CaptchaController::class, 'getCaptcha'])->middleware('web')->name('captcha');

Route::post('/captcha_validate',function (\Illuminate\Http\Request $request){


        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['captcha' => 'Капча введена не верно!']);
        } else {
            session(['captcha_passed'=>true]);
            return redirect()->intended('/');
        }
//            if ($validator->fails()) {
//                session(['captcha_passed'=>false]);
//                return redirect()->back();
//            } else {
//                session(['captcha_passed'=>true]);
//                return redirect()->back();
//            }

})->middleware('web')->name('send.captcha');

