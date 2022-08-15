<?php

namespace App\Contracts\Dao;

interface PostDaoInterface
{
    public function index($request);

    public function create($request);

    public function show($id);

    public function update($request,$post);

    public function delete($post);
}
