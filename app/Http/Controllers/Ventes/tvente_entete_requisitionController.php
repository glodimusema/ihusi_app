<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_requisition;
use App\Models\Ventes\tvente_detail_requisition;
use App\Models\Ventes\tvente_paiement_commande;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_requisitionController extends Controller
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

    // 'id','code','refFournisseur','module_id','refService','dateCmd','libelle',
    // 'niveau1','niveaumax','active','montant','paie','author','refUser'

    public function all(Request $request)
    { 

        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(montant - paie) as Reste');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            //dateCmd
            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_requisition.dateCmd", "desc");

            return $this->apiData($data->paginate(100));
           

        }
        $data->orderBy("tvente_entete_requisition.dateCmd", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function all_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tvente_entete_requisition')
                ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
                ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
                ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
                ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
                'refService','dateCmd','libelle','cloture',
                'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
                'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
                "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
                "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
                'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
                ,"tvente_module.nom_module","tvente_services.nom_service")
                ->selectRaw('(montant - paie) as Reste')   
                ->where([
                    ['noms', 'like', '%'.$query.'%'],
                    ['tvente_entete_requisition.dateCmd','>=', $date1],
                    ['tvente_entete_requisition.dateCmd','<=', $date2],
                ])               
                ->orderBy("tvente_entete_requisition.dateCmd", "desc")          
                ->paginate(100);
                return response($data, 200);
            }
            else{
                $data = DB::table('tvente_entete_requisition')
                ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
                ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
                ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
                ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
                'refService','dateCmd','libelle','cloture',
                'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
                'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
                "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
                "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
                'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
                ,"tvente_module.nom_module","tvente_services.nom_service")
                ->selectRaw('(montant - paie) as Reste')  
                ->where([
                    ['tvente_entete_requisition.dateCmd','>=', $date1],
                    ['tvente_entete_requisition.dateCmd','<=', $date2]
                ]) 
                ->orderBy("tvente_entete_requisition.dateCmd", "desc")          
                ->paginate(100);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function all_fournisseur_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2') && $request->get('refFournisseur'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $refFournisseur = $request->get('refFournisseur');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tvente_entete_requisition')
                ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
                ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
                ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
                ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
                'refService','dateCmd','libelle','cloture',
                'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
                'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
                "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
                "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
                'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
                ,"tvente_module.nom_module","tvente_services.nom_service")
                ->selectRaw('(montant - paie) as Reste')   
                ->where([
                    ['noms', 'like', '%'.$query.'%'],
                    ['tvente_entete_requisition.dateCmd','>=', $date1],
                    ['tvente_entete_requisition.dateCmd','<=', $date2],
                    ['tvente_entete_requisition.refFournisseur','=', $refFournisseur],
                ])               
                ->orderBy("tvente_entete_requisition.dateCmd", "desc")          
                ->paginate(100);
                return response($data, 200);
            }
            else{
                $data = DB::table('tvente_entete_requisition')
                ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
                ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
                ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
                ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
                'refService','dateCmd','libelle','cloture',
                'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
                'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
                "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
                "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
                'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
                ,"tvente_module.nom_module","tvente_services.nom_service")
                ->selectRaw('(montant - paie) as Reste')  
                ->where([
                    ['tvente_entete_requisition.dateCmd','>=', $date1],
                    ['tvente_entete_requisition.dateCmd','<=', $date2],
                    ['tvente_entete_requisition.refFournisseur','=', $refFournisseur],
                ]) 
                ->orderBy("tvente_entete_requisition.dateCmd", "desc")          
                ->paginate(100);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }



    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(montant - paie) as Reste')
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_requisition.dateCmd", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_requisition.dateCmd", "desc");
        return $this->apiData($data->paginate(10));
    }   
    
    

    public function fetch_data_encours(Request $request)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(montant - paie) as Reste')
        ->Where('tvente_entete_requisition.cloture','NON');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('noms', 'like', '%' . $query . '%')
                             ->orWhere('dateCmd', 'like', '%' . $query . '%');
            })          
            ->orderBy("tvente_entete_requisition.dateCmd", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_requisition.dateCmd", "desc");
        return $this->apiData($data->paginate(10));
    } 


  

    function fetch_commande_data_by_fournisseur($refFournisseur)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(CONCAT(tvente_fournisseur.noms," - ",tvente_entete_requisition.dateCmd, " - N° : ",tvente_entete_requisition.id )) as designationCommande')
        ->selectRaw('(montant - paie) as Reste')
        ->where('tvente_entete_requisition.refFournisseur', $refFournisseur)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(montant - paie) as Reste')
        ->where('tvente_entete_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_liste_commande()
    {
        $data = DB::table('tvente_entete_requisition')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_fournisseur.compte_fss_bl')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_requisition.id','tvente_entete_requisition.code','refFournisseur','module_id',
        'refService','dateCmd','libelle','cloture',
        'niveau1','niveaumax','tvente_entete_requisition.active','montant','paie','tvente_entete_requisition.author','tvente_entete_requisition.refUser',
        'tvente_entete_requisition.created_at',"tvente_fournisseur.noms","tvente_fournisseur.contact",
        "tvente_fournisseur.mail","tvente_fournisseur.adresse",'refCategorieFss', "tvente_categorie_fournisseur.nom_categoriefss",
        "compte_fss_bl",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte','numero_souscompte','refCompte','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte"
        ,"tvente_module.nom_module","tvente_services.nom_service")
        ->selectRaw('(CONCAT(tvente_fournisseur.noms," - ",tvente_entete_requisition.dateCmd, " - N° : ",tvente_entete_requisition.id )) as designationCommande')
        ->selectRaw('(montant - paie) as Reste')
        ->where('tvente_entete_requisition.paie','<=', 0)
        ->orderBy("tvente_entete_requisition.id", "desc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    // 'id','code','refFournisseur','module_id','refService','dateCmd','libelle',
    // 'niveau1','niveaumax','cloture','active','montant','paie','author','refUser'

    function insert_data(Request $request)
    {
        $module_id = 1;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);
        $data = tvente_entete_requisition::create([
            'code'       =>  $code,
            'refFournisseur'       =>  $request->refFournisseur,
            'module_id'       =>  $module_id,
            'refService'       =>  $request->refService,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'cloture'    =>  "NON", 
            'active'    =>  "OUI",            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {        
        $data = tvente_entete_requisition::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,            
            'refService'       =>  $request->refService,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'cloture'    =>  $request->cloture, 
            'active'    =>  $request->active,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_paiement_commande::where('refCommande',$id)->delete(); 
        $data = tvente_detail_requisition::where('refEnteteCmd',$id)->delete(); 
        $data = tvente_entete_requisition::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
