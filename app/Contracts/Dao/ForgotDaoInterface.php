<?php

namespace App\Contracts\Dao;

interface ForgotDaoInterface
{
    public function forgot($request);

    public function reset($request);
}
