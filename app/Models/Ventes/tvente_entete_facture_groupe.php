<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_facture_groupe extends Model
{
    protected $fillable=['id','code','refOrganisation','module_id','etat_facture_group','dateGroup',
    'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
    'nombre_print_group','author','refUser'];
    protected $table = 'tvente_entete_facture_groupe';
}
