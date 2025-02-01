<?php

namespace App\Http\Controllers\Vehicule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicule\tcar_paiement;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tcar_paiementController extends Controller
{
    use GlobalMethod, Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    // 'id','refEnteteMvt','montant_paie','devise','taux',
    // 'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','author'

    public function all(Request $request)
    { 

        $data = DB::table('tcar_paiement')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')

        ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tcar_paiement.id','refEnteteMvt','montant_paie','date_paie',
        'tcar_paiement.devise','tcar_paiement.taux','tcar_paiement.author',
        'tcar_paiement.created_at','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details','Chauffeur','modepaie',
        'libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte',
        'tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'Info_devise')
        ->selectRaw('((montant_paie)/tcar_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tcar_paiement.id) as codeRecu');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tcar_paiement.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tcar_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tcar_paiement')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')

        ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tcar_paiement.id','refEnteteMvt','montant_paie','date_paie',
        'tcar_paiement.devise','tcar_paiement.taux','tcar_paiement.author',
        'tcar_paiement.created_at','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details','Chauffeur','modepaie',
        'libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte',
        'tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'Info_devise')
        ->selectRaw('((montant_paie)/tcar_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tcar_paiement.id) as codeRecu')
        ->Where('refEnteteMvt',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tcar_paiement.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tcar_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tcar_paiement')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')

        ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tcar_paiement.id','refEnteteMvt','montant_paie','date_paie',
        'tcar_paiement.devise','tcar_paiement.taux','tcar_paiement.author',
        'tcar_paiement.created_at','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details','Chauffeur','modepaie',
        'libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte',
        'tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'Info_devise')
        ->selectRaw('((montant_paie)/tcar_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tcar_paiement.id) as codeRecu')
        ->where('tcar_paiement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refEnteteMvt','montant_paie','date_paie'
    function insert_data(Request $request)
    {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'FC')
        {
            $montants = ($request->montant_paie)*$taux;
            $devises='FC';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }

//Info_devise
        $data = tcar_paiement::create([
            'refEnteteMvt'       =>  $request->refEnteteMvt,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'Info_devise'       =>  $request->Info_devise,
            'author'       =>  $request->author
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

    }

    function update_data(Request $request, $id)
    {
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'FC')
        {
            $montants = ($request->montant_paie)*$taux;
            $devises='FC';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }


        $data = tcar_paiement::where('id', $id)->update([
            'refEnteteMvt'       =>  $request->refEnteteMvt,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'Info_devise'       =>  $request->Info_devise,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

    }

    function delete_data($id)
    {
        $data = tcar_paiement::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
