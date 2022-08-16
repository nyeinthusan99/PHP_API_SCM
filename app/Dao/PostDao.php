<?php

namespace App\Dao;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Contracts\Dao\PostDaoInterface;

class PostDao implements PostDaoInterface
{
    public function index($request)
    {
        $posts = Post::where('title', 'LIKE', '%'. request('title') .'%')
                ->when($request['description'], function($query) {
                 $query->where('description', 'LIKE', '%' . request('description') . '%');
                })->when(request()->user()->type!=0,function($query){
                    $query->where('user_id',request()->user()->id);
                })->orderBy('id','DESC')->paginate(5)->withQueryString();

        return $posts;
    }

    public function create($request)
    {
        $input = $request->all();
        $post = Post::create([
            'title' => $input['title'],
            'description' => $input['description'],
            'user_id' => $input['user_id'],
        ]);
        return $post;
    }

    public function show($id)
    {
         $post = Post::find($id);
         return $post;
    }

    public function update($request,$post)
    {
        $input = $request->all();

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


