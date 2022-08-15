<?php

namespace App\Dao;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Dao\ForgotDaoInterface;
use Illuminate\Auth\Events\PasswordReset;

class ForgotDao implements ForgotDaoInterface
{
    public function forgot($request)
    {
        $input = $request->only('email');
        $response =  Password::sendResetLink($input);
        return $response;
    }

    public function reset($request)
    {
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
            'password' => Hash::make($password)
            ])->save();
            event(new PasswordReset($user));
        });

        return $response;
    }

}
