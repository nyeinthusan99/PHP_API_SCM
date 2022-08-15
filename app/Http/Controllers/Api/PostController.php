<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use Illuminate\Validation\Rule;
use App\Http\Requests\PostCreateRequest;

use App\Contracts\Services\PostServiceInterface;

class PostController extends Controller
{
    private $postService;
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    //to get post list & search
    public function index(Request $request)
    {
        $posts = $this->postService->index($request);
        return $posts;
    }

    //create
    public function store(PostCreateRequest $request)
    {
        $request->validated();

        $post = $this->postService->create($request);
        return response()->json([
        "success" => true,
        "message" => "Post created successfully.",
        "data" => $post
        ],200);
    }

    //get post info
    public function show($id)
    {
        $post = $this->postService->show($id);
        if (is_null($post)) {
        return response()->json([
            "success" => false,
            "message" => "Product not found."
            ],422);
        }
        return response()->json([
        "success" => true,
        "message" => "Post retrieved successfully.",
        "data" => $post
        ],200);
    }


    //update
    public function update(Request $request,Post $post)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'title' => [Rule::unique("posts","title")->ignore($post->id)],
        'description' => 'required',
        'user_id' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Wrong',
                'errors' => $validator->errors()
            ],422);
        }

        $post = $this->postService->update($request,$post);
        return response()->json([
        "success" => true,
        "message" => "Post updated successfully.",
        "data" => $post
        ],200);
    }


    //delete
    public function destroy(Post $post)
    {
        $post = $this->postService->delete($post);
        return response()->json([
        "success" => true,
        "message" => "Post deleted successfully.",
        "data" => $post
        ]);
    }

    //import
    public function import(Request $request,User $user)
    {

        $input = $request->only(['file']);

        $validate_data = [
            'file' => 'required|mimes:xlsx,csv,txt',
        ];

        $validator = Validator::make($input, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error!',
                'errors' => $validator->errors()
            ],422);
        }
        Excel::import(new PostsImport($request->user()->id), $request->file('file'));
        return response()->json([
        'result' => 1,
        'message' => 'Import successfully'
       ],200);



    }

    //export
    public function export($id)
    {
        return Excel::download(new PostsExport($id),'posts.xlsx');
    }

}



