<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'pass' => 'required|confirmed',
        ]);

        $newUser = new User;
        $newUser->name     = $request->name;
        $newUser->email    = $request->email;
        $newUser->password = Hash::make($request->pass);
        $newUser->save();

        return response()->json('you have registered');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'pass' => 'required'
        ]);

        if(User::where('email' , $request->email)->exists()){
            $user = User::where('email' , $request->email)->first();
            if(Hash::check($request->pass, $user->password)){
                $token = $user->CreateToken('user_token')->plainTextToken;
                return response()->json([
                    'status' => 'you logged In ',
                    'token' => $token,
                ]);
            }else{
                echo "Password Is Incorrect";
            }
        }else{
            echo "No";
        }
    }

    public function profile(){

        $data = User::find(auth()->user()->id);
        return response()->json([
            'status' => 'profile',
            'data' => $data,
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json('You Logged Out');
    }

    public function image(Request $request){
        $request->validate([
            'img' => 'required',
            'email' => 'required|email|unique:users',
            'pass' => 'required',
        ]);


        $imageName  = $request->file('img')->getClientOriginalName();
        $imageStore = $request->file('img')->storeAs('img', $imageName , 'img');
        $newUser = new User;
        $newUser->name = $imageStore;
        $newUser->email = $request->email;
        $newUser->password = $request->pass;
        $newUser->save();
        return response()->json('You Uploaded an Image');
    }
}
