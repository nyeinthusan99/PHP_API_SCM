<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordRequest;
use App\Contracts\Services\ForgotServiceInterface;

class ResetPasswordController extends Controller
{
    private $forgotService;
    public function __construct(ForgotServiceInterface $forgotService)
    {
        $this->forgotService = $forgotService;
    }
    //reset password
    protected function sendResetResponse(ResetPasswordRequest $request)
    {
        // $input = $request->only('email','token', 'password', 'password_confirmation');

        // $validator = Validator::make($input, [
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required|confirmed|min:8',
        // ]);

        // if ($validator->fails()) {
        //     return response(['errors'=>$validator->errors()->all()], 422);
        // }

        $request->validated();

        $response = $this->forgotService->reset($request);

        if($response == Password::PASSWORD_RESET){
            $message = "Password reset successfully";
        }else{
            $message = "Email could not be sent to this email address";
        }

        $response = ['message' => $message];

        return response()->json($response);

    }
}
