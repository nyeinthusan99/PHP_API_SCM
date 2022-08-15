<?php

namespace App\Services;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Dao\UserDaoInterface;

class UserService implements UserServiceInterface
{
    private $userDao;
    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }

    public function register($request)
    {
        return $this->userDao->register($request);
    }

    public function login($request)
    {
        return $this->userDao->login($request);
    }

    public function userInfo($request)
    {
        return $this->userDao->userInfo($request);
    }

    public function update($request,$id,$post)
    {
        return $this->userDao->update($request,$id,$post);
    }

    public function delete($user)
    {
        return $this->userDao->delete($user);
    }

    public function search($request)
    {
        return $this->userDao->search($request);
    }

    public function create($request)
    {
        return $this->userDao->create($request);
    }

    public function show($id)
    {
        return $this->userDao->show($id);
    }
}
