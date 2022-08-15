<?php

namespace App\Services;

use App\Contracts\Services\ForgotServiceInterface;
use App\Contracts\Dao\ForgotDaoInterface;

class ForgotService implements ForgotServiceInterface
{
    private $forgotDao;
    public function __construct(ForgotDaoInterface $forgotDao)
    {
        $this->forgotDao = $forgotDao;
    }

    public function forgot($request)
    {
        return $this->forgotDao->forgot($request);
    }

    public function reset($request)
    {
        return $this->forgotDao->reset($request);
    }
}
