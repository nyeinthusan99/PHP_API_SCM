<?php

namespace App\Dao;
use App\Models\Post;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{
    public function index($request)
    {
        \Log::info($request);
        $posts = Post::where('title', 'LIKE', '%'. request('title') .'%')
                ->when($request['description'], function($query) {
                 $query->where('description', 'LIKE', '%' . request('description') . '%');
                })->when($request['type'] !=0,function($query){
                    $query->where('user_id',request('id'));
                })->orderBy('id','DESC')->paginate(5)->withQueryString();

        return $posts;
    }

    public function create(array $data)
    {
        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['user_id'],
        ]);
        return $post;
    }

    public function show($id)
    {
         $post = Post::where('id',$id)->with('user')->first();
         return $post;
    }

    public function update($request)
    {
        $input = $request->all();
        $post = Post::find($input['id']);

        $post->title = $input['title'];
        $post->description = $input['description'];
        $post->user_id =$input['user_id'];
        $post->save();

        return $post;

    }

    public function delete($post)
    {
        if($post){
            $post = Post::where('id', $post['id'])->delete();
        }

        return $post;
    }
}


