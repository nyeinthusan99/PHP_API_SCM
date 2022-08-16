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
