<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index (){
        return User::all();
    }

    public function register (Request $request){
        $fields = $request->validate([
            'first_name'=> 'required|string',
            'last_name'=>'required|string',

            'email'=> 'required|string|unique:users,email',
            'password'=> 'required|string',
            'cin'=> 'required|numeric|digits:8|unique:users,cin',
            'passport'=>'numeric',
            'telephone'=> 'required|numeric|digits:8',
            'niveau'=> 'required|string',
            'domaine'=> 'required|string',
        
                

        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name'=>$fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'cin' => $fields['cin'],
            'passport'=>$fields['passport'],
            'telephone' => $fields['telephone'],
            'niveau' => $fields['niveau'],
            'domaine' => $fields['domaine'],
          

         
        ]);

        $token = $user->createToken('accessPfe')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token,
       
        ];

        return response($response,201);
    }

    public function login (Request $request){
        
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        //find email
        $user = User::where('email',$fields['email'])->first();

        //check password

        if(!$user || !Hash::check($fields['password'],$user->password)){
            return response([
                'message' => 'email or password wrong!'
            ], 401);
        }

        $token = $user->createToken('accessPfe')->plainTextToken;
           
        $response = [
            'user' => $user,
            'token' => $token
        ];


        return response($response, 201);
    }
}
