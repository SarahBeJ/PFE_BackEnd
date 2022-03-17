<?php

namespace App\Http\Controllers;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class stageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Stage:: all();
    }

    public function register (Request $request){
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:stages,email',
            'password' => 'required|string',
            'cin' => 'required|numeric|digits:8|unique:stages,cin',
            'passport' => 'numeric',
            'phone' => 'required|numeric|digits:8',
            'niveau' => 'required|string',
            'domaine' => 'required|string',


        ]);
        $stage = Stage::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'cin' => $fields['cin'],
            'passport' => $fields['passport'],
            'phone' => $fields['phone'],
            'niveau' => $fields['niveau'],
            'domaine' => $fields['domaine'],
            'status'=> 1
            

        ]);

        $token = $stage->createToken('accessPfe')->plainTextToken;
        $response = [
            'user'=>$stage,
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
        $stage = Stage::where('email',$fields['email'])->first();

        //check password

        if(!$stage || !Hash::check($fields['password'],$stage->password)){
            return response([
                'message' => 'email or password wrong!'
            ], 401);
        }

        $token = $stage->createToken('accessPfe')->plainTextToken;
           
        $response = [
            'user' => $stage,
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
            'passport' => 'numeric',
            'phone' => 'required|numeric|digits:8',
            'niveau' => 'required|string',
            'domaine' => 'required|string',
        

        ]);
        return Stage::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Stage::find($id);
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
        $stage=Stage::find($id);
        $stage->update($request->all());
        return $stage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Stage::destroy($id);
    }
    /**
     * search the user bu his name 
     * 
     * @param string $nom
     * @return\Illuminate\Http\Response
     */
    public function search($nom){
        return Stage::where('nom','like','%.$nom'.'%')->get();
    }
}

