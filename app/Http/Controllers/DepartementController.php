<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departement = Departement::paginate(10);
        return $departement;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nom' => 'required|string|unique:departement,nom',
            'chef' => 'required|string|unique:departements,chef', 
            'etat' =>'string',
        
        ]);
        if ($validator->fails())
        {
            return response()->json(
                ['validation_errors' => $request->messages(),
                 'status'=>422,
            ]);
            
        }
        else{
            Departement::create([
                'nom' => $request['nom'],
                'chef' =>$request['chef'],
                'etat' =>'activé',
                'utilisateurs' =>[]

            ]);
            return response()->json([
                'status'=>200,
                'message'=>'Departement Crée!'

            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $departement = Departement::find($id);
        return $departement;
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
        $departement = Departement::find($id);
        $departement->update($request->all());
        return $departement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactiver($id)
    {
        $departement=Departement::find($id);
        $departement->etat = 'désactivé';
        $departement->save();
        return $departement;
    }
    public function activer($id)
    {
        $departement=Departement::find($id);
        $departement->etat = 'activé';
        $departement->save();
        return $departement;
    }
}
