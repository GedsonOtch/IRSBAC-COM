{{-- resources/views/admin/releves/pdf/attestation.blade.php --}}
@php
    $etudiant = $attestation->etudiant;
    $fmt = fn ($d) => \Carbon\Carbon::parse($d)->format('d/m/Y');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Attestation de Réussite - IRSBAC</title>
<style>
  @page { size: A4 landscape; margin: 8mm; }
  body { margin: 0; padding: 0; font-family: 'Times New Roman', Times, serif; font-size: 13px; color: #000; }

  /* Cadres imbriqués (remplace ::before) : pas de width, la largeur est automatique */
  .cadre1 { border: 4px double #b8860b; padding: 4px; }
  .cadre2 { border: 2px solid #1a5d1a; padding: 3px; }
  .inner  { border: 1px dashed #999; padding: 12px 36px 10px; }

  /* En-tête */
  table.header { width: 100%; border-collapse: collapse; }
  table.header td { vertical-align: middle; text-align: center; }
  td.logo-cell { width: 90px; }
  .logo { width: 70px; height: 48px; padding-top: 22px; border-radius: 35px; background: #2e7d32;
          color: #ffd54f; font-size: 10px; font-weight: bold; text-align: center; margin: 0 auto; }
  .header h1 { margin: 0; font-size: 36px; letter-spacing: 3px; color: #8b0000; font-style: italic; }
  .header .l { margin: 2px 0 0; font-size: 12px; font-weight: bold; }
  .header .slogan { font-size: 14px; font-weight: bold; font-style: italic; }
  .initial { font-style: italic; font-weight: bold; }

  .sep { border-top: 1px solid #333; margin: 8px 0 6px; height: 0; }
  .ref { font-weight: bold; font-size: 13px; margin-bottom: 6px; }

  .title { text-align: center; margin: 8px 0 12px; font-size: 32px; font-weight: bold;
           letter-spacing: 2px; color: #e65100; }

  .content p { margin: 0 0 4px; line-height: 1.55; text-align: justify; }
  .fill { font-weight: bold; text-decoration: underline; }

  .date-line { text-align: right; font-weight: bold; margin: 18px 30px 0 0;  }

  table.signatures { width: 100%; border-collapse: collapse; margin-top: 6px; }
  table.signatures td { width: 50%; text-align: center; vertical-align: top; font-weight: bold; }
  .sig-space { position: relative; height: 62px; }
  .sig-space .cachet    { position: absolute; top: 0;  left: 55px;  width: 70px; }
  .sig-space .signature { position: absolute; top: 6px; left: 100px; width: 90px; }
</style>
</head>
<body>
<div class="cadre1"><div class="cadre2"><div class="inner">

  <table class="header">
    <tr>
      <td class="logo-cell"><div class="logo">IRSBAC<br>.COM</div></td>
      <td>
        <h1>IRSBAC.COM</h1>
        <div class="l slogan">"Toujours plus haut, Toujours plus fort"</div>
        <div class="l" style="font-weight:normal">
          <span class="initial">I</span>nstitut <span class="initial">R</span>égional <span class="initial">S</span>upérieur des
          <span class="initial">B</span>eaux-<span class="initial">A</span>rts, de la
          <span class="initial">C</span>ulture et de la <span class="initial">C</span>ommunication
        </div>
        <div class="l">Autorisé par arrêté N° 008/ MESRS/CAB/DC/SGM/DPP/DGESS/DEPES/SP du 05 Janvier 2011</div>
        <div class="l" style="font-style:italic">Quartier Ladjifarani Parakou Tél. 01 97 76 36 43</div>
        <div class="l" style="font-style:italic">République du Bénin</div>
      </td>
      <td class="logo-cell"><div class="logo">IRSBAC<br>.COM</div></td>
    </tr>
  </table>

  <div class="sep"></div>

  <div class="ref">
    N° <span class="fill">{{ $attestation->numero_formate }}</span> -<span class="fill">{{ $attestation->date_document->format('Y') }}</span> /IRSBAC.COM/ D/DE
  </div>

  <div class="title">ATTESTATION DE REUSSITE</div>

  <div class="content">
    <p>Vu la loi n°64-19 du 11 Août 1964 règlementant l'enseignement privé ;</p>
    <p>Vu le décret n°2007-442 du 02 octobre 2007 portant attribution organisation et fonctionnement du Ministère de l'Enseignement Supérieur et de la Recherche Scientifique ;</p>
    <p>Vu le décret n°2001-161 du 04 avril 2001 fixant des conditions générales de création, d'ouverture, d'extension, de fonctionnement d'un établissement privé d'enseignement scolaire, universitaire ; parascolaire, para universitaire et procédures administratives ;</p>
    <p>
      Vu les procès-verbaux du jury de délibération en date du <span class="fill">{{ $attestation->date_deliberation->format('d/m/Y') }}</span>
      attestant que M/Mme <span class="fill">{{ $etudiant->nom }} {{ $etudiant->prenom }}</span>
      né(e) le <span class="fill">{{ $fmt($etudiant->date_naissance) }}</span>
      à <span class="fill">{{ $etudiant->lieu_naissance }}</span>,
      inscrit(e) sous le numéro matricule <span class="fill">{{ $etudiant->matricule }}</span>
      au titre de l'année académique <span class="fill">{{ $attestation->annee_academique }}</span>
      a satisfait au contrôle des connaissances et aptitudes prévues par les textes réglementaires.
    </p>
    <p>
      Son mémoire ayant été soutenu avec succès devant un jury, Il (elle) a validé l'ensemble des Unités d'Enseignement
      pour l'obtention du diplôme de Licence Professionnelle/BAPES en <span class="fill">{{ $etudiant->filiere->nom }}</span>
    </p>
    <p>En foi de quoi cette attestation lui est délivrée pour servir et valoir ce que de droit.</p>
  </div>

  <div class="date-line">Fait à Parakou, le <span class="fill">{{ $attestation->date_document->translatedFormat('j F Y') }}</span></div>

  <table class="signatures">
    <tr>
      <td>
        Le Directeur des Etudes
        <div class="sig-space">
          @if($cachetDirecteur_etu_Path)<img class="cachet" src="{{ $cachetDirecteur_etu_Path }}">@endif
          @if($signatureDirecteur_etu_Path)<img class="signature" src="{{ $signatureDirecteur_etu_Path }}">@endif
        </div>
        Pierre MATCHOUDO
      </td>
      <td>
        Le Directeur
        <div class="sig-space">
          @if($cachetDirecteurPath)<img class="cachet" src="{{ $cachetDirecteurPath }}">@endif
          @if($signatureDirecteurPath)<img class="signature" src="{{ $signatureDirecteurPath }}">@endif
        </div>
        Dr. Julien Chambi ATCHADE
      </td>
    </tr>
  </table>

</div></div></div>
</body>
</html>
