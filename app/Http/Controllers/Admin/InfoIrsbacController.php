<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Infoirsbac;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\SecuritySetting;
class InfoIrsbacController extends Controller
{
    public function index()
    {
        $info = Infoirsbac::first();
  $admins = Admin::all();
  $security = SecuritySetting::first();
  
        return view(
            'admin.parametreadmin',
            compact('info', 'admins', 'security')
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom_etablissement' => 'required',
            'sigle' => 'required'
        ]);

        $info = Infoirsbac::first();

        if (!$info) {
            $info = new Infoirsbac();
        }

        $info->updateOrCreate(
            ['id' => $info->id ?? null],
            [
                'nom_etablissement' => $request->nom_etablissement,
                'sigle' => $request->sigle,
                'arrete_autorisation' => $request->arrete_autorisation,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'site_web' => $request->site_web,
                'directeur' => $request->directeur,
                'directeur_etudes' => $request->directeur_etudes,
            ]
        );

        return back()->with(
            'success',
            'Informations de l\'établissement mises à jour avec succès.'
        );
    }
}