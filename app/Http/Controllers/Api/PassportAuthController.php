<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Contracts\Services\UserServiceInterface;

class PassportAuthController extends Controller
{

    private $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    //register
     public function register(UserRegisterRequest $request)
     {
        $request->validated();

        $user = $this->userService->register($request);

        return response()->json([
            'success' => true,
            'message' => 'User register succesfully, Use token to authenticate.',
        ], 200);
    }

    //login

    public function login(UserLoginRequest $request)
    {
        $request->validated();

        $input = $this->userService->login($request);
        if (auth()->attempt($input)) {
            $token = auth()->user()->createToken('passport_token')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully, Use token to authenticate.',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'User authentication failed.'
            ], 401);
        }
    }

    //get user information
    public function userInfo(Request $request)
    {
        $user= $this->userService->userInfo($request);
        return response()->json(['user'=>$user],200);
    }

    //logout

    public function logout(Request $request)
    {
        $access_token = $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    }

    //update

    public function updateUser(UserUpdateRequest $request,$id,User $user)
    {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //    'name' => 'required',
        //    'email' => [Rule::unique("users","email")->ignore($id),'required'],
        //    'type' => 'required',
        //    'phone' => 'required|numeric|regex:/(09)[0-9]{9}/',
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Wrong',
        //         'errors' => $validator->errors()
        //     ],422);
        // }
        $request->validated();

        $user = $this->userService->update($request,$id,$user);

        return response()->json([
        "success" => true,
        "message" => "User updated successfully.",
        "data" => $user
        ],200);
    }

    //delete

    public function destroy(User $user)
    {
        $user = $this->userService->delete($user);

        return response()->json([
        "success" => true,
        "message" => "User deleted successfully.",
        "data" => $user
        ]);
    }

    //list & search

    public function userLists(Request $request)
    {
        $user = $this->userService->search($request);
        return $user;
    }

    public function store(UserCreateRequest $request)
    {
        $request->validated();

        $user = $this->userService->create($request);
             return response()->json([
                'success' => true,
                "message" => "User created successfully.",
                "data" => $user
            ], 200);
    }

    public function show($id)
    {
        $user = $this->userService->show($id);
        if (is_null($user)) {
        return response()->json([
            "success" => false,
            "message" => "User not found."
            ]);
        }
        return response()->json([
        "success" => true,
        "message" => "User retrieved successfully.",
        "data" => $user
        ]);
    }
}



