<?php

namespace App\Contracts\Services;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function register($request);

    public function login($request);

    public function userInfo($request);

    public function update($request);

    public function delete($user);

    public function search($request);

    public function create($request);

    public function show($id);

    public function changePassword($request);
}
