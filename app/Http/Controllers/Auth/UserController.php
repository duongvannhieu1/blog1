<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use JWTAuthException;
use Hash;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255|min:6',
            'email'=>'required|email',
            'password'=>'required|min:6|max:255'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        return response()->json([
            'status'=>200,
            'massege'=>'User created successfully',
            'date'=>$user
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        try {
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function user_info(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result'=>$user]);
    }
}
