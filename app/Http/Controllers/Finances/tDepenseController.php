<?php

namespace App\Http\Controllers\Finances;
//tfin_cloture_caisse
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Http\Request;
use App\Models\Finances\tDepense;
use App\Models\Finances\tfin_entete_operationcompte;
use App\Models\Finances\tfin_detail_operationcompte;
use App\Models\Finances\{tfin_cloture_comptabilite};
use App\Models\Finances\{tfin_cloture_caisse};

use DB;

class tDepenseController extends Controller
{
    
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where('motif', 'like', '%'.$query.'%')
            ->orwhere('Compte', 'like', '%'.$query.'%')            
            ->orderBy("tdepense.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);
            return response($data, 200);
        }

    }


    public function fetch_mouvement_depense(Request $request)
    {     
        
       
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['motif', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '2']
            ])         
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour', "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->Where('tdepense.refMvt','2')   
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }    


    public function fetch_mouvement_entree(Request $request)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour', "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['motif', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '1']
            ])         
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at",'numeroBE')
            ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->Where('tdepense.refMvt','1')   
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }    

    function fetch_single_depense($id)
    {
        $data = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

        ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
        "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
        'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
        "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
        "tdepense.created_at","tdepense.updated_at","numeroBE")
        ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
        ->where('tdepense.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


    function insert_depense(Request $request)
    {
        // $resteLettre = $this->chiffreEnLettre($request->montant);
        $datetest='';
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateOperation)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateOperation)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {//
            $taux=0;
            $taux = DB::table("tvente_taux")
            ->select("tvente_taux.id", "tvente_taux.taux", 
            "tvente_taux.created_at", "tvente_taux.author")
            ->get();
    
            foreach ($taux as $tau) {
                $taux= $tau->taux;
            }
           
             $data = tDepense::create([
                 'montant'       =>  $request->montant,
                 'montantLettre'    =>  $request->montantLettre,
                 'motif'    =>  $request->motif,
                 'dateOperation'    =>  $request->dateOperation,
                 'refMvt'    =>  $request->refMvt,
                 'refCompte'    =>  $request->refCompte,
                 'modepaie'    =>  $request->modepaie,
                 'refBanque'    =>  $request->refBanque,
                 'numeroBordereau'    =>  $request->numeroBordereau,
                 'taux_dujour'    =>  $taux,
                 'numeroBE'    =>  $request->numeroBE,
                 'author' =>  $request->author
             ]);
             return response()->json([
                 'data'  =>  "Insertion avec succès!!!",
             ]); 
       }


    }

    function update_depense(Request $request, $id)
    {
        // $resteLettre = $this->chiffreEnLettre($request->montant);
        $datetest='';
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateCloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateCloture)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {
            $taux=0;
            $taux = DB::table("tvente_taux")
            ->select("tvente_taux.id", "tvente_taux.taux", 
            "tvente_taux.created_at", "tvente_taux.author")
            ->get();
    
            foreach ($taux as $tau) {
                $taux= $tau->taux;
            }
    
   
            $data = tDepense::where('id', $id)->update([
                'montant'       =>  $request->montant,
                'montantLettre'    =>  $request->montantLettre,
                'motif'    =>  $request->motif,
                'dateOperation'    =>  $request->dateOperation,
                'refMvt'    =>  $request->refMvt,
                'refCompte'    =>  $request->refCompte,
                'modepaie'    =>  $request->modepaie,
                'refBanque'    =>  $request->refBanque,
                'numeroBordereau'    =>  $request->numeroBordereau,
                'taux_dujour'    =>  $taux,
                'numeroBE'    =>  $request->numeroBE,
                'author'       =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);
       }

    }

    function delete_depense($id)
    {
        $data = tDepense::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }


    function fetch_compte_entree()
    {

        $data = DB::table('tcompte')->select("tcompte.id","tcompte.designation","tcompte.refMvt")
        ->where('tcompte.refMvt', '1')
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_compte_sortie()
    {

        $data = DB::table('tcompte')->select("tcompte.id","tcompte.designation","tcompte.refMvt")
        ->where('tcompte.refMvt', '2')
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function aquitter_depense(Request $request, $id)
    {
        $data = tDepense::where('id', $id)->update([
            'DateAcquitterPar' =>  date('Y-m-d'),
            'StatutAcquitterPar' =>  'OUI',
            'AcquitterPar' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function approuver_depense(Request $request, $id)
    {
        $data = tDepense::where('id', $id)->update([
            'DateApproCoordi' =>  date('Y-m-d'),
            'StatutApproCoordi' =>  'OUI',
            'ApproCoordi' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function cloturer_Caisse_vente(Request $request,$refCompte,$taux)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);

            
       }
       else
       {  
            $TotalPaie=0;
            $date_paie='';
            $refBanque=0;
            $modepaie='';
                        
            $data2 = DB::table('tvente_paiement')
            ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
            ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    
            ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->select('date_paie','refBanque','modepaie')
            ->selectRaw('IFNULL(ROUND(SUM(montant_paie),3),0) as TotalPaie')
            ->where([
                ['date_paie','=', $request->date_cloture]
            ])
            ->groupby('date_paie','refBanque','modepaie')    
            ->get();
            
            foreach ($data2 as $row2) 
            { 

                // $idCompte = DB::table("tcompte")
                // ->where([['designation','=', 'VENTES RESTO&BAR']])->pluck('id')->first();                                      
                $TotalPaie=$row2->TotalPaie;
                $date_paie=$row2->date_paie;
                $refBanque=$row2->refBanque;  
                $modepaie=$row2->modepaie;
                        
                $data3 = tDepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'VENTES RESTO&BAR',
                    'dateOperation'    => $date_paie,
                    'refMvt'    =>  1,
                    'refCompte'    =>  $refCompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $taux,
                    'author'       =>  $request->author
                ]);

            }
            return response()->json([
                'data'  =>  "La Caisse a été clauturer avec succès!!!",
            ]); 
       }



    }

    function cloturer_Caisse_hotel(Request $request, $refCompte,$taux)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                $sommation=0;

                $data6 = DB::table('thotel_paiement_chambre')
                ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','thotel_paiement_chambre.refReservation')
                ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
                ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
                ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
                ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        
                ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_chambre.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
                
                ->selectRaw('IFNULL(ROUND(SUM(montant_paie),3),0) as TotalPaie')
                ->where([
                    ['date_paie','=', $request->date_cloture]
                ])                  
                ->get();    
    
                
                foreach ($data6 as $row) 
                { 
                  $sommation = $row->TotalPaie;
                }
    
            $TotalPaie=0;
            $date_paie='';
            $refBanque=0;
            $modepaie='';

            
            $data2 = DB::table('thotel_paiement_chambre')
            ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','thotel_paiement_chambre.refReservation')
            ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refClient')
            ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
            ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    
            ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_chambre.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
            
            ->select('date_paie','refBanque','modepaie')
            ->selectRaw('IFNULL(ROUND(SUM(montant_paie),3),0) as TotalPaie')
            ->where([
                ['date_paie','=', $request->date_cloture]
            ])
            ->groupby('date_paie','refBanque','modepaie')    
            ->get();
            
            foreach ($data2 as $row) 
            { 
                                                    
                $TotalPaie=$row->TotalPaie;
                $date_paie=$row->date_paie;
                $refBanque=$row->refBanque;  
                $modepaie=$row->modepaie;
                        
                $data4 = tDepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'RESERVATIONS CHAMBRE',
                    'dateOperation'    => $date_paie,
                    'refMvt'    =>  1,
                    'refCompte'    =>  $refCompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $taux,
                    'author'       =>  $request->author
                ]);
            }



      }

    }

    function cloturer_Caisse_salle(Request $request,$refCompte,$taux)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                $sommation=0;

                $data6 = DB::table('thotel_paiement_salle')
                ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_paiement_salle.refReservation')
                ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
                ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
                ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        
                ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_salle.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
                
                ->selectRaw('ROUND(SUM(montant_paie),3) as TotalPaie')
                ->where([
                    ['date_paie','=', $request->date_cloture]
                ])                  
                ->get();    
    
                
                foreach ($data6 as $row) 
                { 
                  $sommation = $row->TotalPaie;
                }
    
            $TotalPaie=0;
            $date_paie='';
            $refBanque=0;
            $modepaie='';

            
            $data2 = DB::table('thotel_paiement_salle')
            ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_paiement_salle.refReservation')
            ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
            ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    
            ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_salle.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->select('date_paie','refBanque','modepaie')
            ->selectRaw('ROUND(SUM(montant_paie),0) as TotalPaie')
            ->where([
                ['date_paie','=', $request->date_cloture]
            ])
            ->groupby('date_paie','refBanque','modepaie')    
            ->get();
            
            foreach ($data2 as $row) 
            { 
                                                    
                $TotalPaie=$row->TotalPaie;
                $date_paie=$row->date_paie;
                $refBanque=$row->refBanque;  
                $modepaie=$row->modepaie;
                        
                $data4 = tDepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'RESERVATIONS SALLE',
                    'dateOperation'    => $date_paie,
                    'refMvt'    =>  1,
                    'refCompte'    =>  $refCompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $taux,
                    'author'       =>  $request->author
                ]);
            }
      }



    }

    function cloturer_Caisse_billard(Request $request,$refCompte,$taux)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                
                $sommation=0;

                $data6 = DB::table('thotel_billard')
                ->join('tvente_client','tvente_client.id','=','thotel_billard.refClient')
                ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        
                ->join('tconf_banque' , 'tconf_banque.id','=','thotel_billard.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
                
                ->selectRaw('ROUND(SUM(montant_paie),3) as TotalPaie')
                ->where([
                    ['date_paie','=', $request->date_cloture]
                ])                  
                ->get();    
    
                
                foreach ($data6 as $row) 
                { 
                  $sommation = $row->TotalPaie;
                }
    
            $TotalPaie=0;
            $date_paie='';
            $refBanque=0;
            $modepaie='';

            
            $data2 = DB::table('thotel_billard')
            ->join('tvente_client','tvente_client.id','=','thotel_billard.refClient')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    
            ->join('tconf_banque' , 'tconf_banque.id','=','thotel_billard.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
            
            ->select('date_paie','refBanque','modepaie')
            ->selectRaw('ROUND(SUM(montant_paie),0) as TotalPaie')
            ->where([
                ['date_paie','=', $request->date_cloture]
            ])
            ->groupby('date_paie','refBanque','modepaie')    
            ->get();
            
            foreach ($data2 as $row) 
            { 
                                                    
                $TotalPaie=$row->TotalPaie;
                $date_paie=$row->date_paie;
                $refBanque=$row->refBanque;  
                $modepaie=$row->modepaie;
                        
                $data4 = tDepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'RESERVATIONS SALLE',
                    'dateOperation'    => $date_paie,
                    'refMvt'    =>  1,
                    'refCompte'    => $refCompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $taux,
                    'author'       =>  $request->author
                ]);
            }

       }



    }

    function cloturer_Caisse_fournisseur(Request $request,$refCompte,$taux)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);

            
       }
       else
       {  
            $TotalPaie=0;
            $date_paie='';
            $refBanque=0;
            $modepaie='';
                        
            $data4 = DB::table('tvente_paiement_commande')
            ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_paiement_commande.refCommande')
            ->join('tvente_entete_paiecommande','tvente_entete_paiecommande.id','=','tvente_paiement_commande.refEntetepaie')
            ->join('tvente_module','tvente_module.id','=','tvente_entete_requisition.module_id')
            ->join('tvente_services','tvente_services.id','=','tvente_entete_requisition.refService')
            ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
            ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
            ->join('tfin_ssouscompte as comptefss','comptefss.id','=','tvente_categorie_fournisseur.compte_fss_bl')
            ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement_commande.refBanque')
            ->join('tfin_ssouscompte as compteBanque','compteBanque.id','=','tconf_banque.refSscompte')
            
            ->select('date_paie','refBanque','modepaie')
            ->selectRaw('IFNULL(ROUND(SUM(montant_paie),3),0) as TotalPaie')
            ->where([
                ['date_paie','=', $request->date_cloture]
            ])
            ->groupby('date_paie','refBanque','modepaie')    
            ->get();
            
            foreach ($data4 as $row4) 
            { 
                // $idCompte = DB::table("tcompte")
                // ->where([['designation','=', 'PAIEMENT DES FROUNISSEURS']])->pluck('id')->first();                                    
                $TotalPaie=$row4->TotalPaie;
                $date_paie=$row4->date_paie;
                $refBanque=$row4->refBanque;  
                $modepaie=$row4->modepaie;
                        
                $data5 = tDepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'PAIEMENT DES FROUNISSEURS',
                    'dateOperation'    => $date_paie,
                    'refMvt'    =>  2,
                    'refCompte'    =>  $refCompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $taux,
                    'author'       =>  $request->author
                ]);

            }




            return response()->json([
                'data'  =>  "La Caisse a été clauturer avec succès!!!",
            ]); 
       }



    }

    // function cloturer_Caisse_vente_gaz(Request $request,$refCompte,$taux)
    // {
    //     $datetest='';
    //     $data3 = DB::table('tfin_cloture_caisse')
    //    ->select('date_cloture')
    //    ->where('date_cloture','=', $request->date_cloture)
    //    ->take(1)
    //    ->orderBy('id', 'desc')         
    //    ->get();    
    //    foreach ($data3 as $row) 
    //    {                           
    //       $datetest=$row->date_cloture;          
    //    }

    //    if($datetest == $request->date_cloture)
    //    {
    //         return response()->json([
    //             'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
    //         ]);

            
    //    }
    //    else
    //    {  
    //         $TotalPaie=0;
    //         $date_paie='';
    //         $refBanque=0;
    //         $modepaie='';
                        
    //         $data2 = DB::table('tvente_paiement')
    //         ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
    //         ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
    //         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    
    //         ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
    //         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    //         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    //         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    //         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    //         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    //         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
    //         ->select('date_paie','refBanque','modepaie')
    //         ->selectRaw('IFNULL(ROUND(SUM(montant_paie),3),0) as TotalPaie')
    //         ->where([
    //             ['date_paie','=', $request->date_cloture]
    //         ])
    //         ->groupby('date_paie','refBanque','modepaie')    
    //         ->get();
            
    //         foreach ($data2 as $row2) 
    //         { 

    //             // $idCompte = DB::table("tcompte")
    //             // ->where([['designation','=', 'VENTES RESTO&BAR']])->pluck('id')->first();                                      
    //             $TotalPaie=$row2->TotalPaie;
    //             $date_paie=$row2->date_paie;
    //             $refBanque=$row2->refBanque;  
    //             $modepaie=$row2->modepaie;
                        
    //             $data3 = tDepense::create([
    //                 'montant'       =>  $TotalPaie,
    //                 'montantLettre'    =>  'USD',
    //                 'motif'    =>  'VENTES RESTO&BAR',
    //                 'dateOperation'    => $date_paie,
    //                 'refMvt'    =>  1,
    //                 'refCompte'    =>  $refCompte,
    //                 'modepaie'    =>  $modepaie,
    //                 'refBanque'    =>  $refBanque,
    //                 'numeroBordereau'    =>  '00000000',
    //                 'taux_dujour'    =>  $taux,
    //                 'author'       =>  $request->author
    //             ]);

    //         }

    //         return response()->json([
    //             'data'  =>  "La Caisse a été clauturer avec succès!!!",
    //         ]); 
    //    }



    // }
    // mes scripts

    function cloturer_Caisse(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);

            
       }
       else
       {    
                $taux=0; 
                $taux = DB::table('tvente_taux')->get();

                foreach ($taux as $tau) {
                $taux= $tau->taux;
                }

                $this->cloturer_Caisse_vente($request,1,$taux);
                $this->cloturer_Caisse_fournisseur($request,2,$taux);
                // $this->cloturer_Caisse_hotel($request,2,$taux);        
                // $this->cloturer_Caisse_salle($request,3,$taux);                
                
                // $this->cloturer_Caisse_billard($request,5,$taux);
                
        
                $data5 = tfin_cloture_caisse::create([
                        'refSscompte'       =>  0,
                        'date_cloture'    =>  $request->date_cloture,
                        'montant_cloture' =>   0,
                        'taux_dujour'    => $taux,            
                        'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "La Caisse est cloturée pour cette date avec succès!!!",
            ]);

       }



    }
    // fin de mes scripts
  
    function cloturer_Comptabilite(Request $request)
    {
        $datetest='';
        $taux=0;
        $author= $request->author;
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateCloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateCloture)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                $data6 = DB::table('tdepense')
                ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
                ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
                ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
        
                ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
                "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','tdepense.refBanque','numeroBordereau',
                'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
                ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
                "tconf_banque.refSscompte as refSscompteBanque","tcompte.refSscompte as refSscompteLibelle",
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
                "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
                "tdepense.created_at","tdepense.updated_at","numeroBE")
                ->where('dateOperation','=', $request->dateCloture)                  
                ->get(); 
                foreach ($data6 as $row6) 
                { 
                    $taux=$row6->taux_dujour;
                    //refBanque

                    $data = tfin_entete_operationcompte::create([
                        'libelleOperation'       =>   $row6->Compte,
                        'dateOpration'       =>  $row6->dateOperation,
                        'numOpereation'    =>  $row6->id,
                        'refTresorerie'    =>  $row6->refBanque,
                        'tauxdujour'    =>  $row6->taux_dujour,
                        'author'    =>  $row6->author   
                    ]);

                    $idmax_entete=0;
                    $maxid_entete = DB::table('tfin_entete_operationcompte')        
                    ->selectRaw('MAX(tfin_entete_operationcompte.id) as code_entete')
                    ->where([
                        ['tfin_entete_operationcompte.numOpereation',$row6->id]
                    ])
                    ->get();
                    foreach ($maxid_entete as $list_entete) {
                        $idmax_entete= $list_entete->code_entete;
                    }


                    if($row6->refMvt == 2)
                    {
                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteLibelle,
                            'typeOperation'       =>  'DEBIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteBanque,
                            'typeOperation'       =>  'CREDIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                    }
                    if($row6->refMvt == 1)
                    {
                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteBanque,
                            'typeOperation'       =>  'DEBIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteLibelle,
                            'typeOperation'       =>  'CREDIT',
                            'montantOpration'       =>  $row6->montant
                        ]);
                    }                  
                }
    
                $data = tfin_cloture_comptabilite::create([
                    'dateCloture' =>  $request->dateCloture,
                    'tauxdujour' =>  $taux,
                    'numerOperation' => 0,
                    'author' =>  $author
                ]);
            return response()->json([
                    'data'  =>  "La COmptabilité est cloturée pour cette date avec succès!!!",
            ]);

       }



    }













    

}
