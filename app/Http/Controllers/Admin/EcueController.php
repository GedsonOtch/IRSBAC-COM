<?php

namespace App\Http\Controllers\Admin;
use App\Models\Ue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ecue;
use App\Services\QrCodeService;
use Illuminate\Support\Str;
use App\Models\Filiere;
class EcueController extends Controller
{
    //

    public function index()
{
     $filieres = Filiere::all();
    $ecues = Ecue::with(
        'ue'
    )->latest()->get();

    $ues = Ue::orderBy('nom')
        ->get();

    return view(
        'admin.ecue',
        compact(
            'ecues',
            'ues',
            'filieres'
        )
    );
}




public function store(Request $request)
{
    $request->validate([

        'nom' =>
            'required',

        'coefficient' =>
            'numeric',

        'ue_id' =>
            'required'
    ]);

    Ecue::create([

        'nom' =>
            $request->nom,

        'coefficient' =>
            $request->coefficient,

        'ue_id' =>
            $request->ue_id
    ]);





    return back()->with(
        'success',
        'ECUE créée'
    );
}



public function update(
    Request $request,
    Ecue $ecue
)
{
    $ecue->update([

        'nom' =>
            $request->nom,

        'coefficient' =>
            $request->coefficient,

        'ue_id' =>
            $request->ue_id
    ]);

    return back()->with(
        'success',
        'ECUE modifiée'
    );
}


public function destroy(Ecue $ecue)
{
    $ecue->delete();

    return back()->with(
        'success',
        'ECUE supprimée'
    );
}


}
