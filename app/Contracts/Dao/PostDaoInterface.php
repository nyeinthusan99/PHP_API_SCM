<?php

namespace App\Contracts\Dao;
use Illuminate\Http\Request;

interface PostDaoInterface
{
    public function index($request);

    public function create(array $data);

    public function show($id);

    public function update($request);

    public function delete($post);
}
