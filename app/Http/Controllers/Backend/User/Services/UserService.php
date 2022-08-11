<?php 

namespace App\Http\Controllers\Backend\User\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService{

    public function register($request){
        $request['password'] = bcrypt($request['password']);
        $user = User::create($request);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $success;
    }

    public function login($request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $success;
        } 
        else{ 
            response()->json([
                "success" => false,
                "message" => "E-mail ve ya password hatalı"
            ]);
        } 
    }
}