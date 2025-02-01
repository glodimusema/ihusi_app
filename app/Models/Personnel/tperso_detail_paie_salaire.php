<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_detail_paie_salaire extends Model
{
    protected $fillable=['id','refFichePaie','refAffectation','salaire_base_paie','fammiliale_paie','logement_paie',
    'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie',
    'onem_paie','ipr_paie','avance_paie','soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie',
    'heure_supp2_paie','heure_supp3_paie','assurances_paie','author'];
    protected $table = 'tperso_detail_paie_salaire';
}


//avance_paie,soins_paie,jourpreste_paie,salaire_horaire,heure_supp1_paie,heure_supp2_paie,heure_supp3_paie,assurances_paie
//tperso_detail_paie_salaire refFichePaie,refAffectation,salaire_base,fammiliale,logement,transport,sal_brut,sal_brut_imposable,inss_qpo,inss_qpp,cnss,inpp,onem,ipr,author


 