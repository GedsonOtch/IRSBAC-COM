<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ue;
use App\Models\Filiere;
use App\Models\Ecue;
use App\Models\Infoirsbac;

class UeController extends Controller
{
    //

public function index()
{
    $ues = Ue::with('filieres')
        ->latest()
        ->get();

    $filieres = Filiere::all();

      $ecues = Ecue::with(
        'ue'
    )->latest()->get();

    $info = Infoirsbac::first();
    return view(
        'admin.ecue',
        compact(
            'ues',
            'filieres',
            'ecues',
            'info'
        )
    );
}





public function store(Request $request)
{


    $request->validate([

        'nom' => 'required|string',

        'code' => 'nullable',

        'credit' => 'required|integer',

        'semestre' => 'required',

        'filieres' => 'required|array',

        'niveau'   => 'required'

    ]);

    $ue = Ue::create([

        'nom' => $request->nom,

        'code' => $request->code,

        'credit' => $request->credit,

        'semestre' => $request->semestre,
        'niveau' => $request->niveau

    ]);

    $ue->filieres()->sync(
        $request->filieres
    );

    return back()->with(

    'success',

    'UE enregistrée avec succès'
);
}




public function update(
    Request $request,
    Ue $ue
)

{


    $request->validate([

        'nom' => 'required',

        'credit' => 'required',

        'semestre' => 'required',

        'filieres' => 'required|array'

    ]);

    $ue->update([

        'nom' => $request->nom,

        'code' => $request->code,

        'credit' => $request->credit,

        'semestre' => $request->semestre

    ]);

    $ue->filieres()->sync(
        $request->filieres
    );

    return back()->with(
        'success',
        'UE modifiée'
    );
}



public function destroy(Ue $ue)
{
    $ue->delete();

    return back()->with(
        'success',
        'UE supprimée'
    );
}

}