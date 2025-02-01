<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    //
    protected $fillable = [
        'ceo','nomEntreprise','descriptionEntreprise','emailEntreprise','adresseEntreprise',
        'telephoneEntreprise','solutionEntreprise','idsecteur','idforme','etat',
        'idPays','idProvince','edition','facebook','linkedin','twitter','siteweb','rccm',
        'invPersonnel','invHub','invRecherche','chiffreAffaire','nbremploye','slug','logo',
    ];

}
