<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 11px;
    margin: 30px 35px;
    color: #000;
    line-height: 1.4;
}

/* ── Numéro ── */
.numero {
    text-align: right;
    font-size: 11px;
    margin-bottom: 8px;
}

/* ── Titre ── */
.title {
    text-align: center;
    font-weight: bold;
    font-size: 13px;
    text-decoration: underline;
    letter-spacing: 0.5px;
    margin-bottom: 14px;
}

/* ── Infos étudiant ── */
.info {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
}

.info td {
    padding: 2px 4px;
    vertical-align: top;
    font-size: 11px;
}

.info td:first-child {
    width: 50%;
}

/* ── Tableau des notes ── */
.notes {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

.notes th {
    border: 1px solid #000;
    padding: 5px 4px;
    text-align: center;
    font-weight: bold;
    font-size: 11px;
    background-color: #fff;
}

.notes td {
    border: 1px solid #000;
    padding: 3px 5px;
    font-size: 11px;
}

.notes th:first-child,
.notes td:first-child {
    width: 55%;
    text-align: left;
}

/* UE en gras */
.ue td {
    font-weight: bold;
}

/* ECUE en retrait */
.ecue td:first-child {
    padding-left: 20px;
    font-weight: normal;
}

/* Valeurs numériques centrées */
.center {
    text-align: center;
}

/* ── Résumé + Signature ── */
.resume-signature {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.resume-signature td {
    vertical-align: top;
    padding: 0;
}

.resume-signature td:first-child {
    width: 50%;
}

.resume-signature td:last-child {
    width: 50%;
    text-align: center;
}

.total-ue {
    font-size: 11px;
    margin-bottom: 6px;
}

.resume-box {
    display: inline-block;
    border: 1px solid #000;
    padding: 6px 10px;
    font-size: 11px;
    line-height: 2;
}

/* ── Zone signature ── */
.signature-label {
    font-weight: bold;
    margin-bottom: 8px;
}

.signature {
    position: absolute;
    
    right: 100px;
    margin-top: 25px;
   z-index: 2;
   height: 50px;
    display: block;
    
}

.cachet{
    position: absolute;
    
    right: 130px;
    width: 130px;
    z-index: 1;
    height: 85px;
    display: block;
    margin: 6px auto;
    
}

.directeur-nom {
    font-weight: bold;
    margin-top: 90px;
}

</style>
</head>

<body>

<div class="numero">
    N° {{ $numero }}
</div>

<div class="title">
    RELEVE DE NOTES DE L'ETUDIANT
</div>

<table class="info">
    <tr>
        <td>Nom : {{ $etudiant->nom }}</td>
        <td>Année Universitaire : {{ $anneeAcademique->libelle }}</td>
    </tr>
    <tr>
        <td>Prénoms : {{ $etudiant->prenom }}</td>
        <td>Année d'étude : {{ $etudiant->annee_etude }} ème année</td>
    </tr>
    <tr>
        <td>Date et lieu de naissance : {{ $etudiant->date_naissance }} à {{ $etudiant->lieu_naissance }}</td>
        <td>Filière : {{ $etudiant->filiere->nom }}</td>
    </tr>
    <tr>
        <td>Matricule : {{ $etudiant->matricule }}</td>
        <td>Semestre : {{ $semestre }}</td>
    </tr>
</table>

<table class="notes">
    <thead>
        <tr>
            <th>Intitulé des UE / Intitulé des ECUE</th>
            <th style="width:10%">Note</th>
            <th style="width:10%">Moyenne</th>
            <th style="width:10%">Crédit</th>
            <th style="width:15%">Décision</th>
        </tr>
    </thead>
    <tbody>

        @php $totalUe = 0; $totalValide = 0; @endphp

        @foreach($lignes as $ligne)

            @if($ligne['type'] == 'ue')
                @php
                    $totalUe++;
                    if($ligne['decision'] == 'Validée') $totalValide++;
                @endphp
                <tr class="ue">
                    <td>{{ $ligne['nom'] }}</td>
                    <td></td>
                    <td class="center">{{ number_format($ligne['moyenne'], 2, ',', ' ') }}</td>
                    <td class="center">{{ $ligne['credit'] }}</td>
                    <td class="center">{{ $ligne['decision'] }}</td>
                </tr>
            @else
                <tr class="ecue">
                    <td>{{ $ligne['nom'] }}</td>
                    <td class="center">{{ number_format($ligne['note'], 2, ',', ' ') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif

        @endforeach

    </tbody>
</table>

<table class="resume-signature">
    <tr>
        <td>
            <p class="total-ue">Total UE validé {{ $totalValide }} sur {{ $totalUe }}</p>
            <div class="resume-box">
                <p>Moyenne du semestre : <strong>{{ number_format($moyenneGenerale, 2, ',', ' ') }}</strong></p>
                <p>Décision du Jury : <strong>{{ $decision }}</strong></p>
            </div>
        </td>
        <td>
            <p class="signature-label">Signature et cachet du Directeur</p>

            @if($signaturePath)
                <img src="{{ $signaturePath }}" class="signature">
            @endif


            
            @if($cachetPath)
                <img src="{{$cachetPath}}" class="cachet">
            @endif

            <p class="directeur-nom">{{ $nomDirecteur}}</p>
        </td>
    </tr>
</table>

</body>
</html>