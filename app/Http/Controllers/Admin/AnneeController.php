<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnneeRequest;
class AnneeController extends Controller
{
    //

  

    public function create()
    {
        return view('admin.dashboard');
    }

    public function store(StoreAnneeRequest $request)
    {
        AnneeAcademique::create($request->validated());

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Année académique ajoutée avec succès.');
    }
}
