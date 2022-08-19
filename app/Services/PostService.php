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

    public function create(array $data)
    {
        return $this->postDao->create($data);
    }

    public function show($request)
    {
        return $this->postDao->show($request);
    }

    public function update($request)
    {
        return $this->postDao->update($request);
    }

    public function delete($post)
    {
        return $this->postDao->delete($post);
    }

}

