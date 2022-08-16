<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ForgotPasswordRequest;
use App\Contracts\Services\ForgotServiceInterface;

class ForgetPasswordController extends Controller
{
    private $forgotService;
    public function __construct(ForgotServiceInterface $forgotService)
    {
        $this->forgotService = $forgotService;
    }

    protected function sendResetLinkResponse(ForgotPasswordRequest $request)
        {
            //send link to mail

            $request->validated();

            $response = $this->forgotService->forgot($request);

            if($response == Password::RESET_LINK_SENT){
              $message = "Mail send successfully";
            }
            else{
              $message = "Email could not be sent to this email address";
            }

            $response = ['message' => $message];

            return response($response, 200);
        }
}

