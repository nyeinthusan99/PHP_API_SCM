<?php

namespace App\Dao;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Dao\UserDaoInterface;

class UserDao implements UserDaoInterface
{
    public function register($request)
    {
            $input = $request->all();
            if($request->hasFile('image')){
                $file = $request->file('image');
                $file_name = uniqid(time()).$file->getClientOriginalName();
                Storage::disk('public')->put($file_name, File::get($file));
                $filePath   = 'storage/' . $file_name;
            }else {
                $filePath = "";
            }
                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => bcrypt($request->password),
                    'image' => $filePath,
                    'type' => $input['type'],
                    'phone' =>$input['phone'],
                    'address' => $input['address'],
                    'dob' =>$input['dob'],
                ]);
            return $user;
    }

    public function login($request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
          ];

        return $input;
    }

    public function userInfo($request)
    {
        $user = $request->user();
        return $user;
    }

    public function update($request)
    {
        $input = $request->all();

        $user = User::find($request->id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = uniqid(time()).$file->getClientOriginalName();
            Storage::disk('public')->put($file_name, File::get($file));
            $filePath   = 'storage/' . $file_name;
        }else{
            $filePath= $user->image;
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->image = $filePath;
        $user->type = $input['type'];
        $user->phone = $input['phone'];
        $user->address = $input['address'];
        $user->dob = $input['dob'];
        $user->save();

        return $user;
    }

    public function delete($user)
    {
        if($user){
            $file = $user['image'];
            \File::delete($file);
            $user = User::where('id', $user['id'])->delete();
        }

        return $user;
    }

    public function search($request)
    {
        $user = User::where('name','LIKE','%'.request('name').'%');
        if(isset($request->email)){
            $user = User::where('email','LIKE','%'.request('email').'%');
        }
        if(isset($request->type)){
            $user = User::where('type',request('type'));
        }
        return $user->orderBy('id','DESC')->paginate(3);
    }

    public function create($request)
    {
        $input = $request->all();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = uniqid(time()).$file->getClientOriginalName();
            Storage::disk('public')->put($file_name, File::get($file));
            $filePath   = 'storage/' . $file_name;
        }else {
            $filePath = "";
          }
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($request->password),
            'image' => $filePath,
            'type' => $input['type'],
            'phone' =>$input['phone'],
            'address' => $input['address'],
            'dob' =>$input['dob'],
        ]);

        return $user;
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function changePassword($request)
    {
        $user = User::find($request->user()->id);
        //return $request->user()->id;
        if(!Hash::check($request['oldPassword'],$user->password)){
            return false;
        }else{
            return User::where('id', '=', $request->user()->id )->update(['password' => Hash::make($request['newPassword'])]);
        }
    }
}
