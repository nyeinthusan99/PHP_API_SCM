<?php

namespace App\Contracts\Services;
use Illuminate\Http\Request;

interface ForgotServiceInterface
{
    public function forgot($request);

    public function reset($request);
}
