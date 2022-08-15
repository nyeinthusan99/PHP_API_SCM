<?php

namespace App\Services;
use App\Contracts\Services\PostServiceInterface;
use App\Contracts\Dao\PostDaoInterface;

class PostService implements PostServiceInterface
{
    private $postDao;
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }

    public function index($request)
    {
        return $this->postDao->index($request);
    }

    public function create($request)
    {
        return $this->postDao->create($request);
    }

    public function show($request)
    {
        return $this->postDao->show($request);
    }

    public function update($request,$post)
    {
        return $this->postDao->update($request,$post);
    }

    public function delete($post)
    {
        return $this->postDao->delete($post);
    }
}

