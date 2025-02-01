<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel\thotel_billard;
use App\Traits\{GlobalMethod,Slug};
use DB;
class thotel_billardController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

     //id,refClient,montant_paie,devise,taux,date_paie,heure_debut,heure_fin,libelle,author

    public function all(Request $request)
    { 

        $data = DB::table('thotel_billard')
        ->join('tvente_client','tvente_client.id','=','thotel_billard.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_billard.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_billard.id','refClient','montant_paie','date_paie',
        'thotel_billard.heure_debut','thotel_billard.heure_fin' ,
        'thotel_billard.author','thotel_billard.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_billard.devise','thotel_billard.taux','tvente_categorie_client.designation as CategorieClient',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'thotel_billard.refUser')
        ->selectRaw('((montant_paie)/thotel_billard.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_billard.id) as codeRecu');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_billard.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("thotel_billard.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('thotel_billard')
        ->join('tvente_client','tvente_client.id','=','thotel_billard.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_billard.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_billard.id','refClient','montant_paie','date_paie',
        'thotel_billard.heure_debut','thotel_billard.heure_fin' ,
        'thotel_billard.author','thotel_billard.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_billard.devise','thotel_billard.taux','tvente_categorie_client.designation as CategorieClient',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'thotel_billard.refUser')
        ->selectRaw('((montant_paie)/thotel_billard.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_billard.id) as codeRecu')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_billard.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("thotel_billard.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('thotel_billard')
        ->join('tvente_client','tvente_client.id','=','thotel_billard.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_billard.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_billard.id','refClient','montant_paie','date_paie',
        'thotel_billard.heure_debut','thotel_billard.heure_fin' ,
        'thotel_billard.author','thotel_billard.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_billard.devise','thotel_billard.taux','tvente_categorie_client.designation as CategorieClient',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'thotel_billard.refUser')
        ->selectRaw('((montant_paie)/thotel_billard.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_billard.id) as codeRecu')
        ->where('thotel_billard.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refEnteteVente','montant_paie','date_paie'
    function insert_data(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
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
            if($request->devise != 'USD')
            {
                $montants = ($request->montant_paie)/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $request->montant_paie;
                $devises = $request->devise;
            }
            //refUser

            $data = thotel_billard::create([
                'refClient'       =>  $request->refClient,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $request->date_paie,
                'modepaie'       =>  $request->modepaie,
                'libellepaie'       =>  $request->libellepaie, 
                'refBanque'       =>  $request->refBanque,
                'numeroBordereau'       =>  $request->numeroBordereau,
                'heure_debut'       =>  $request->heure_debut,
                'heure_fin'       =>  $request->heure_fin,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
       }

    }

    function update_data(Request $request, $id)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
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
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }


        $data = thotel_billard::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'heure_debut'       =>  $request->heure_debut,
            'heure_fin'       =>  $request->heure_fin,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }

    }

    function delete_data($id)
    {
        $data = thotel_billard::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
