<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_fiche_paie;
use App\Models\Personnel\tperso_entete_paiement;
use App\Models\Personnel\tperso_detail_paiement_sal;
use DB;
//tperso_entete_paiement
//tperso_detail_paiement_sal

class tperso_fiche_paieController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
        //,'modepaie','refBanque'
                
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tperso_fiche_paie')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->select("tperso_fiche_paie.id","name_mois","name_annee","dateFiche",
            "tperso_fiche_paie.author","tperso_fiche_paie.created_at","refMois","refAnne",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->where('name_annee', 'like', '%'.$query.'%')
            ->orWhere('name_mois', 'like', '%'.$query.'%')
            ->orderBy("tperso_fiche_paie.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{

            $data = DB::table('tperso_fiche_paie')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->select("tperso_fiche_paie.id","name_mois","name_annee","dateFiche",
            "tperso_fiche_paie.author","tperso_fiche_paie.created_at","refMois","refAnne"  ,'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->orderBy("tperso_fiche_paie.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tperso_fiche_paie')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
        ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->select("tperso_fiche_paie.id","name_mois","name_annee","dateFiche",
        "tperso_fiche_paie.author","tperso_fiche_paie.created_at","refMois","refAnne"  ,'refBanque',
        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte')
        ->where('tperso_fiche_paie.id', $id)
        ->get();

        return response($data, 200);
    }
//
 
    function insert_global_data(Request $request)
    {
        $check=$request->check;       

        $taux=0;
        $tauxList = DB::table('tvente_taux')
        ->select("tvente_taux.id","tvente_taux.taux","tvente_taux.created_at")
        ->get();
        foreach ($tauxList as $listTaux) {
            $taux= $listTaux->taux;
        }

        //,'modepaie','refBanque'

        $data = tperso_fiche_paie::create([
            'dateFiche'       =>  date('Y-m-d'),
            'refMois'       =>  $request->refMois,
            'refAnne'    =>  $request->refAnne,
            'modepaie'    =>  $request->modepaie,
            'refBanque'    =>  $request->refBanque,
            'author'    =>  $request->author  
        ]);

        $idmax=0;
        $maxid = DB::table('tperso_fiche_paie')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')        
        ->selectRaw('MAX(tperso_fiche_paie.id) as code_fiche')
        ->where([
            ['tperso_fiche_paie.refAnne',$request->refAnne],
            ['tperso_fiche_paie.refMois',$request->refMois]
        ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_fiche;
        }

        if($check == 'TOUS')
        {
            $refAffectation=0;

            $data2 = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id")               
            ->orderBy("tperso_affectation_agent.id", "asc")          
            ->get();
            foreach ($data2 as $list) {
                    $refAffectation= $list->id;



                    $data = tperso_entete_paiement::create([
                        'refAffectation'       =>  $refAffectation,
                        'refFichePaie'    =>  $idmax,
                        'author'    =>  $request->author
                    ]);

                    //tperso_categorie_service
                    $idmax_entetepaie=0;
                    $maxid_entetepaie = DB::table('tperso_entete_paiement')     
                    ->selectRaw('MAX(tperso_entete_paiement.id) as code_entetepaie')
                    ->where([
                        ['tperso_entete_paiement.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($maxid_entetepaie as $list_entetepaie) {
                        $idmax_entetepaie= $list_entetepaie->code_entetepaie;
                    }



                    $idDetailAffect=0;
                    $detail_list = DB::table('tperso_detail_affectation_ribrique')
                    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
                    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
                    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
                    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
                    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
                    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                    ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
                    ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                    ->join('communes' , 'communes.id','=','quartiers.idCommune')
                    ->join('villes' , 'villes.id','=','communes.idVille')
                    ->join('provinces' , 'provinces.id','=','villes.idProvince')
                    ->join('pays' , 'pays.id','=','provinces.idPays')
                    ->select("tperso_detail_affectation_ribrique.id")
                    ->where([
                        ['tperso_detail_affectation_ribrique.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($detail_list as $list_det) {
                        $idDetailAffect= $list_det->id;

                        $data = tperso_detail_paiement_sal::create([
                            'refEntetePaie'       =>  $idmax_entetepaie,
                            'refDetailAffectRibrique'    =>  $idDetailAffect,
                            'taux'    =>  $taux,
                            'author'  =>  $request->author
                        ]);
                    }
            }

        }
        else if($check == 'PAR SERVICE')
        {
            $refServicePerso=$request->refServicePerso;
            $refAffectation=0;

            $data2 = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id")               
            ->where([
                ['tperso_affectation_agent.refServicePerso',$refServicePerso]
            ])         
            ->get();
            foreach ($data2 as $list) {
                    $refAffectation= $list->id;



                    $data = tperso_entete_paiement::create([
                        'refAffectation'       =>  $refAffectation,
                        'refFichePaie'    =>  $idmax,
                        'author'    =>  $request->author
                    ]);


                    $idmax_entetepaie=0;
                    $maxid_entetepaie = DB::table('tperso_entete_paiement')        
                    ->selectRaw('MAX(tperso_entete_paiement.id) as code_entetepaie')
                    ->where([
                        ['tperso_entete_paiement.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($maxid_entetepaie as $list_entetepaie) {
                        $idmax_entetepaie= $list_entetepaie->code_entetepaie;
                    }



                    $idDetailAffect=0;
                    $detail_list = DB::table('tperso_detail_affectation_ribrique')
                    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
                    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
                    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
                    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
                    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
                    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                    ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
                    ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                    ->join('communes' , 'communes.id','=','quartiers.idCommune')
                    ->join('villes' , 'villes.id','=','communes.idVille')
                    ->join('provinces' , 'provinces.id','=','villes.idProvince')
                    ->join('pays' , 'pays.id','=','provinces.idPays')
                    ->select("tperso_detail_affectation_ribrique.id")
                    ->where([
                        ['tperso_detail_affectation_ribrique.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($detail_list as $list_det) {
                        $idDetailAffect= $list_det->id;

                        $data = tperso_detail_paiement_sal::create([
                            'refEntetePaie'       =>  $idmax_entetepaie,
                            'refDetailAffectRibrique'    =>  $idDetailAffect,
                            'taux'    =>  $taux,
                            'author'  =>  $request->author
                        ]);
                    }
            }

        }
        else if($check == 'PAR COORDINATION')
        {
            $refCatService=$request->refCatService;
            $refAffectation=0;

            $data2 = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id")               
            ->where([
                ['tperso_service_personnel.refCatService',$refCatService]
            ])         
            ->get();
            foreach ($data2 as $list) {
                    $refAffectation= $list->id;



                    $data = tperso_entete_paiement::create([
                        'refAffectation'       =>  $refAffectation,
                        'refFichePaie'    =>  $idmax,
                        'author'    =>  $request->author
                    ]);


                    $idmax_entetepaie=0;
                    $maxid_entetepaie = DB::table('tperso_entete_paiement')
                    ->selectRaw('MAX(tperso_entete_paiement.id) as code_entetepaie')
                    ->where([
                        ['tperso_entete_paiement.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($maxid_entetepaie as $list_entetepaie) {
                        $idmax_entetepaie= $list_entetepaie->code_entetepaie;
                    }



                    $idDetailAffect=0;
                    $detail_list = DB::table('tperso_detail_affectation_ribrique')
                    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
                    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
                    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
                    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
                    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
                    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                    ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
                    ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                    ->join('communes' , 'communes.id','=','quartiers.idCommune')
                    ->join('villes' , 'villes.id','=','communes.idVille')
                    ->join('provinces' , 'provinces.id','=','villes.idProvince')
                    ->join('pays' , 'pays.id','=','provinces.idPays')
                    ->select("tperso_detail_affectation_ribrique.id")
                    ->where([
                        ['tperso_detail_affectation_ribrique.refAffectation',$refAffectation]
                    ])
                    ->get();
                    foreach ($detail_list as $list_det) {
                        $idDetailAffect= $list_det->id;

                        $data = tperso_detail_paiement_sal::create([
                            'refEntetePaie'       =>  $idmax_entetepaie,
                            'refDetailAffectRibrique'    =>  $idDetailAffect,
                            'taux'    =>  $taux,
                            'author'  =>  $request->author
                        ]);
                    }
            }

        }


        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    //id,refMois,refAnne,author

    function insert_data(Request $request)
    {
        $data = tperso_fiche_paie::create([
            'dateFiche'       =>  date('Y-m-d'),
            'refMois'       =>  $request->refMois,
            'refAnne'    =>  $request->refAnne,
            'modepaie'    =>  $request->modepaie,
            'refBanque'    =>  $request->refBanque,
            'author'    =>  $request->author   
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }



    function updateData(Request $request, $id)
    {
        $data = tperso_fiche_paie::where('id', $id)->update([
            'refMois'       =>  $request->refMois,
            'refAnne'    =>  $request->refAnne,
            'modepaie'    =>  $request->modepaie,
            'refBanque'    =>  $request->refBanque,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     //
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
     //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
    $data2 = tperso_detail_paie_salaire::where('refFichePaie',$id)->delete(); 
    $data = tperso_fiche_paie::where('id', $id)->delete();     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
