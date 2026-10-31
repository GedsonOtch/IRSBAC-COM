<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttestationTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttestationTemplateController extends Controller
{
    public function index()
    {
        $template =
            AttestationTemplate::first();

        return view(
            'admin.modele_signature',
            compact('template')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'nom' => 'required',

            'pdf' => 'required|mimes:pdf'
        ]);

        $ancien =
            AttestationTemplate::first();

        if ($ancien) {

            Storage::disk('public')
                ->delete(
                    $ancien->pdf_path
                );

            $ancien->delete();
        }

        $path =
            $request->file('pdf')
            ->store(
                'attestations',
                'public'
            );

        AttestationTemplate::create([

            'nom' =>
                $request->nom,

            'pdf_path' =>
                $path,

            'actif' =>
                true
        ]);

        return back()->with(
            'success',
            'Template enregistré.'
        );
    }

    public function destroy()
    {
        $template =
            AttestationTemplate::first();

        if ($template) {

            Storage::disk('public')
                ->delete(
                    $template->pdf_path
                );

            $template->delete();
        }

        return back()->with(
            'success',
            'Template supprimé.'
        );
    }
}