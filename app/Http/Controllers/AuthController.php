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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'cin' => 'required|numeric|digits:8|unique:users,cin',
            'domaine' => 'string',


        ]);
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'cin' => $fields['cin'],
            'domaine' => $fields['domaine'],
            'coordinator'=> 0,
            'service_rh'=> 0,
            "encadrant"=> 1,
            "status" => 1,

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

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'cin' => 'required|numeric|digits:8|unique:users,cin',
            'domaine' => 'string',
        ]);

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return "user has been deleted";
    }
}
