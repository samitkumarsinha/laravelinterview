<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user['token'] = $user->createToken('abc')->accessToken;
        return response()->json($user, 200);
    }
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $data['token'] = Auth::user()->createToken('abc')->accessToken;
            return response()->json($data, 200);
        }
    }
    public function err(){
        return response()->json(['status' => 'Unauthenticated user' ]);
    }
    public function logout(Request $request){
        Auth::user()->token()->revoke();
        $data['message'] = 'Successfully logged out';
        return response()->json($data,200);
    }
    public function getcountry(Request $request){
        $data['country'] = User::all('country','city','address');
        return response()->json($data, 200);
    }
    public function getusers(Request $request){
        $data['country'] = User::all();
        return response()->json($data, 200);
    }
}
