<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreEtudiantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
 'matricule' => [
                'required',
                'string',
                'min:4',
                'max:20',
                'alpha_num',           // lettres et chiffres uniquement
                'unique:etudiants,matricule',
            ],


       'nom' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[\p{L}\s\-]+$/u', // lettres, espaces, tirets (accents inclus)
            ],
                       'prenom' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[\p{L}\s\-]+$/u',
            ],

            'date_naissance' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'before:' . now()->subYears(15)->toDateString(), // au moins 15 ans
                'after:1950-01-01',
            ],
                        'lieu_naissance' => [
                'required',
                'string',
                'min:2',
                'max:150',
                'regex:/^[\p{L}\s\-\,\.]+$/u',
            ],

            'filiere_id' => [
                'required',
                'integer',
                'exists:filieres,id',   // doit exister en base
            ],
                       'annee_etude' => [
                'required',
                'string',
                Rule::in(['1', '2', '3']), // uniquement ces valeurs
            ],

            'telephone' => [
                'nullable',
                'string',
                'min:8',
                'max:15',
                   'regex:/^\+?[0-9\s\-]+$/', // chiffres, +, espaces, tirets
            ],
                 'sexe' => [
                'required',
                'string',
                
            ],

            'annee_entree_id' =>[
                'required',
                'exists:annees_academiques,id'
            ]

            
        ];
    }

       public function messages(): array
    {
        return [
            // Matricule
            'matricule.required'   => 'Le matricule est obligatoire.',
            'matricule.min'        => 'Le matricule doit contenir au moins 4 caractères.',
            'matricule.max'        => 'Le matricule ne peut pas dépasser 20 caractères.',
            'matricule.alpha_num'  => 'Le matricule ne doit contenir que des lettres et des chiffres (sans espaces ni caractères spéciaux).',
            'matricule.unique'     => 'Ce matricule est déjà utilisé par un autre étudiant.',

                    // Nom
            'nom.required'         => 'Le nom est obligatoire.',
            'nom.min'              => 'Le nom doit contenir au moins 2 caractères.',
            'nom.max'              => 'Le nom ne peut pas dépasser 100 caractères.',
                        'nom.regex'            => 'Le nom ne doit contenir que des lettres, espaces et tirets.',

            // Prénom
            'prenom.required'      => 'Le prénom est obligatoire.',
            'prenom.min'           => 'Le prénom doit contenir au moins 2 caractères.',
            'prenom.max'           => 'Le prénom ne peut pas dépasser 100 caractères.',
            'prenom.regex'         => 'Le prénom ne doit contenir que des lettres, espaces et tirets.',

            // Date de naissance
            'date_naissance.required'    => 'La date de naissance est obligatoire.',
            'date_naissance.date'        => 'La date de naissance doit être une date valide.',
            'date_naissance.date_format' => 'La date de naissance doit être au format AAAA-MM-JJ.',
            'date_naissance.before'      => 'L\'étudiant doit avoir au moins 15 ans.',
            'date_naissance.after'       => 'La date de naissance semble invalide (trop ancienne).',

            // Lieu de naissance
            'lieu_naissance.required'    => 'Le lieu de naissance est obligatoire.',
            'lieu_naissance.min'         => 'Le lieu de naissance doit contenir au moins 2 caractères.',
            'lieu_naissance.max'         => 'Le lieu de naissance ne peut pas dépasser 150 caractères.',
            'lieu_naissance.regex'       => 'Le lieu de naissance contient des caractères non autorisés.',

                   // Filière
            'filiere_id.required'        => 'La filière est obligatoire.',
            'filiere_id.integer'         => 'La filière sélectionnée est invalide.',
            'filiere_id.exists'          => 'La filière sélectionnée n\'existe pas dans le système.',
            
            // Année d'étude
            'annee_etude.required'       => 'L\'année d\'étude est obligatoire.',
            'annee_etude.in'             => 'L\'année d\'étude doit être L1, L2 ou L3.',

            // Téléphone
            'telephone.min'              => 'Le numéro de téléphone doit contenir au moins 8 chiffres.',
            'telephone.max'              => 'Le numéro de téléphone ne peut pas dépasser 15 caractères.',
            'telephone.regex'            => 'Le numéro de téléphone n\'est pas valide (chiffres, +, tirets uniquement).',

            // Sexe
            'sexe.required'              => 'Le sexe est obligatoire.',
            'sexe.in'                    => 'Le sexe doit être "M" (Masculin) ou "F" (Féminin).',
        ];
}

    public function attributes(): array
    {
        return [
            'filiere_id'      => 'filière',
            'annee_etude'     => 'année d\'étude',
            'date_naissance'  => 'date de naissance',
            'lieu_naissance'  => 'lieu de naissance',
        ];
    }

        // Nettoyage avant validation
    protected function prepareForValidation(): void
    {
        $this->merge([
            'matricule' => strtoupper(trim($this->matricule ?? '')),
            'nom'       => trim($this->nom ?? ''),
            'prenom'    => trim($this->prenom ?? ''),
            'sexe'      => strtoupper(trim($this->sexe ?? '')),
        ]);
    }
}
