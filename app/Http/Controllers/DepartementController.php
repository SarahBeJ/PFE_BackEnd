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
        $request->validate([
            'nom' => 'required|string|unique:departement,nom',
            'chef' => 'required|string|unique:departement,chef',
            'etat' => 'required|string',
            
        ]);

        return Departement::create([
            'nom' => $request['nom'],
            'chef' => $request['chef'],
            'etat' => $request['etat'],
            
        ]);
        {
        return response("information manquante", 400);
    }
    } 
    public function departement_user()
    {
        $user = Auth::user();
        $departement = Departement::all()->where('user_id', $user->_id);

        return response($departement, 200);
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
    public function destroy($id)
    {
        Departement::destroy($id);
        return "departement supprimé";
    }
}
