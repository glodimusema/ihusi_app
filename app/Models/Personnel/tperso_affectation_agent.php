<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_affectation_agent extends Model
{
    protected $fillable=['id','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
    'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge','etat_contrat','author'];
    protected $table = 'tperso_affectation_agent';
}


 