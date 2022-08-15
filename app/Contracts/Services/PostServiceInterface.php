<?php

namespace App\Contracts\Services;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function index($request);

    public function create($request);

    public function show($id);

    public function update($request,$post);

    public function delete($post);

}
