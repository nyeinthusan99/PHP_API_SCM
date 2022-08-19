<?php

namespace App\Contracts\Services;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function index($request);

    public function create(array $data);

    public function show($id);

    public function update($request);

    public function delete($post);

}
