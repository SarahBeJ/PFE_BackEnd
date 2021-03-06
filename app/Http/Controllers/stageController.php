<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StageController extends Controller
{


    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:stages,email',
            'password' => 'required|string|confirmed',
            'cin' => 'required|numeric|digits:8|unique:stages,cin',
            'phone' => 'numeric',
            'passport' => 'numeric|digits:8|unique:stages,passport',
            'niveau' => 'required|string',
            'domaine' => 'required|string',
            'image' => 'nullable',


        ]);
        if ($request->hasFile('image')) {
            $imageFullName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageFullName);

            $user = Stage::create([
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'cin' => $fields['cin'],
                'domaine' => $fields['domaine'],
                'niveau' => $fields['niveau'],
                'phone' => $fields['phone'],
                "status" => true,
                "image" => Storage::url("images/" . $imageFullName)
            ]);

            $token = $user->createToken('sara-pfe-user')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,

            ];


            return response($response, 201);
        } else {

            $user = Stage::create([
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'cin' => $fields['cin'],
                'domaine' => $fields['domaine'],
                'niveau' => $fields['niveau'],
                "status" => true,
                "image" => null
            ]);

            $token = $user->createToken('sara-pfe-user')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,

            ];


            return response($response, 201);
        }
    }
public function login (Request $request){
        
        $fields = $request->validate([
            'cin' => 'required|numeric|digits:8|',
            'password' => 'required|string',
           
            
        ]);
        //find email
        $stage = Stage::where('cin',$fields['cin'])->first();

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stage::paginate(10);
        return $stages;
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
            'email' => 'required|email|unique:stages,email',
            'password' => 'required|string',
            'cin' => 'required|numeric|digits:8|unique:stages,cin',
            'passport' => 'required|numeric|digits:8|unique:stages,passport',
            'phone' => 'required|numeric|digits:8|unique:',
            'niveau' => 'required|string',
            'domaine' => 'required|string',
            'image' => 'required|mimes:pdf , xlx,csv|max:2048',
        

        ]);
        
        if ($request->hasFile('image')) {
            $imageFullName = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageFullName);

            $subject = Stage::create([
                
                "image" => Storage::url("images/" . $imageFullName)
            ]);

            return response($subject, 201);
        };

        return response("Please Select an Image", 400);
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