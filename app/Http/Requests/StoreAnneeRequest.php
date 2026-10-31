<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
class StoreAnneeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'libelle' => 'required|string|unique:annees_academiques,libelle|regex:/^\d{4}-\d{4}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => "Le libellé de l'année académique est obligatoire.",
            'libelle.unique'   => "Cette année académique existe déjà.",
            'libelle.regex'    => "Le libellé doit être au format AAAA-AAAA (ex: 2025-2026).",
        ];
    }
}