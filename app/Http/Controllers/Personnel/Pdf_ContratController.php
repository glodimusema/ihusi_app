<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class Pdf_ContratController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


//==================== RAPPORT DES PAIEMENTS PAR DATE =======================================

public function fetch_rapport_contrat_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportContratDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDate($date1, $date2); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>        
        ';  
       
        return $output; 

}

function showRapportContratDate($date1, $date2)
{
        $count=0;

        $data = DB::table('tperso_affectation_agent')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['dateAffectation','>=', $date1],
            ['dateAffectation','<=', $date2]
        ])
        ->orderBy("tperso_affectation_agent.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                    <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                    <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                    <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                    <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
                </tr>
            ';  
    }

    return $output;

}


//==================== RAPPORT DES PAIEMENTS PAR DATE =======================================

public function fetch_rapport_fincontrat_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportFinContratDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportFinContratDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportFinContratDate($date1, $date2); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>        
        ';  
       
        return $output; 

}

function showRapportFinContratDate($date1, $date2)
{
        $count=0;

        $data = DB::table('tperso_affectation_agent')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['dateFin','>=', $date1],
            ['dateFin','<=', $date2]
        ])
        ->orderBy("tperso_affectation_agent.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                    <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                    <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                    <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                    <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
                </tr>
            ';  
    }

    return $output;

}

//

//==================== RAPPORT DES CONTRAT PAR DATE TYPE CONTRAT =======================================

public function fetch_rapport_contrat_date_typecontrat(Request $request)
{
    //refDepartement  refBanque

    if ($request->get('date1') && $request->get('date2') && $request->get('refTypeContrat')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refTypeContrat = $request->get('refTypeContrat');
        
        $html = $this->printRapportContratDateTypeContrat($date1, $date2, $refTypeContrat);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateTypeContrat($date1, $date2, $refTypeContrat)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateTypeContrat($date1, $date2, $refTypeContrat); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateTypeContrat($date1, $date2, $refTypeContrat)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['refTypeContrat','=', $refTypeContrat]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}




//==================== RAPPORT DES CONTRAT PAR DATE POSTE =======================================

public function fetch_rapport_contrat_date_poste(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('refPoste')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refPoste = $request->get('refPoste');
        
        $html = $this->printRapportContratDatePoste($date1, $date2, $refPoste);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDatePoste($date1, $date2, $refPoste)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDatePoste($date1, $date2, $refPoste); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDatePoste($date1, $date2, $refPoste)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['refPoste','=', $refPoste]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}



//==================== RAPPORT DES CONTRAT PAR DATE LIEU AFFECTATION =======================================

public function fetch_rapport_contrat_date_LieuAffectation(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('refLieuAffectation')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refLieuAffectation = $request->get('refLieuAffectation');
        
        $html = $this->printRapportContratDateLieuAffectation($date1, $date2, $refLieuAffectation);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateLieuAffectation($date1, $date2, $refLieuAffectation)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateLieuAffectation($date1, $date2, $refLieuAffectation); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateLieuAffectation($date1, $date2, $refLieuAffectation)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['refLieuAffectation','=', $refLieuAffectation]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}



//==================== RAPPORT DES CONTRAT PAR DATE MUTUELLE =======================================

public function fetch_rapport_contrat_date_mutuelle(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('refMutuelle')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refMutuelle = $request->get('refMutuelle');
        
        $html = $this->printRapportContratDateMutuelle($date1, $date2, $refMutuelle);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateMutuelle($date1, $date2, $refMutuelle)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateMutuelle($date1, $date2, $refMutuelle); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateMutuelle($date1, $date2, $refMutuelle)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['refMutuelle','=', $refMutuelle]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}


//==================== RAPPORT DES CONTRAT PAR DATE PROJET =======================================

public function fetch_rapport_contrat_date_projet(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('projet_id')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $projet_id = $request->get('projet_id');
        
        $html = $this->printRapportContratDateProjet($date1, $date2, $projet_id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateProjet($date1, $date2, $projet_id)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateProjet($date1, $date2, $projet_id); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateProjet($date1, $date2, $projet_id)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
    ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
    ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat','conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
    'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
    'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice','fammiliale','logement',
    'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
    'inss_qpo','inss_qpp','cnss','inpp','onem','ipr',"salaire_base")
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
    ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
    ->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['tperso_parametre_salairebase.projet_id','=', $projet_id]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}


//==================== RAPPORT DES CONTRAT PAR DATE SEXE =======================================

public function fetch_rapport_contrat_date_sexe(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('sexe_agent')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $sexe_agent = $request->get('sexe_agent');
        
        $html = $this->printRapportContratDateSexe($date1, $date2, $sexe_agent);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateSexe($date1, $date2, $sexe_agent)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateSexe($date1, $date2, $sexe_agent); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateSexe($date1, $date2, $sexe_agent)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
    ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
    ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat','conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
    'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
    'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice','fammiliale','logement',
    'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
    'inss_qpo','inss_qpp','cnss','inpp','onem','ipr',"salaire_base")
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
    ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
    ->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['sexe_agent','=', $sexe_agent]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}


//==================== RAPPORT DES CONGE PAR DATE MUTUELLE =======================================

public function fetch_rapport_contrat_date_conge(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('conge')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $conge = $request->get('conge');
        
        $html = $this->printRapportContratDateConge($date1, $date2, $conge);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    }  
    
}

function printRapportContratDateConge($date1, $date2, $conge)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
            $nomEse=$row->nomEntreprise;
            $adresseEse=$row->adresseEntreprise;
            $Tel1Ese=$row->telephoneEntreprise;
            $Tel2Ese=$row->telephone;
            $siteEse=$row->siteweb;
            $emailEse=$row->emailEntreprise;
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $rccmEse=$row->rccm;
            $bp=$row->edition;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
         }
 


        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportContrat</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:52px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:623px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:623px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact :'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:623px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" rowspan="2" style="width:623px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONTRATS&nbsp;ENCOURS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="5" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:92px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>MUTUELLE</nobr></td>
                        <td class="cs479D8C74" style="width:90px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEBUT&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:78px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>FIN&nbsp;CONT.</nobr></td>
                        <td class="cs479D8C74" style="width:79px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONTRAT</nobr></td>
                        <td class="cs479D8C74" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CONGE</nobr></td>
                    </tr>
                    ';
                                                                
                                    $output .= $this->showRapportContratDateConge($date1, $date2, $conge); 
                                                                
                                    $output.='
                </table>
                </body>
                </html>  
        
        ';  
       
        return $output; 

}

function showRapportContratDateConge($date1, $date2, $conge)
{
    $count=0;

    $data = DB::table('tperso_affectation_agent')
    ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
    ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
    ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
    ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent",
    "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
    "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
    "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
    'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
    'nom_contrat','code_contrat')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
    ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
    ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
    ->where([
        ['dateAffectation','>=', $date1],
        ['dateAffectation','<=', $date2],
        ['conge','=', $conge]
    ])
    ->orderBy("tperso_affectation_agent.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                <td class="csD06EB5B2" colspan="2" style="width:92px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_mutuelle.'</nobr></td>
                <td class="csD06EB5B2" style="width:90px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateAffectation.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateFin.'</nobr></td>
                <td class="csD06EB5B2" style="width:79px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->Statut.'</nobr></td>
                <td class="csD06EB5B2" style="width:51px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->conge.'</nobr></td>
            </tr>
        ';  
    }

    return $output;
}



//==================== RAPPORT DES CONGES =======================================

public function fetch_rapport_conge_encours_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportCongeEncoursDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportCongeEncoursDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportConge</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:282px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:101px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:145px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="7" style="width:144px;height:138px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:138px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:138px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="12" style="width:621px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" rowspan="7" style="width:145px;height:138px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:138px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:138px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:621px;height:21px;line-height:18px;text-align:center;vertical-align:middle;">Adresse:'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:621px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="12" style="width:621px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:621px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="12" style="width:621px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP'.$bp.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="10" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;CONGES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csBB9284F7" colspan="5" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:95px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CONTRAT</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:124px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>POSTE</nobr></td>
                        <td class="cs479D8C74" style="width:113px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:121px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CIRCONSTANCE</nobr></td>
                        <td class="cs479D8C74" style="width:58px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DEPART</nobr></td>
                        <td class="cs479D8C74" colspan="3" style="width:57px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>REPRISE</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:145px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>INTERIMAIRE</nobr></td>
                    </tr>
                ';
                                                                
                    $output .= $this->showRapportCongetEncoursDate($date1, $date2); 
                                                                
                    $output.='
                </table>
                </body>
                </html>
    
        ';  
       
        return $output; 

}

function showRapportCongetEncoursDate($date1, $date2)
{
        $count=0;

        $data = DB::table('tperso_demandeconge')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
        ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_demandeconge.id",'affectation_id','typecircintance_id','description_conge',
        'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
        'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
        'congess','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation','refMutuelle',
        'refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_demandeconge.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
        "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
        'description_mutuelle','nom_contrat','code_contrat')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')    
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), dateFin))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['date_depart','>=', $date1],
            ['date_depart','<=', $date2]
        ])
        ->orderBy("tperso_demandeconge.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:95px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->code_contrat.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:124px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_poste.'</nobr></td>
                    <td class="csD06EB5B2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->nom_lieu.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:121px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->nom_circontstance.'</td>
                    <td class="csD06EB5B2" style="width:58px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_depart.'</td>
                    <td class="csD06EB5B2" colspan="3" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_reprise.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:145px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->interimaire_conge.'</td>
                </tr>
            '; 
    }

    return $output;

}

//==================== RAPPORT DES STAGIAIRES =======================================

public function fetch_rapport_stagiaires_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportStagiairessDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportStagiairessDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportStageaire</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:282px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:101px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:35px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:75px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:114px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:65px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:626px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse:'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;STAGEAIRES</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="4" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:151px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;STAGE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:147px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>INSCTITUTION</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:150px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PROMOTION</nobr></td>
                    <td class="cs479D8C74" style="width:64px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>ANNEE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:82px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;DEBUT</nobr></td>
                    <td class="cs479D8C74" style="width:62px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FIN</nobr></td>
                    <td class="cs479D8C74" style="width:57px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>STATUT</nobr></td>
                </tr>
                ';
                                                                            
                                    $output .= $this->showRapportStagiairesDate($date1, $date2); 
                                                                            
                                    $output.='
            </table>
            </body>
            </html>
    
        ';  
       
        return $output; 

}

function showRapportStagiairesDate($date1, $date2)
{
        $count=0;
 
        $data = DB::table('tperso_stages')
        ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
        ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
        ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
        ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
        ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
        "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), date_fin_stage))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['date_debut_stage','>=', $date1],
            ['date_debut_stage','<=', $date2]
        ])
        ->orderBy("tperso_stages.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:151px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_typestage.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_institution.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:150px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->name_promotion.'&nbsp;'.$row->name_option.'</nobr></td>
                <td class="csD06EB5B2" style="width:64px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_annee.'</td>
                <td class="csD06EB5B2" colspan="4" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_debut_stage.'</td>
                <td class="csD06EB5B2" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_fin_stage.'</td>
                <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->Statut.'</td>
            </tr>
            ';
    }

    return $output;

}


//==================== RAPPORT DES STAGIAIRES INSTITUTION =======================================

public function fetch_rapport_stagiaires_date_institution(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2') && $request->get('institution_id')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $institution_id = $request->get('institution_id');
        
        $html = $this->printRapportStagiairessDateInstitution($date1, $date2,$institution_id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportStagiairessDateInstitution($date1, $date2,$institution_id)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportStageaire</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:282px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:101px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:35px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:75px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:114px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:65px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:626px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse:'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;STAGEAIRES</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="4" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:151px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;STAGE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:147px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>INSCTITUTION</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:150px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PROMOTION</nobr></td>
                    <td class="cs479D8C74" style="width:64px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>ANNEE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:82px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;DEBUT</nobr></td>
                    <td class="cs479D8C74" style="width:62px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FIN</nobr></td>
                    <td class="cs479D8C74" style="width:57px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>STATUT</nobr></td>
                </tr>
                ';
                                                                            
                                    $output .= $this->showRapportStagiairesDateInstitution($date1, $date2,$institution_id); 
                                                                            
                                    $output.='
            </table>
            </body>
            </html>
    
        ';  
       
        return $output; 

}

function showRapportStagiairesDateInstitution($date1, $date2,$institution_id)
{
        $count=0;

        $data = DB::table('tperso_stages')
        ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
        ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
        ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
        ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
        ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
        "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante') 
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), date_fin_stage))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['date_debut_stage','>=', $date1],
            ['date_debut_stage','<=', $date2],
            ['institution_id','=', $institution_id]
        ])
        ->orderBy("tperso_stages.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='

            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:151px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_typestage.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_institution.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:150px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->name_promotion.'&nbsp;'.$row->name_option.'</nobr></td>
                <td class="csD06EB5B2" style="width:64px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_annee.'</td>
                <td class="csD06EB5B2" colspan="4" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_debut_stage.'</td>
                <td class="csD06EB5B2" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_fin_stage.'</td>
                <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->Statut.'</td>
            </tr>
            
            ';

    }

    return $output;

}

//==================== RAPPORT DES STAGIAIRES TYPE STAGE =======================================

public function fetch_rapport_stagiaires_date_typestage(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2') && $request->get('typestage_id')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $typestage_id = $request->get('typestage_id');
        
        $html = $this->printRapportStagiairessDateTypestage($date1, $date2,$typestage_id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportStagiairessDateTypestage($date1, $date2,$typestage_id)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportStageaire</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:282px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:43px;"></td>
                    <td style="height:0px;width:101px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:35px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:75px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:114px;"></td>
                    <td style="height:0px;width:37px;"></td>
                    <td style="height:0px;width:65px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:63px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csA67C9637" colspan="11" rowspan="2" style="width:626px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse:'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="11" style="width:626px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="11" style="width:626px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE93F7424" colspan="9" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;STAGEAIRES</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="4" style="width:333px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs91032837" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:187px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:151px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;STAGE</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:147px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>INSCTITUTION</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:150px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PROMOTION</nobr></td>
                    <td class="cs479D8C74" style="width:64px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>ANNEE</nobr></td>
                    <td class="cs479D8C74" colspan="4" style="width:82px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;DEBUT</nobr></td>
                    <td class="cs479D8C74" style="width:62px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FIN</nobr></td>
                    <td class="cs479D8C74" style="width:57px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>STATUT</nobr></td>
                </tr>
                ';
                                                                            
                                    $output .= $this->showRapportStagiairesDateTypestage($date1, $date2,$typestage_id); 
                                                                            
                                    $output.='
            </table>
            </body>
            </html>
    
        ';  
       
        return $output; 

}

function showRapportStagiairesDateTypestage($date1, $date2,$typestage_id)
{
        $count=0;

        $data = DB::table('tperso_stages')
        ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
        ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
        ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
        ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
        ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
        "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante') 
        ->selectRaw("CASE  WHEN (TIMESTAMPDIFF(MONTH, CURDATE(), date_fin_stage))>0 THEN 'Encours' ELSE 'Fini' END as Statut")     
        ->where([
            ['date_debut_stage','>=', $date1],
            ['date_debut_stage','<=', $date2],
            ['typestage_id','=', $typestage_id]
        ])
        ->orderBy("tperso_stages.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='

            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs86F8EF7F" style="width:41px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="csD06EB5B2" colspan="4" style="width:187px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:151px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_typestage.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_institution.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:150px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->name_promotion.'&nbsp;'.$row->name_option.'</nobr></td>
                <td class="csD06EB5B2" style="width:64px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_annee.'</td>
                <td class="csD06EB5B2" colspan="4" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_debut_stage.'</td>
                <td class="csD06EB5B2" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->date_fin_stage.'</td>
                <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->Statut.'</td>
            </tr>
            
            ';

    }

    return $output;

}


//=========== FICHE D'IDENTFICATION AGENT ===================================================================

function pdf_fiche_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetFicheAgent($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function GetFicheAgent($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $bp=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $idAgent=0;
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';

            $urgence="'URGENCE";
            $identi="'IDENTIFICATION";
            $enfant="'ENFANTS";
            $origine="'ORIGINE";
            $etude="'ETUDE";

            //
            $data2 = DB::table('tagent')            
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent","nummaison_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
            'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where('tagent.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;
                $idAgent=$row->id; 
            }  
            
            
            $data3 =  DB::table('tperso_dependant')            
            ->select(DB::raw('ROUND(COUNT(tperso_dependant.id),0) as nombreDep'))
            ->where([
                ['tperso_dependant.refAgent','=', $idAgent]
            ])    
            ->get(); 
            $output='';
            foreach ($data3 as $row3) 
            {                                
                $nbr_dependant=$row3->nombreDep;                          
            }
    
            $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptFicheAgent</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs937FB356 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csEF71EB8E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csAA7EBA13 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE3806B1 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:italic; padding-left:2px;padding-right:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs72AE696A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:619px;height:818px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:124px;"></td>
                        <td style="height:0px;width:38px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="17" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="5" rowspan="6" style="width:132px;height:137px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:132px;height:137px;">
                            <img alt="" src="'.$pic2.'" style="width:132px;height:137px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="13" style="width:469px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:469px;height:21px;line-height:18px;text-align:center;vertical-align:middle;">Adresse:'.$adresseEse.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:469px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:469px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:469px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:469px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:48px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="5" rowspan="3" style="width:132px;height:117px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:132px;height:117px;">
                            <img alt="" src="'.$photo.'" style="width:132px;height:117px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:28px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs72AE696A" colspan="10" style="width:292px;height:28px;line-height:25px;text-align:left;vertical-align:top;"><nobr>FICHE&nbsp;D'.$identi.'</nobr></td>
                        <td class="cs937FB356" style="width:118px;height:26px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>23/05/2024</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:38px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="12" style="width:213px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NOM,&nbsp;POST-NOM&nbsp;&amp;&nbsp;PRENOM&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="6" style="width:354px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="12" style="width:213px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>LIEU&nbsp;ET&nbsp;DATE&nbsp;DE&nbsp;NAISSANCE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="6" style="width:354px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$lieunaissnce_agent.',&nbsp;&nbsp;le&nbsp;'.$datenaissance_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="2" style="width:85px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>ETAT&nbsp;CIVIL&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="16" style="width:482px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$etatcivil_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="12" style="width:213px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NOM&nbsp;DU&nbsp;(DE&nbsp;LA)&nbsp;CONJOINT(E)&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="6" style="width:354px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$conjoint_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="13" style="width:231px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;D'.$enfant.'&nbsp;A&nbsp;CHARGE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="5" style="width:336px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>'.$nbr_dependant.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="4" style="width:115px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NOM&nbsp;DU&nbsp;PERE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="14" style="width:452px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$nomPere_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="5" style="width:130px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NOM&nbsp;DE&nbsp;LA&nbsp;MERE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="13" style="width:437px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$nomMere_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="3" style="width:103px;height:23px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NATIONALITE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="15" style="width:464px;height:23px;line-height:16px;text-align:left;vertical-align:middle;">'.$Nationalite_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="10" style="width:186px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>COLLECTIVITE&nbsp;D'.$origine.'&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="8" style="width:381px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$Collectivite_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="9" style="width:172px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>TERRITOIRE&nbsp;D'.$origine.'&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="9" style="width:395px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$Territoire_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="8" style="width:159px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>PROVINCE&nbsp;D'.$origine.'&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="10" style="width:408px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$provinceOrigine_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="8" style="width:159px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>TITRE(S)&nbsp;SCOLAIRE(S)&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="10" style="width:408px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$niveauEtude_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="14" style="width:290px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>ET&nbsp;OU&nbsp;ACADEMIQUE&nbsp;(S)&nbsp;LE&nbsp;PLUS&nbsp;ELEVE&nbsp;(S)</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="11" style="width:197px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>OPTION/DOMAINE&nbsp;D'.$etude.'&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="7" style="width:370px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$specialite_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="11" style="width:197px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>EMPLOYEURS&nbsp;ANTERIEURS&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="7" style="width:370px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$EmployeurAnt_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="13" style="width:231px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>ADRESSE&nbsp;PHYSIQUE&nbsp;ACTUELLE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="5" style="width:336px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>Ville&nbsp;'.$nomVille.',&nbsp;Com.'.$nomCommune.',&nbsp;Q.'.$nomQuartier.'&nbsp;,&nbsp;Av.'.$nomAvenue.' N° '.$nummaison_agent.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="10" style="width:186px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>NUMERO&nbsp;DE&nbsp;TELEPHONE&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="8" style="width:381px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>'.$contact_agent.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" style="width:69px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>EMAIL&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="17" style="width:498px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>'.$mail_agent.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csAA7EBA13" colspan="15" style="width:336px;height:22px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>PERSONNES&nbsp;A&nbsp;CONTACTER&nbsp;EN&nbsp;CAS&nbsp;D'.$urgence.'&nbsp;:</nobr></td>
                        <td class="csEF71EB8E" colspan="3" style="width:231px;height:22px;line-height:16px;text-align:left;vertical-align:middle;">'.$PersRef_agent.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:37px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE3806B1" colspan="11" style="width:307px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;et&nbsp;Signature&nbsp;du&nbsp;travailleur</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
              
            '; 

    return $output;

}   



//=========== CONTRAT DE PRESTATION AGENT ===================================================================

function pdf_contrat_prestation_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetContratPrestationAgent($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function GetContratPrestationAgent($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
            $bp='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $bp=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nom_poste='';
            $nom_lieu='';
            $description_lieu='';
            $nom_mutuelle='';
            $code_contrat='';
            $directeur='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';
            $dateAffectation='';
            $dureecontrat='';
            $netPaie = 0;

            $urgence="'URGENCE";
            $identi="'IDENTIFICATION";
            $enfant="'ENFANTS";
            $origine="'ORIGINE";
            $etude="'ETUDE";

            //
            $data2 = DB::table('tperso_affectation_agent')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
            'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
            'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr',"salaire_base")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
            ->selectRaw('((salaire_base + fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
            ->where('tperso_affectation_agent.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo_agent.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;
                $directeur=$row->directeur;

                $nom_poste=$row->nom_poste;
                $nom_lieu=$row->nom_lieu;
                $description_lieu=$row->description_lieu;
                $nom_mutuelle=$row->nom_mutuelle;
                $code_contrat=$row->code_contrat;
                $dateAffectation=$row->dateAffectation;
                $dureecontrat=$row->dureecontrat;

                $netPaie = $row->netPaie;

                
            }        
    
            $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptContratPrestations</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs762E62E5 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:22px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs3AF473BB {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csD4852FAF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:633px;height:920px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:244px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:178px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:29px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs762E62E5" colspan="5" style="width:493px;height:27px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>CONVENTION&nbsp;DE&nbsp;PRESTATION&nbsp;DE&nbsp;SERVICES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="3" style="width:260px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>dont&nbsp;le&nbsp;si&#232;ge&nbsp;social&nbsp;est&nbsp;&#233;tabli&nbsp;au&nbsp;n&#176;011,</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="5" style="width:357px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:47px;"></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:622px;height:47px;line-height:17px;text-align:left;vertical-align:top;"><nobr>avenue&nbsp;des&nbsp;&#233;coles,&nbsp;quartier&nbsp;les&nbsp;Volcans,&nbsp;en&nbsp;commune&nbsp;de&nbsp;Goma,&nbsp;repr&#233;sent&#233;e&nbsp;par&nbsp;son&nbsp;Directeur,&nbsp;Monsieur</nobr><br/><nobr> '.$directeur.' (caritas@caritasdegoma.org&nbsp;),&nbsp;d&#233;sign&#233;e&nbsp;&#171;&nbsp;Employeur&nbsp;&#187;&nbsp;;</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:113px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Et&nbsp;d’autre&nbsp;part,</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:112px;"></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:621px;height:112px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:&nbsp;.'.$noms_agent.'.</nobr><br/><nobr>Email&nbsp;:&nbsp;.'.$mail_agent.'.</nobr><br/><nobr>T&#233;l&nbsp;:. '.$contact_agent.' .</nobr><br/><nobr>R&#233;sidante&nbsp;sur&nbsp;avenue. '.$nomAvenue.' .,No. '.$nummaison_agent.' .,</nobr><br/><nobr>Quartier .'.$nomQuartier.'.,&nbsp;Cit&#233;/&nbsp;localit&#233;&nbsp;de .'.$nomCommune.'.,</nobr><br/><nobr>Territoire&nbsp;de . '.$nomVille.' .,&nbsp;Province&nbsp;: .'.$nomProvince.'.</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:36px;"></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="10" style="width:622px;height:36px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Il&nbsp;a&nbsp;&#233;t&#233;&nbsp;convenu&nbsp;et&nbsp;arr&#234;t&#233;&nbsp;ce&nbsp;qui&nbsp;suit&nbsp;:</nobr><br/><nobr>Article&nbsp;1</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:43px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:623px;height:43px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;premier&nbsp;soussign&#233;&nbsp;s’engage&nbsp;&#224;&nbsp;accorder&nbsp;au&nbsp;second&nbsp;soussign&#233;&nbsp;un&nbsp;service&nbsp;limit&#233;&nbsp;conform&#233;ment&nbsp;aux</nobr><br/><nobr>normes&nbsp;et&nbsp;exigences&nbsp;de&nbsp;la&nbsp;Caritas-D&#233;veloppement&nbsp;Goma.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="9" style="width:621px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;2</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:56px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:623px;height:56px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;prestataire&nbsp;des&nbsp;services,&nbsp;qui&nbsp;se&nbsp;d&#233;clare&nbsp;libre&nbsp;de&nbsp;tout&nbsp;engagement,&nbsp;ex&#233;cutera&nbsp;ses</nobr><br/><nobr>taches&nbsp;en&nbsp;qualit&#233;&nbsp;de&nbsp;.'.$nom_poste.'.Sous&nbsp;le&nbsp;contr&#244;le&nbsp;de&nbsp;ses</nobr><br/><nobr>chefs&nbsp;hi&#233;rarchiques.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="10" style="width:623px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;3</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="11" style="width:624px;height:41px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;second&nbsp;soussign&#233;&nbsp;accepte&nbsp;d’accorder&nbsp;ses&nbsp;prestations&nbsp;au&nbsp;premier&nbsp;soussign&#233;&nbsp;sans&nbsp;contrainte&nbsp;ni</nobr><br/><nobr>contestation.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="11" style="width:624px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;4</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:623px;height:42px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Les&nbsp;deux&nbsp;soussign&#233;&nbsp;accepte&nbsp;d’accorder&nbsp;ses&nbsp;prestations&nbsp;au&nbsp;premier&nbsp;soussign&#233;&nbsp;sans&nbsp;contrainte&nbsp;ni</nobr><br/><nobr>contestation.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="10" style="width:623px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;5</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:623px;height:23px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;lieu&nbsp;d’affectation&nbsp;de&nbsp;l’employ&#233;&nbsp;est&nbsp;.'.$nom_lieu.'.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="10" style="width:623px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;6</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="10" style="width:623px;height:23px;line-height:17px;text-align:left;vertical-align:top;"><nobr>La&nbsp;r&#233;mun&#233;ration&nbsp;mensuelle&nbsp;est&nbsp;de.$netPaie.dollars.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="9" style="width:622px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;7</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:622px;height:23px;line-height:17px;text-align:left;vertical-align:top;"><nobr>La&nbsp;Caritas-D&#233;veloppement&nbsp;Goma&nbsp;prendra&nbsp;en&nbsp;charge&nbsp;le&nbsp;transport.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="9" style="width:622px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;8</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:622px;height:23px;line-height:17px;text-align:left;vertical-align:top;"><nobr>La&nbsp;pr&#233;sente&nbsp;convention&nbsp;est&nbsp;conclue&nbsp;pour&nbsp;une&nbsp;dur&#233;e&nbsp;de&nbsp;'.$dureecontrat.'&nbsp;mois&nbsp;&#224;&nbsp;partir&nbsp;du&nbsp;&nbsp;&nbsp;.'.$dateAffectation.'.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="9" style="width:622px;height:19px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;9</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:622px;height:25px;line-height:17px;text-align:left;vertical-align:top;"><nobr>A&nbsp;la&nbsp;fin&nbsp;des&nbsp;prestations,&nbsp;les&nbsp;deux&nbsp;soussign&#233;s&nbsp;d&#233;clarent&nbsp;se&nbsp;s&#233;parer&nbsp;sans&nbsp;aucune&nbsp;indemnit&#233;&nbsp;&#233;quivalente.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3AF473BB" colspan="9" style="width:622px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;10</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:622px;height:22px;line-height:17px;text-align:left;vertical-align:top;"><nobr>La&nbsp;pr&#233;sente&nbsp;convention&nbsp;ne&nbsp;justifie&nbsp;pas&nbsp;un&nbsp;contrat&nbsp;de&nbsp;travail&nbsp;&#233;ventuel.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:68px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csD4852FAF" colspan="9" style="width:622px;height:68px;line-height:17px;text-align:left;vertical-align:top;"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fait&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;……../………/20.....</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employ&#233;e&nbsp;		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directeur</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Lu&nbsp;et&nbsp;approuv&#233;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Lu&nbsp;et&nbsp;approuv&#233;)</nobr><br/></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
              
            '; 

    return $output;

}   



//=========== CONTRAT DE PRESTATION AGENT ===================================================================

function pdf_notificationfin_contrat_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetNotificationFinContrat($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function GetNotificationFinContrat($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
            $bp='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $bp=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            // $id=0;
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nom_poste='';
            $nom_lieu='';
            $description_lieu='';
            $nom_mutuelle='';
            $code_contrat='';
            $directeur='';
            $dateFin='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';
            $dateAffectation='';
            $dureecontrat='';
            $netPaie = 0;
            $description_projet = '';

            $urgence="'URGENCE";
            $identi="'IDENTIFICATION";
            $enfant="'ENFANTS";
            $origine="'ORIGINE";
            $etude="'ETUDE";

            //
            $data2 = DB::table('tperso_affectation_agent')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
            'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
            'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr',"salaire_base",'description_projet')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
            ->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
            ->where('tperso_affectation_agent.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo_agent.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;
                $directeur=$row->directeur;

                $nom_poste=$row->nom_poste;
                $nom_lieu=$row->nom_lieu;
                $description_lieu=$row->description_lieu;
                $nom_mutuelle=$row->nom_mutuelle;
                $code_contrat=$row->code_contrat;
                $dateAffectation=$row->dateAffectation;
                $dureecontrat=$row->dureecontrat;
                $description_projet = $row->description_projet;
                $dateFin=$row->dateFin;

                $netPaie = $row->netPaie;
                $id = $row->id;
                
            }        
    
            $output=' 
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptNotification</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:646px;height:682px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:142px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:244px;"></td>
                        <td style="height:0px;width:237px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="4" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csA67C9637" colspan="2" rowspan="2" style="width:477px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs101A94F7" rowspan="6" style="width:142px;height:136px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:142px;height:136px;">
                            <img alt="" src="'.$pic2.'" style="width:142px;height:136px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="2" style="width:477px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="2" style="width:477px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="2" style="width:477px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="2" style="width:477px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="2" style="width:477px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:118px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="4" style="width:633px;height:118px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N/R&#233;f&nbsp;:.00'.$id.'.&nbsp;/12-ADM/CADEGO/2021&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Goma,&nbsp;le&nbsp;.'.date('Y-m-d').'.</nobr><br/><br/><br/><nobr>		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;Mr(Mme).'.$noms_agent.'.</nobr><br/><nobr>Concerne&nbsp;:&nbsp;Notification&nbsp;pour&nbsp;fin&nbsp;contrat</nobr><br/><br/><nobr>Projet&nbsp;:&nbsp;.'.$description_projet.'.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:214px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="4" style="width:633px;height:214px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Monsieur,</nobr><br/><nobr>	</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Par&nbsp;la&nbsp;pr&#233;sente,&nbsp;nous&nbsp;vous&nbsp;notifions&nbsp;l’arriv&#233;e&nbsp;&#224;</nobr><br/><nobr>terme&nbsp;de&nbsp;votre&nbsp;contrat&nbsp;de&nbsp;travail&nbsp;conjointement&nbsp;sign&#233;&nbsp;le&nbsp;..'.$dateAffectation.'..&nbsp;Qui&nbsp;vous&nbsp;liait&nbsp;&#224;&nbsp;la&nbsp;Caritas-</nobr><br/><nobr>D&#233;veloppement&nbsp;et&nbsp;expire&nbsp;le&nbsp;..'.$dateFin.'..</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conform&#233;ment&nbsp;&#224;&nbsp;l’article&nbsp;69&nbsp;du&nbsp;code&nbsp;du&nbsp;travail</nobr><br/><nobr>congolais,&nbsp;un&nbsp;contrat&nbsp;&#224;&nbsp;dur&#233;e&nbsp;d&#233;termin&#233;e&nbsp;prend&nbsp;fin&nbsp;&#224;&nbsp;l’expiration&nbsp;du&nbsp;terme&nbsp;fix&#233;&nbsp;par&nbsp;les&nbsp;deux</nobr><br/><nobr>parties.&nbsp;L’attestation&nbsp;de&nbsp;service&nbsp;rendu&nbsp;vous&nbsp;sera&nbsp;remise&nbsp;conform&#233;ment&nbsp;aux&nbsp;d&#233;lais&nbsp;fix&#233;s&nbsp;par&nbsp;la&nbsp;loi.</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;En&nbsp;vous&nbsp;souhaitant&nbsp;bonne&nbsp;chance&nbsp;pour&nbsp;l’avenir,</nobr><br/><nobr>nous&nbsp;vous&nbsp;prions&nbsp;d’agr&#233;er,&nbsp;Monsieur,&nbsp;nos&nbsp;salutations&nbsp;les&nbsp;meilleures.</nobr><br/></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:74px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="4" style="width:633px;height:74px;line-height:15px;text-align:left;vertical-align:top;"><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$directeur.'</nobr><br/><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directeur</nobr><br/></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:79px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="4" style="width:633px;height:79px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CI&nbsp;:&nbsp;-&nbsp;Abb&#233;&nbsp;Administrateur&nbsp;g&#233;n&#233;ral</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;Ressources&nbsp;humaines</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;Administration&nbsp;de&nbsp;finances</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;Coordinateur&nbsp;des&nbsp;urgences</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;Coordinateur&nbsp;du&nbsp;BDD</nobr></td>
                    </tr>
                </table>
                </body>
                </html>             
              
            '; 

    return $output;

}
//=========== CHECK LIST ===================================================================
function pdf_checklist_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetCheckList($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();        
    }
    else{

    }
    
    
}

function GetCheckList($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
            $bp='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $bp=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            // $id=0;
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';

            $refAgent=0;
            $checklist = '';
            $motivation = '';
            $cv = '';
            $diplome = '';
            $carteidentite = '';
            $actenaissance = '';
            $actenaissanceenfant = '';
            $aptitudephysique = '';
            $viemoeurs = '';
            $servicerendu = '';
            $ficheidentite = '';
            $contrattravail = '';
            $jobdescription = '';
            $actemariage = '';
            $briefingmission = '';
            $datebriefingmission  = '';
            $organigramme = '';
            $dateorganigramme  = '';
            $briefingposte = '';
            $datebriefingposte = '';
            $planstrategique = '';
            $dateplanstrategique = '';
            $briefinggestion = '';
            $datebriefinggestion = '';
            $mannuel = '';
            $datemannuel = '';
            $evaluationstaff = '';
            $datestaff1 = '';
            $datestaff2 = '';
            $datestaff3 = '';
            $periodeconge = '';
            $dateconge1 = '';
            $dateconge2 = '';
            $dateconge3 = '';
            $briefingsecurite = '';
            $datebriefingsecurite = '';
            $notification = '';
            $notefinance = '';
            $datenotefinance = '';
            $attesteservice = '';
            $dateattesteservice = '';
            $author='';

            $output='';

            //
            $data2 = DB::table('tchecklist')
            ->join('tagent','tagent.id','=','tchecklist.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
            'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
            'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
            'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
            'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
            'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
            'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
            "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
            "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
            'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
            "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
            "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
            "tagent.updated_at","cartes","envie",'periodeconge','dateconge1','dateconge2','dateconge3')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where('tchecklist.id','=', $id)    
            ->get(); 
            // $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent = $row->noms_agent;
                $datenaissance_agent = $row->datenaissance_agent;
                $lieunaissnce_agent = $row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;
                // $directeur=$row->directeur;
                $id = $row->id;

                $refAgent = $row->refAgent;
                $checklist = $row->checklist;
                $motivation = $row->motivation;
                $cv = $row->cv;
                $diplome = $row->diplome;
                $carteidentite = $row->carteidentite;
                $actenaissance = $row->actenaissance;
                $actenaissanceenfant = $row->actenaissanceenfant;
                $aptitudephysique = $row->aptitudephysique;
                $viemoeurs = $row->viemoeurs;
                $servicerendu = $row->servicerendu;
                $ficheidentite = $row->ficheidentite;
                $contrattravail = $row->contrattravail;
                $jobdescription = $row->jobdescription;
                $actemariage = $row->actemariage;
                $briefingmission = $row->briefingmission;
                $datebriefingmission  = $row->datebriefingmission;
                $organigramme = $row->organigramme;
                $dateorganigramme  = $row->dateorganigramme;
                $briefingposte = $row->briefingposte;
                $datebriefingposte = $row->datebriefingposte;
                $planstrategique = $row->planstrategique;
                $dateplanstrategique = $row->dateplanstrategique;
                $briefinggestion = $row->briefinggestion;
                $datebriefinggestion = $row->datebriefinggestion;
                $mannuel = $row->mannuel;
                $datemannuel = $row->datemannuel;
                $evaluationstaff = $row->evaluationstaff;
                $datestaff1 = $row->datestaff1;
                $datestaff2 = $row->datestaff2;
                $datestaff3 = $row->datestaff3;
                $periodeconge = $row->periodeconge;
                $dateconge1 = $row->dateconge1;
                $dateconge2 = $row->dateconge2;
                $dateconge3 = $row->dateconge3;
                $briefingsecurite = $row->briefingsecurite;
                $datebriefingsecurite = $row->datebriefingsecurite;
                $notification = $row->notification;
                $notefinance = $row->notefinance;
                $datenotefinance = $row->datenotefinance;
                $attesteservice = $row->attesteservice;
                $dateattesteservice = $row->dateattesteservice;
                $author = $row->author;                
            } 
            
            $aps="'";
    
            $output=' 
                
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptCheckList</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE963C131 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:21px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:614px;height:1489px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:146px;"></td>
                        <td style="height:0px;width:253px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:123px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="3" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:28px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csE963C131" colspan="2" style="width:279px;height:28px;line-height:25px;text-align:left;vertical-align:top;"><nobr>CHECK&nbsp;LIST&nbsp;D’UN&nbsp;AGENT</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="5" style="width:602px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;Les&nbsp;documents&nbsp;ci-dessous&nbsp;ont-ils&nbsp;&#233;t&#233;&nbsp;joints&nbsp;au&nbsp;dossier&nbsp;du&nbsp;personnel</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:234px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="5" style="width:602px;height:234px;line-height:16px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;Check&nbsp;List/Fiche&nbsp;individuelle&nbsp;du&nbsp;personnel&nbsp;:&nbsp;&nbsp;'.$checklist.'</nobr><br/><nobr>2.&nbsp;Lettre&nbsp;de&nbsp;motivation/Demande&nbsp;d’emploi&nbsp;:&nbsp;&nbsp;'.$motivation.'</nobr><br/><nobr>3.&nbsp;Curriculum&nbsp;vitae&nbsp;&#224;&nbsp;jour&nbsp;&nbsp;:&nbsp;&nbsp;'.$cv.'</nobr><br/><nobr>4.&nbsp;Copie&nbsp;des&nbsp;dipl&#244;mes&nbsp;obtenus&nbsp;:&nbsp;'.$diplome.'</nobr><br/><nobr>5.&nbsp;Copie&nbsp;de&nbsp;la&nbsp;carte&nbsp;d'.$aps.'identit&#233;&nbsp;:&nbsp;'.$carteidentite.'</nobr><br/><nobr>6.&nbsp;Acte&nbsp;de&nbsp;naissance&nbsp;de&nbsp;l'.$aps.'agent&nbsp;:&nbsp;'.$actenaissance.'</nobr><br/><nobr>7.&nbsp;Acte&nbsp;de&nbsp;naissance&nbsp;de&nbsp;chaque&nbsp;enfant&nbsp;:&nbsp;'.$actenaissanceenfant.'</nobr><br/><nobr>8.&nbsp;Certificat&nbsp;d’aptitude&nbsp;physique&nbsp;de&nbsp;l'.$aps.'agent&nbsp;:&nbsp;'.$aptitudephysique.'</nobr><br/><nobr>9.&nbsp;Attestation&nbsp;de&nbsp;bonne&nbsp;vie&nbsp;et&nbsp;mœurs&nbsp;:&nbsp;'.$viemoeurs.'</nobr><br/><nobr>10.&nbsp;Attestation&nbsp;de&nbsp;services&nbsp;rendus&nbsp;(de&nbsp;l'.$aps.'ancien&nbsp;employeur)&nbsp;:&nbsp;'.$servicerendu.'</nobr><br/><nobr>11.&nbsp;Fiche&nbsp;d'.$aps.'identification&nbsp;individuelle&nbsp;+&nbsp;photo&nbsp;de&nbsp;l'.$aps.'agent&nbsp;:&nbsp;'.$ficheidentite.'</nobr><br/><nobr>12.&nbsp;Copie&nbsp;du&nbsp;contrat&nbsp;de&nbsp;travail&nbsp;:&nbsp;'.$contrattravail.'</nobr><br/><nobr>13.&nbsp;Copie&nbsp;de&nbsp;description&nbsp;des&nbsp;t&#226;ches&nbsp;(Job&nbsp;description)&nbsp;:&nbsp;'.$jobdescription.'</nobr><br/><nobr>14.&nbsp;Acte&nbsp;de&nbsp;mariage&nbsp;ou&nbsp;attestation&nbsp;de&nbsp;&nbsp;c&#233;libat&nbsp;:&nbsp;'.$actemariage.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="5" style="width:602px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;ACCUEIL&nbsp;ET&nbsp;INDUCTION</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:684px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="5" style="width:602px;height:684px;line-height:16px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;Briefing&nbsp;sur&nbsp;le&nbsp;r&#244;le&nbsp;de&nbsp;la&nbsp;Caritas&nbsp;Goma&nbsp;et&nbsp;ses&nbsp;missions,&nbsp;visions,&nbsp;valeurs&nbsp;?</nobr><br/><nobr>&nbsp;=&gt;&nbsp;'.$briefingmission.'</nobr><br/><nobr>Si&nbsp;Oui,&nbsp;quelles&nbsp;dates/p&#233;riode&nbsp;?.&nbsp;'.$datebriefingmission.'.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;charg&#233;&nbsp;des&nbsp;RH)</nobr><br/><br/><nobr>2.&nbsp;Connaissance&nbsp;de&nbsp;l'.$aps.'organigramme&nbsp;&nbsp;=&gt;&nbsp;&nbsp;'.$organigramme.'</nobr><br/><nobr>Si&nbsp;Oui,&nbsp;quelles&nbsp;dates/p&#233;riode&nbsp;?&nbsp;.'.$dateorganigramme.'&nbsp;.</nobr><br/><br/><nobr>3.&nbsp;Briefing&nbsp;sur&nbsp;le&nbsp;r&#244;le&nbsp;et&nbsp;attentes&nbsp;du&nbsp;poste&nbsp;et&nbsp;sur&nbsp;une&nbsp;meilleure&nbsp;compr&#233;hension&nbsp;de&nbsp;ses&nbsp;taches&nbsp;?=&gt;&nbsp;&nbsp;'.$briefingposte.'</nobr><br/><br/><nobr>4.&nbsp;Pr&#233;sentation&nbsp;du&nbsp;plan&nbsp;strat&#233;gique&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;&nbsp;'.$planstrategique.'</nobr><br/><nobr>Si&nbsp;Oui,&nbsp;quelles&nbsp;dates/p&#233;riode&nbsp;?.&nbsp;'.$dateplanstrategique.'.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;charg&#233;&nbsp;de&nbsp;qualit&#233;)</nobr><br/><br/><nobr>5.&nbsp;Briefing&nbsp;sur&nbsp;les&nbsp;r&#232;gles&nbsp;de&nbsp;bonne&nbsp;gestion&nbsp;(corruption,&nbsp;conflit&nbsp;d'.$aps.'int&#233;r&#234;t,&nbsp;protection&nbsp;de&nbsp;l’enfance,</nobr><br/><nobr>antiterrorisme,&nbsp;etc.)</nobr><br/><nobr>=&gt;&nbsp;'.$briefinggestion.'</nobr><br/><nobr>Si&nbsp;Oui,&nbsp;quelles&nbsp;dates/p&#233;riode&nbsp;?&nbsp;&nbsp;.'.$datebriefinggestion.'.</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Avec&nbsp;le&nbsp;charg&#233;&nbsp;de&nbsp;l'.$aps.'administration&nbsp;et&nbsp;Finance)</nobr><br/><br/><nobr>6.&nbsp;Pr&#233;sentation&nbsp;du&nbsp;manuel&nbsp;de&nbsp;gestion&nbsp;et&nbsp;des&nbsp;proc&#233;dures&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;&nbsp;'.$mannuel.'</nobr><br/><nobr>Si&nbsp;Oui,&nbsp;quelles&nbsp;dates/p&#233;riode&nbsp;?&nbsp;.'.$datemannuel.'.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;charg&#233;&nbsp;de&nbsp;l'.$aps.'administration&nbsp;et&nbsp;Finance)</nobr><br/><br/><nobr>7.&nbsp;Evaluation&nbsp;du&nbsp;staff&nbsp;pr&#233;vu&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;'.$evaluationstaff.'</nobr><br/><nobr>A)&nbsp;.&nbsp;'.$datestaff1.'&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B)&nbsp;.&nbsp;'.$datestaff2.'&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C)&nbsp;.&nbsp;'.$datestaff3.'&nbsp;.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;coordonnateur&nbsp;du&nbsp;d&#233;partement)</nobr><br/><br/><nobr>8.&nbsp;P&#233;riodes&nbsp;pr&#233;vues&nbsp;cong&#233;s&nbsp;staff&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;'.$periodeconge.'</nobr><br/><nobr>Si&nbsp;oui&nbsp;quelles&nbsp;dates/p&#233;riodes&nbsp;pr&#233;vues</nobr><br/><nobr>A)&nbsp;.&nbsp;'.$dateconge1.'&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B)&nbsp;.&nbsp;'.$dateconge2.'&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C)&nbsp;.&nbsp;'.$dateconge3.'&nbsp;.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;coordonnateur&nbsp;du&nbsp;d&#233;partement&nbsp;et&nbsp;charg&#233;&nbsp;des&nbsp;RH)</nobr><br/><br/><nobr>9.&nbsp;Briefing&nbsp;sur&nbsp;la&nbsp;s&#233;curit&#233;&nbsp;afin&nbsp;de&nbsp;savoir&nbsp;les&nbsp;mesures&nbsp;de&nbsp;s&#233;curit&#233;&nbsp;mise&nbsp;en&nbsp;place&nbsp;et&nbsp;disposition&nbsp;&#224;&nbsp;prendre&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;&nbsp;'.$briefingsecurite.'</nobr><br/><nobr>Si&nbsp;oui,&nbsp;quelle&nbsp;date/p&#233;riode&nbsp;?&nbsp;&nbsp;.&nbsp;'.$datebriefingsecurite.'&nbsp;.</nobr><br/><nobr>(Avec&nbsp;le&nbsp;charg&#233;&nbsp;de&nbsp;la&nbsp;s&#233;curit&#233;)</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:44px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:479px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>III.&nbsp;FIN&nbsp;DE&nbsp;CONTRAT&nbsp;(&#224;&nbsp;remplir&nbsp;&#224;&nbsp;un&nbsp;moment&nbsp;de&nbsp;d&#233;part&nbsp;du&nbsp;staff)</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:267px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="5" style="width:602px;height:267px;line-height:16px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;Lettre&nbsp;de&nbsp;notification&nbsp;en&nbsp;avance&nbsp;avec&nbsp;copies&nbsp;avec&nbsp;l'.$aps.'Admin&nbsp;Financier&nbsp;et&nbsp;Logistique&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;&nbsp;&nbsp;'.$notification.'</nobr><br/><nobr>(Avec&nbsp;le&nbsp;charg&#233;&nbsp;des&nbsp;RH)</nobr><br/><br/><nobr>2.&nbsp;Note&nbsp;des&nbsp;finances&nbsp;indiquant&nbsp;le&nbsp;solde&nbsp;et&nbsp;tout&nbsp;compte&nbsp;et&nbsp;confirmant&nbsp;la&nbsp;d&#233;tention&nbsp;ou&nbsp;non&nbsp;de&nbsp;toutes</nobr><br/><nobr>avances,&nbsp;&#233;quipement&nbsp;dus&nbsp;&#224;&nbsp;la&nbsp;Caritas&nbsp;Coma</nobr><br/><nobr>=&gt;&nbsp;&nbsp;'.$notefinance.'</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si&nbsp;oui,&nbsp;quelle&nbsp;date/p&#233;riode&nbsp;?&nbsp;&nbsp;'.$datenotefinance.'</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Avec&nbsp;le&nbsp;charg&#233;&nbsp;d'.$aps.'Administration&nbsp;et&nbsp;Finances)</nobr><br/><br/><nobr>3.&nbsp;Attestation&nbsp;de&nbsp;services&nbsp;?</nobr><br/><nobr>=&gt;&nbsp;&nbsp;&nbsp;'.$attesteservice.'</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si&nbsp;oui,&nbsp;quelle&nbsp;date/p&#233;riode&nbsp;?&nbsp;&nbsp;.'.$dateattesteservice.'.</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Avec&nbsp;le&nbsp;charg&#233;&nbsp;d'.$aps.'Administration&nbsp;et&nbsp;Finances)</nobr><br/></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:125px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="5" style="width:602px;height:125px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;charg&#233;&nbsp;de&nbsp;Ressources&nbsp;humaines&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employ&#233;&nbsp;(pour&nbsp;r&#233;ception)</nobr><br/><nobr>'.$author.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$noms_agent.'</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$created_at.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$created_at.'</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature</nobr><br/></td>
                    </tr>
                </table>
                </body>
                </html>
              
            '; 

    return $output;

}

//=========== CONTRAT DE PRESTATION AGENT ===================================================================

function pdf_contrat_travail_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetContratTravailAgent($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}
function GetContratTravailAgent($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $bp=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $idAgent=0;
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nom_poste='';
            $nom_lieu='';
            $description_lieu='';
            $nom_mutuelle='';
            $code_contrat='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';
            $dateAffectation='';
            $dureecontrat='';
            $dateFin='';

            $dateDebutEssaie='';
            $dateFinEssaie='';
            $JourTrail1='';
            $JourTrail2='';
            $heureTrail1='';
            $heureTrail2='';
            $TempsPause='';
            $nbrConge='';
            $nbrCongeLettre='';
            $nomOffice='';
            $postnomOffice='';
            $qualifieOffice='';
            $codeAgent='';
            $directeur='';
            $dureeessaie='';

            $salaire_base=0;
            $fammiliale= 0;
            $logement= 0;
            $transport= 0;
            $sal_brut= 0;
            $sal_brut_imposable= 0;
            $inss_qpo= 0;
            $inss_qpp= 0;
            $cnss= 0;
            $inpp= 0;
            $onem= 0;
            $ipr= 0;
            $netPaie=0;



            $urgence="'URGENCE";
            $identi="'IDENTIFICATION";
            $enfant="'ENFANTS";
            $origine="'ORIGINE";
            $etude="'ETUDE";


            $aps="'";

            //
            $data2 = DB::table('tperso_affectation_agent')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
            'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
            'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr',"salaire_base")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
            ->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
            ->where('tperso_affectation_agent.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo_agent.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;

                $nom_poste=$row->nom_poste;
                $nom_lieu=$row->nom_lieu;
                $description_lieu=$row->description_lieu;
                $nom_mutuelle=$row->nom_mutuelle;
                $code_contrat=$row->code_contrat;
                $dateAffectation=$row->dateAffectation;
                $dureecontrat=$row->dureecontrat;
                $dateFin=$row->dateFin;

                $dateDebutEssaie=$row->dateDebutEssaie;
                $dateFinEssaie=$row->dateFinEssaie;
                $dureeessaie=$row->dureeessaie;
                $JourTrail1=$row->JourTrail1;
                $JourTrail2=$row->JourTrail2;
                $heureTrail1=$row->heureTrail1;
                $heureTrail2=$row->heureTrail2;
                $TempsPause=$row->TempsPause;
                $nbrConge=$row->nbrConge;
                $nbrCongeLettre=$row->nbrCongeLettre;
                $nomOffice=$row->nomOffice;
                $postnomOffice=$row->postnomOffice;
                $qualifieOffice=$row->qualifieOffice;
                $codeAgent=$row->codeAgent;
                $directeur=$row->directeur;
                $idAgent=$row->id;


                $salaire_base=$row->salaire_base;
                $fammiliale= $row->fammiliale;
                $logement= $row->logement;
                $transport= $row->transport;
                $sal_brut= $row->sal_brut;
                $sal_brut_imposable= $row->sal_brut_imposable;
                $inss_qpo= $row->inss_qpo;
                $inss_qpp= $row->inss_qpp;
                $cnss= $row->cnss;
                $inpp= $row->inpp;
                $onem= $row->onem;
                $ipr= $row->ipr;
                $netPaie=$row->netPaie;
                
            }  
            
        $nbrEnfant=0;
         // 
         $data2 =  DB::table('tperso_dependant')         
         ->select(DB::raw('IFNULL(ROUND(COUNT(tperso_dependant.id),0),0) as nbrEnfant'))
         ->where([
            ['tperso_dependant.refAgent','=', $idAgent]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $nbrEnfant=$row->nbrEnfant;                           
         }
    

            $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptContratTravail</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs62AA4CC9 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; }
                        .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs96BB7212 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:21px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                        .csDDBE550A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs73E9FFE6 {color:#000000;background-color:transparent;font-family:Times New Roman;font-size:16px;font-weight:normal;font-style:normal;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        .csD15347B9 {text-align:left;text-indent:0pt;margin:0pt 0pt 0pt 0pt;line-height:1.2}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:635px;height:2329px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:64px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:104px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:100px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="15" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:28px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csDDBE550A" colspan="8" style="width:253px;height:28px;line-height:25px;text-align:center;vertical-align:top;"><nobr>CONTRAT&nbsp;DE&nbsp;TRAVAIL</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs96BB7212" colspan="12" style="width:351px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>ENTRE&nbsp;LES&nbsp;SOUSSIGNES&nbsp;:</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="13" style="width:433px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;LA&nbsp;CARITAS-DEVELOPPEMENT/DIOCESE&nbsp;DE&nbsp;GOMA,</nobr></td>
                        <td class="cs1698ECB3" colspan="4" style="width:166px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>ici&nbsp;repr&#233;sent&#233;e&nbsp;par&nbsp;son</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="2" rowspan="2" style="width:70px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Directeur,</nobr></td>
                        <td class="cs9E712815" colspan="8" style="width:273px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Monsieur&nbsp;'.$directeur.',</nobr></td>
                        <td class="cs1698ECB3" colspan="9" style="width:278px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>ci-apr&#232;s&nbsp;d&#233;nomm&#233;e&nbsp;&nbsp;&#171;</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="3" style="width:134px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'EMPLOYEUR</nobr></td>
                        <td class="cs1698ECB3" colspan="4" style="width:90px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&#187;&nbsp;d'.$aps.'une&nbsp;part,</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE9F2AA97" colspan="3" style="width:146px;height:22px;line-height:18px;text-align:center;vertical-align:top;"><nobr>ET</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="5" style="width:155px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>2.Monsieur/Madame</nobr></td>
                        <td class="cs62AA4CC9" colspan="14" style="width:470px;height:22px;text-decoration:none;"><div style="overflow:hidden;width:470px;height:22px;">
                            <div>
                                <p class="csD15347B9"><span class="cs73E9FFE6">'.$noms_agent.'</span></p></div>
                        </div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:106px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:106px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fils/Fille&nbsp;de.'.$nomPere_agent.' et de '.$nomMere_agent.'</nobr><br/><nobr>N&#233;e&nbsp;&#224;.&nbsp;'.$lieunaissnce_agent.'&nbsp;Le&nbsp;'.$datenaissance_agent.'.</nobr><br/><nobr>Etat&nbsp;civil&nbsp;:&nbsp;.'.$etatcivil_agent.'.</nobr><br/><nobr>Nationalit&#233;&nbsp;:&nbsp;.'.$Nationalite_agent.'.</nobr><br/><nobr>Nombre&nbsp;d'.$aps.'enfants&nbsp;&#224;&nbsp;charge&nbsp;:&nbsp;.'.$nbrEnfant.'.</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="2" style="width:34px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>N&#176;</nobr></td>
                        <td class="cs56F73198" colspan="8" style="width:294px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Noms,&nbsp;postnoms,&nbsp;prenoms</nobr></td>
                        <td class="cs56F73198" colspan="6" style="width:143px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;de&nbsp;naissance</nobr></td>
                        <td class="cs56F73198" colspan="3" style="width:139px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Observations</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    ';
                                                                                                                    
                            $output .= $this->showDependants($idAgent); 
                                                                                                                    
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Ci-apr&#232;s&nbsp;d&#233;nomm&#233;&nbsp;(e)&nbsp;&#171;L'.$aps.'EMPLOYE.E&nbsp;&#187;</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:60px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:625px;height:60px;line-height:18px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;L&nbsp;A&nbsp;ETE&nbsp;CONVENU&nbsp;CE&nbsp;QUI&nbsp;SUIT&nbsp;:</nobr><br/><br/><nobr>Article&nbsp;1&nbsp;:&nbsp;Engagement&nbsp;et&nbsp;nature&nbsp;du&nbsp;travail</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:113px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="18" style="width:624px;height:113px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'empoy&#233;.e,&nbsp;qui&nbsp;se&nbsp;d&#233;clare&nbsp;libre&nbsp;de&nbsp;toute&nbsp;obligation&nbsp;professionnelle,&nbsp;est&nbsp;engag&#233;.e&nbsp;&#224;&nbsp;la&nbsp;Caritas</nobr><br/><nobr>D&#233;veloppement&nbsp;Dioc&#232;se&nbsp;de&nbsp;Goma&nbsp;en&nbsp;qualit&#233;&nbsp;de&nbsp;.'.$nom_poste.'.sous&nbsp;le&nbsp;contr&#244;le&nbsp;de&nbsp;ses</nobr><br/><nobr>chefs&nbsp;hi&#233;rarchiques.&nbsp;Il/Elle&nbsp;est&nbsp;affect&#233;e&nbsp;&#224;.'.$nom_lieu.'.Il/Elle&nbsp;certifie&nbsp;avoir&nbsp;lu,</nobr><br/><nobr>compris&nbsp;et&nbsp;approuv&#233;&nbsp;les&nbsp;termes&nbsp;et&nbsp;les&nbsp;conditions&nbsp;de&nbsp;sa&nbsp;description&nbsp;de&nbsp;poste&nbsp;et&nbsp;du&nbsp;r&#232;glement</nobr><br/><nobr>d'.$aps.'ordre&nbsp;int&#233;rieur&nbsp;de&nbsp;la&nbsp;Caritas-D&#233;veloppement&nbsp;Goma&nbsp;qui&nbsp;font&nbsp;partie&nbsp;int&#233;grante&nbsp;du&nbsp;pr&#233;sent</nobr><br/><nobr>contrat.</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:625px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;2&nbsp;:&nbsp;Lieu&nbsp;d'.$aps.'affectation</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="18" style="width:624px;height:42px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'employ&#233;.e&nbsp;est&nbsp;affect&#233;.e&nbsp;&#224;&nbsp;.'.$nom_lieu.'.&nbsp;mais&nbsp;le&nbsp;lieu&nbsp;d'.$aps.'affectation&nbsp;pourrait&nbsp;&#233;tre</nobr><br/><nobr>chang&#233;&nbsp;par&nbsp;la&nbsp;Caritas-D&#233;veloppement&nbsp;Goma&nbsp;selon&nbsp;l'.$aps.'exigence&nbsp;de&nbsp;ses&nbsp;activit&#233;s.</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:625px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;3&nbsp;:&nbsp;Dur&#233;e&nbsp;du&nbsp;contrat&nbsp;de&nbsp;travail</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:42px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;present&nbsp;contrat&nbsp;de&nbsp;travail&nbsp;est&nbsp;conclu&nbsp;pour&nbsp;une&nbsp;dur&#233;e&nbsp;d&#233;termin&#233;e&nbsp;de&nbsp;.'.$dureecontrat.'&nbsp;Mois.&nbsp;&#224;&nbsp;compter</nobr><br/><nobr>du&nbsp;.'.$dateAffectation.'.&nbsp;au&nbsp;.'.$dateFin.'.&nbsp;La&nbsp;p&#233;riode&nbsp;probatoire&nbsp;y&nbsp;comprise.</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:624px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;4&nbsp;:&nbsp;P&#233;riode&nbsp;d'.$aps.'essai</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:58px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="18" style="width:624px;height:58px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;periode&nbsp;d'.$aps.'essai&nbsp;est&nbsp;de&nbsp;.2&nbsp;Mois.&nbsp;&#224;&nbsp;compter&nbsp;du&nbsp;.'.$dateDebutEssaie.'.&nbsp;au&nbsp;.'.$dateFinEssaie.'.&nbsp;Pendant&nbsp;cette</nobr><br/><nobr>p&#233;riode,&nbsp;chacune&nbsp;des&nbsp;parties&nbsp;peut&nbsp;mettre&nbsp;fin&nbsp;&#224;&nbsp;l'.$aps.'engagement&nbsp;moyennant&nbsp;un&nbsp;pr&#233;avis&nbsp;l&#233;gal&nbsp;de&nbsp;trois</nobr><br/><nobr>jours.</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:625px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;5:&nbsp;R&#233;mun&#233;ration&nbsp;et&nbsp;indemnit&#233;s</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:76px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:76px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'employ&#233;&nbsp;percevra&nbsp;un&nbsp;salaire&nbsp;mensuel&nbsp;net&nbsp;de.......SUS.'.$netPaie.'.dollars&nbsp;am&#233;ricains)&nbsp;correspondant</nobr><br/><nobr>(….&nbsp;&#224;&nbsp;......%&nbsp;du&nbsp;temps&nbsp;octroy&#233;&nbsp;&#224;&nbsp;l'.$aps.'employeur&nbsp;et&nbsp;payable&nbsp;en&nbsp;francs&nbsp;congolais&nbsp;&#224;&nbsp;la&nbsp;fin&nbsp;de&nbsp;chaque</nobr><br/><nobr>mois&nbsp;r&#233;parti&nbsp;de&nbsp;la&nbsp;mani&#232;re&nbsp;suivante&nbsp;:</nobr><br/></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Salaire&nbsp;de&nbsp;base&nbsp;:&nbsp;'.$salaire_base.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Indemnit&#233;s&nbsp;de&nbsp;logement&nbsp;:&nbsp;'.$logement.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Transport&nbsp;:&nbsp;'.$transport.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Traitement&nbsp;brut&nbsp;:&nbsp;'.$sal_brut.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Total&nbsp;brut&nbsp;imposable&nbsp;:&nbsp;'.$sal_brut_imposable.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>CNSS&nbsp;QPO&nbsp;:&nbsp;'.$inss_qpo.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>CNSS&nbsp;QPP&nbsp;INPP&nbsp;:&nbsp;'.$inss_qpp.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:625px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>INPP&nbsp;:&nbsp;'.$inpp.'$</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>ONEM&nbsp;:&nbsp;'.$onem.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>IPR&nbsp;:&nbsp;'.$ipr.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="19" style="width:624px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Net&nbsp;&#224;&nbsp;payer&nbsp;:&nbsp;'.$netPaie.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="18" style="width:624px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;6&nbsp;:&nbsp;Soins&nbsp;m&#233;dicaux</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:57px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="18" style="width:624px;height:57px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'employeur&nbsp;assurera&nbsp;les&nbsp;soins&nbsp;m&#233;dicaux&nbsp;&#224;&nbsp;l'.$aps.'employ&#233;.e&nbsp;et&nbsp;aux&nbsp;membres&nbsp;de&nbsp;sa&nbsp;famille&nbsp;(son&nbsp;ou&nbsp;sa</nobr><br/><nobr>conjoint.e&nbsp;et&nbsp;ses&nbsp;enfants&nbsp;biologiques&nbsp;ou&nbsp;sous&nbsp;tutelle)&nbsp;selon&nbsp;le&nbsp;taux&nbsp;fix&#233;&nbsp;par&nbsp;la&nbsp;mutuelle&nbsp;de&nbsp;sant&#233;</nobr><br/><nobr>'.$nom_mutuelle.'.</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="21" style="width:626px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;7&nbsp;:&nbsp;Horaire&nbsp;de&nbsp;travail</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="21" style="width:626px;height:41px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'employ&#233;.e&nbsp;s'.$aps.'engage&nbsp;&#224;&nbsp;travailler&nbsp;du&nbsp;'.$JourTrail1.'&nbsp;au&nbsp;'.$JourTrail2.'&nbsp;entre&nbsp;'.$heureTrail1.'&nbsp;&nbsp;et&nbsp;'.$heureTrail2.'&nbsp;avec&nbsp;une&nbsp;pause&nbsp;de</nobr><br/><nobr>trente&nbsp;minutes&nbsp;par&nbsp;jour.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="22" style="width:627px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;8&nbsp;:&nbsp;Mission&nbsp;de&nbsp;service</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="21" style="width:626px;height:41px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Si&nbsp;l'.$aps.'employ&#233;e&nbsp;est&nbsp;appel&#233;e&nbsp;&#224;&nbsp;effectuer&nbsp;des&nbsp;missions&nbsp;de&nbsp;service,&nbsp;son&nbsp;transport,&nbsp;son&nbsp;logement&nbsp;et&nbsp;ses</nobr><br/><nobr>repas&nbsp;seront&nbsp;pris&nbsp;en&nbsp;charge&nbsp;par&nbsp;l'.$aps.'employeur&nbsp;tel&nbsp;qu'.$aps.'indiqu&#233;&nbsp;par&nbsp;celui-ci.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="22" style="width:627px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;9:&nbsp;Cong&#233;s&nbsp;de&nbsp;reconstitution</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="22" style="width:627px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>L'.$aps.'employ&#233;.e&nbsp;a&nbsp;droit&nbsp;&#224;&nbsp;un&nbsp;cong&#233;&nbsp;de&nbsp;reconstitution&nbsp;de&nbsp;'.$nbrConge.'&nbsp;jours&nbsp;ouvrables&nbsp;par&nbsp;an.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="22" style="width:627px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;10&nbsp;:&nbsp;R&#233;siliation&nbsp;du&nbsp;contrat&nbsp;de&nbsp;travail</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:396px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="21" style="width:626px;height:396px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;Le&nbsp;pr&#233;sent&nbsp;contrat&nbsp;de&nbsp;travail&nbsp;peut&nbsp;&#234;tre&nbsp;r&#233;sili&#233;&nbsp;de&nbsp;commun&nbsp;accord&nbsp;ou&nbsp;&#224;&nbsp;l'.$aps.'initiative&nbsp;de&nbsp;la&nbsp;partie</nobr><br/><nobr>diligente&nbsp;qui&nbsp;l'.$aps.'en&nbsp;notifiera&nbsp;&#224;&nbsp;l'.$aps.'autre&nbsp;dans&nbsp;le&nbsp;respect&nbsp;des&nbsp;dispositions&nbsp;l&#233;gales.&nbsp;Il&nbsp;est&nbsp;r&#233;put&#233;&nbsp;r&#233;sili&#233;&nbsp;de</nobr><br/><nobr>plein&nbsp;droit&nbsp;&#224;&nbsp;l'.$aps.'expiration&nbsp;du&nbsp;terme&nbsp;convenu.&nbsp;Toutefois,&nbsp;en&nbsp;cas&nbsp;de&nbsp;faute&nbsp;lourde,&nbsp;chacune&nbsp;des&nbsp;parties</nobr><br/><nobr>peut&nbsp;le&nbsp;rompre&nbsp;sans&nbsp;pr&#233;avis&nbsp;ni&nbsp;indemnit&#233;&nbsp;de&nbsp;licenciement.&nbsp;L'.$aps.'employ&#233;&nbsp;est&nbsp;reprochable&nbsp;de&nbsp;faute</nobr><br/><nobr>lourde&nbsp;pouvant&nbsp;entra&#238;ner&nbsp;la&nbsp;r&#233;siliation&nbsp;sans&nbsp;pr&#233;avis&nbsp;ni&nbsp;indemnit&#233;&nbsp;de&nbsp;son&nbsp;contrat&nbsp;de&nbsp;travail,&nbsp;dans&nbsp;les</nobr><br/><nobr>cas&nbsp;non&nbsp;exhaustifs&nbsp;ci-apr&#232;s&nbsp;:</nobr><br/><nobr>-&nbsp;Improbit&#233;,&nbsp;injures,&nbsp;voies&nbsp;de&nbsp;fait&nbsp;&#224;&nbsp;l'.$aps.'&#233;gard&nbsp;de&nbsp;l'.$aps.'employeur&nbsp;ou&nbsp;d'.$aps.'un&nbsp;membre&nbsp;du&nbsp;personnel</nobr><br/><nobr>-&nbsp;Usage&nbsp;d'.$aps.'alcool&nbsp;ou&nbsp;de&nbsp;drogue&nbsp;au&nbsp;lieu&nbsp;du&nbsp;travail</nobr><br/><nobr>-&nbsp;Fraude,&nbsp;malhonn&#234;tet&#233;.&nbsp;Falsification&nbsp;des&nbsp;documents</nobr><br/><nobr>-&nbsp;Menace.&nbsp;Bagarre&nbsp;et&nbsp;port&nbsp;d'.$aps.'armes</nobr><br/><nobr>-&nbsp;Se&nbsp;livrer&nbsp;&#224;&nbsp;des&nbsp;actions&nbsp;immorales&nbsp;au&nbsp;lieu&nbsp;du&nbsp;travail</nobr><br/><nobr>-&nbsp;S'.$aps.'approprier&nbsp;le&nbsp;mat&#233;riel&nbsp;de&nbsp;travail&nbsp;sans&nbsp;autorisation</nobr><br/><nobr>-&nbsp;Divulgation&nbsp;des&nbsp;secrets&nbsp;professionnels&nbsp;ou&nbsp;des&nbsp;informations&nbsp;internes&nbsp;&#224;&nbsp;la&nbsp;Caritas-</nobr><br/><nobr>D&#233;veloppement&nbsp;Goma</nobr><br/><nobr>-&nbsp;Abandon&nbsp;de&nbsp;poste&nbsp;ou&nbsp;absence&nbsp;prolong&#233;e&nbsp;pendant&nbsp;4&nbsp;jours&nbsp;cons&#233;cutifs&nbsp;:</nobr><br/><nobr>-&nbsp;Manque&nbsp;de&nbsp;discipline&nbsp;et&nbsp;d'.$aps.'application&nbsp;au&nbsp;travail&nbsp;de&nbsp;fa&#231;on&nbsp;r&#233;p&#233;titive&nbsp;;</nobr><br/><nobr>-&nbsp;Insuffisance&nbsp;ou&nbsp;inaptitude&nbsp;professionnelle&nbsp;av&#233;r&#233;e&nbsp;et&nbsp;notifi&#233;e&nbsp;d'.$aps.'un&nbsp;avertissement&nbsp;;</nobr><br/><nobr>-&nbsp;Comportement&nbsp;public&nbsp;dommageable&nbsp;&#224;&nbsp;l'.$aps.'employeur&nbsp;et/ou&nbsp;&#224;&nbsp;son&nbsp;partenaire</nobr><br/><nobr>-&nbsp;D&#233;tournement&nbsp;des&nbsp;biens&nbsp;destin&#233;s&nbsp;&#224;&nbsp;l'.$aps.'organisation&nbsp;ou&nbsp;aux&nbsp;b&#233;n&#233;ficiaires</nobr><br/><nobr>-&nbsp;P&#233;dophilie,&nbsp;polygamie,</nobr><br/><nobr>-&nbsp;Non-respect&nbsp;de&nbsp;la&nbsp;PEAS&nbsp;(Pr&#233;vention&nbsp;contre&nbsp;I&nbsp;‘exploitation&nbsp;et&nbsp;les&nbsp;abus&nbsp;sexuels).</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="21" style="width:626px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;11:&nbsp;Cas&nbsp;de&nbsp;force&nbsp;majeure</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:39px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="21" style="width:626px;height:39px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Les&nbsp;soussign&#233;s&nbsp;conviennent&nbsp;express&#233;ment&nbsp;qu'.$aps.'en&nbsp;cas&nbsp;de&nbsp;force&nbsp;majeure,&nbsp;notamment&nbsp;le&nbsp;manque&nbsp;ou</nobr><br/><nobr>la&nbsp;rupture&nbsp;de&nbsp;financement,&nbsp;le&nbsp;pr&#233;sent&nbsp;contrat&nbsp;sera&nbsp;r&#233;sili&#233;&nbsp;sans&nbsp;indemnit&#233;&nbsp;ni&nbsp;pr&#233;avis.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="21" style="width:626px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;12&nbsp;:&nbsp;R&#232;glement&nbsp;des&nbsp;diff&#233;rends</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:44px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="21" style="width:626px;height:44px;line-height:18px;text-align:left;vertical-align:top;"><nobr>En&nbsp;cas&nbsp;de&nbsp;diff&#233;rends&nbsp;ou&nbsp;de&nbsp;contestations&nbsp;du&nbsp;pr&#233;sent&nbsp;contrat&nbsp;de&nbsp;travail,&nbsp;les&nbsp;parties&nbsp;privil&#233;gieront</nobr><br/><nobr>une&nbsp;solution&nbsp;&#224;&nbsp;l'.$aps.'amiable&nbsp;et&nbsp;en&nbsp;cas&nbsp;d'.$aps.'&#233;chec,&nbsp;elles&nbsp;se&nbsp;r&#233;f&#233;reront&nbsp;aux&nbsp;instances&nbsp;comp&#233;tentes.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="21" style="width:626px;height:24px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Article&nbsp;13&nbsp;:&nbsp;Dispositions&nbsp;finales</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:65px;"></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="23" style="width:628px;height:65px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;Pour&nbsp;des&nbsp;cas&nbsp;qui&nbsp;ne&nbsp;sont&nbsp;pr&#233;cis&#233;s&nbsp;dans&nbsp;le&nbsp;pr&#233;sent&nbsp;contrat&nbsp;de&nbsp;travail,&nbsp;les&nbsp;parties&nbsp;se&nbsp;r&#233;f&#233;reront&nbsp;aux</nobr><br/><nobr>dispositions&nbsp;l&#233;gales&nbsp;et&nbsp;r&#233;glementaires&nbsp;en&nbsp;vigueur&nbsp;en&nbsp;R&#233;publique&nbsp;d&#233;mocratique&nbsp;du&nbsp;Congo&nbsp;et&nbsp;au</nobr><br/><nobr>R&#232;glement&nbsp;d'.$aps.'ordre&nbsp;int&#233;rieur&nbsp;de&nbsp;la&nbsp;Caritas-D&#233;veloppement&nbsp;Goma.</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:148px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs1698ECB3" colspan="22" style="width:627px;height:148px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma,&nbsp;Le&nbsp;....../....../20....</nobr><br/><br/><nobr>Pour&nbsp;l'.$aps.'employ&#233;e&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pour&nbsp;la&nbsp;Caritas-D&#233;veloppement&nbsp;Goma</nobr><br/><br/><nobr>.................................</nobr><br/><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directeur</nobr><br/></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:96px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="21" style="width:626px;height:96px;line-height:18px;text-align:left;vertical-align:top;"><nobr>OFFICE&nbsp;NATIONAL&nbsp;DE&nbsp;L'.$aps.'EMPLOI</nobr><br/><nobr>Nom,&nbsp;postnom&nbsp;et&nbsp;qualit&#233;.&nbsp;CARITAS&nbsp;CARITAS&nbsp;et&nbsp;MECANICIEN.</nobr><br/><nobr>Sous&nbsp;le&nbsp;num&#233;ro...000000.</nobr><br/><nobr>Signature&nbsp;et&nbsp;sceau....................................................................................................................</nobr><br/></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>

              '; 

    return $output;

}
function showDependants($idAgent)
{
        $count=0;

        $data = DB::table('tperso_dependant')
        ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
        "refAgent","matricule_agent",'tperso_dependant.author',
        "noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->where('tperso_dependant.refAgent', $idAgent)
        ->orderBy("noms_dependant", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='

                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="2" style="width:32px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>'.$count.'</nobr></td>
                    <td class="cs56F73198" colspan="8" style="width:294px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$row->noms_dependant.'</nobr></td>
                    <td class="cs56F73198" colspan="6" style="width:143px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$row->date_naissance.'</nobr></td>
                    <td class="cs56F73198" colspan="3" style="width:139px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$row->degre_parente.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            
            ';      

    }

    return $output;

}



//=========== FICHE DE CONGE AGENT ===================================================================

function pdf_fiche_conge_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetFicheCongeAgent($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function GetFicheCongeAgent($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $bp=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nom_poste='';
            $nom_lieu='';
            $description_lieu='';
            $nom_mutuelle='';
            $code_contrat='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';
            $dateAffectation='';
            $dureecontrat='';
            $dateFin='';

            $dateDebutEssaie='';
            $dateFinEssaie='';
            $JourTrail1='';
            $JourTrail2='';
            $heureTrail1='';
            $heureTrail2='';
            $TempsPause='';
            $nbrConge='';
            $nbrCongeLettre='';
            $nomOffice='';
            $postnomOffice='';
            $qualifieOffice='';
            $codeAgent='';
            $directeur='';
            $dureeessaie='';

            $matricule_agent='';
            $name_annee='';
            $date_demande='';
            $date_depart='';
            $nbr_joursollicite='';
            $date_reprise='';
            $superviseur_conge='';
            $interimaire_conge='';
            $resumetache_conge='';
            $nom_circontstance='';
            $rh_conge='';
            $coordinateur_conge='';
            $directeur_conge='';
            $date_debut_accord='';
            $date_fin_accord='';
            $nbr_jouraccord='';
            $cumul_conge_annee='';
            $solde_conge_datedu='';
            $solde_conge_reprise='';
            $admin_fin_conge='';


            $agent="'agent";
            $interimaire="'interimaire";
            $engage="'engagement";
            $apt="'";

            // 
            $data2 = DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
            ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
            ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays') 
            ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
            'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
            'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
            'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
            'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
            'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
            "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
            'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'conjoint_agent','nomMere_agent','nomPere_agent','Nationalite_agent',
            'Collectivite_agent','Territoire_agent','EmployeurAnt_agent','PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
            'tperso_affectation_agent.created_at','nomOffice','postnomOffice','qualifieOffice')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')
            ->where('tperso_demandeconge.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo_agent.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;

                $nom_poste=$row->nom_poste;
                $nom_lieu=$row->nom_lieu;
                $description_lieu=$row->description_lieu;
                $nom_mutuelle=$row->nom_mutuelle;
                $code_contrat=$row->code_contrat;
                $dateAffectation=$row->dateAffectation;
                $dureecontrat=$row->dureecontrat;
                $dateFin=$row->dateFin;

                $dateDebutEssaie=$row->dateDebutEssaie;
                $dateFinEssaie=$row->dateFinEssaie;
                $dureeessaie=$row->dureeessaie;
                $JourTrail1=$row->JourTrail1;
                $JourTrail2=$row->JourTrail2;
                $heureTrail1=$row->heureTrail1;
                $heureTrail2=$row->heureTrail2;
                $TempsPause=$row->TempsPause;
                $nbrConge=$row->nbrConge;
                $nbrCongeLettre=$row->nbrCongeLettre;
                $nomOffice=$row->nomOffice;
                $postnomOffice=$row->postnomOffice;
                $qualifieOffice=$row->qualifieOffice;
                $codeAgent=$row->codeAgent;
                $directeur=$row->directeur;


                $name_annee=$row->name_annee;
                $date_demande=$row->date_demande;
                $date_depart=$row->date_depart;
                $nbr_joursollicite=$row->nbr_joursollicite;
                $date_reprise=$row->date_reprise;
                $superviseur_conge=$row->superviseur_conge;
                $interimaire_conge=$row->interimaire_conge;
                $resumetache_conge=$row->resumetache_conge;
                $nom_circontstance=$row->nom_circontstance;
                $rh_conge=$row->rh_conge;
                $coordinateur_conge=$row->coordinateur_conge;
                $directeur_conge=$row->directeur_conge;
                $date_debut_accord=$row->date_debut_accord;
                $date_fin_accord=$row->date_fin_accord;
                $nbr_jouraccord=$row->nbr_jouraccord;
                $cumul_conge_annee=$row->cumul_conge_annee;
                $solde_conge_datedu=$row->solde_conge_datedu;
                $solde_conge_reprise=$row->solde_conge_reprise;
                $matricule_agent=$row->matricule_agent;   
                $admin_fin_conge=$row->admin_fin_conge;             
            }        
    
            $output=' 

                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>rptFicheConge</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs5D94BC31 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                            .cs82D98BB6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs425CAA45 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; }
                            .csC7CA2B54 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:italic; padding-left:2px;}
                            .csC4CEB805 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:643px;height:1010px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:1px;"></td>
                            <td style="height:0px;width:1px;"></td>
                            <td style="height:0px;width:43px;"></td>
                            <td style="height:0px;width:97px;"></td>
                            <td style="height:0px;width:12px;"></td>
                            <td style="height:0px;width:21px;"></td>
                            <td style="height:0px;width:45px;"></td>
                            <td style="height:0px;width:110px;"></td>
                            <td style="height:0px;width:23px;"></td>
                            <td style="height:0px;width:50px;"></td>
                            <td style="height:0px;width:32px;"></td>
                            <td style="height:0px;width:44px;"></td>
                            <td style="height:0px;width:64px;"></td>
                            <td style="height:0px;width:92px;"></td>
                            <td style="height:0px;width:1px;"></td>
                            <td style="height:0px;width:1px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td class="cs739196BC" colspan="11" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:35px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csA67C9637" colspan="9" rowspan="2" style="width:477px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="3" rowspan="6" style="width:141px;height:137px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:141px;height:137px;">
                                <img alt="" src="'.$pic2.'" style="width:141px;height:137px;" /></div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs5DE5F832" colspan="9" style="width:477px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse :'.$adresseEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csECF45065" colspan="9" style="width:477px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:'.$emailEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:25px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csECF45065" colspan="9" style="width:477px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:21px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs5DE5F832" colspan="9" style="width:477px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs5DE5F832" colspan="9" style="width:477px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:4px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="15" style="width:636px;height:4px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs5971619E" colspan="15" style="width:636px;height:1px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:4px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="15" style="width:636px;height:4px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:25px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs5D94BC31" colspan="14" style="width:629px;height:23px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;CONGE</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs9E712815" colspan="11" style="width:476px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>I.&nbsp;Identifiant&nbsp;de&nbsp;l'.$agent.'</nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;post&nbsp;nom</nobr></td>
                            <td class="cs82D98BB6" colspan="12" style="width:494px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Matricule</nobr></td>
                            <td class="cs82D98BB6" colspan="12" style="width:494px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$matricule_agent.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Fonction</nobr></td>
                            <td class="cs82D98BB6" colspan="12" style="width:494px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$nom_poste.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone/E-mail</nobr></td>
                            <td class="cs82D98BB6" colspan="12" style="width:494px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$contact_agent.'&nbsp;/&nbsp;'.$mail_agent.'</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:21px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs9E712815" colspan="15" style="width:634px;height:21px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>II.&nbsp;Information&nbsp;par&nbsp;rapport&nbsp;au&nbsp;cong&#233;&nbsp;sollicit&#233;</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Type&nbsp;Cong&#233;</nobr></td>
                            <td class="cs425CAA45" colspan="12" style="width:494px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">'.$nom_circontstance.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:172px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;de&nbsp;la&nbsp;demande</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:177px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$date_demande.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:190px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nombre&nbsp;de&nbsp;jours&nbsp;sollicit&#233;s</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$nbr_joursollicite.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:47px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:172px;height:45px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;pr&#233;vue&nbsp;pour&nbsp;le&nbsp;d&#233;part</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:177px;height:45px;line-height:15px;text-align:center;vertical-align:middle;">'.$date_depart.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:189px;height:45px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;pr&#233;vue&nbsp;pour&nbsp;la&nbsp;reprise&nbsp;du</nobr><br/><nobr>travail</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:93px;height:45px;line-height:15px;text-align:center;vertical-align:middle;">'.$date_reprise.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="7" style="width:327px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;du&nbsp;demandeur</nobr></td>
                            <td class="cs82D98BB6" colspan="8" style="width:306px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;du&nbsp;superviseur</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:46px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="7" style="width:327px;height:44px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                            <td class="cs82D98BB6" colspan="8" style="width:306px;height:44px;line-height:15px;text-align:left;vertical-align:middle;">'.$superviseur_conge.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="7" style="width:327px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;de&nbsp;l'.$interimaire.'</nobr></td>
                            <td class="cs82D98BB6" colspan="8" style="width:306px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>R&#233;sum&#233;&nbsp;des&nbsp;taches&nbsp;:</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:47px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="7" style="width:327px;height:45px;line-height:15px;text-align:left;vertical-align:middle;">'.$interimaire_conge.'</td>
                            <td class="cs82D98BB6" colspan="8" style="width:306px;height:45px;line-height:15px;text-align:left;vertical-align:middle;">'.$resumetache_conge.'</td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:2px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs9E712815" colspan="14" style="width:633px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>III.&nbsp;R&#233;serv&#233;e&nbsp;aux&nbsp;RH</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:172px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;d'.$engage.'</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:177px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$date_debut_accord.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:190px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Solde&nbsp;cong&#233;au&nbsp;:&nbsp;'.$dateFin.'</nobr></td>
                            <td class="csAB3AA82A" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$nbrConge.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:46px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:172px;height:44px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Cumul&nbsp;des&nbsp;cong&#233;s&nbsp;pris&nbsp;au</nobr><br/><nobr>courant&nbsp;de&nbsp;l'.$apt.'ann&#233;e</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:177px;height:44px;line-height:15px;text-align:center;vertical-align:middle;">'.$cumul_conge_annee.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:190px;height:44px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Solde&nbsp;cong&#233;&nbsp;&#224;&nbsp;la&nbsp;date&nbsp;du</nobr><br/>'.$date_debut_accord.'</td>
                            <td class="csAB3AA82A" colspan="2" style="width:91px;height:44px;line-height:15px;text-align:center;vertical-align:middle;">'.$solde_conge_datedu.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:19px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:172px;height:17px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nombre&nbsp;de&nbsp;jours&nbsp;accord&#233;s</nobr></td>
                            <td class="csAB3AA82A" colspan="3" style="width:177px;height:17px;line-height:15px;text-align:center;vertical-align:middle;">'.$nbr_jouraccord.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:190px;height:17px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Solde&nbsp;cong&#233;&nbsp;&#224;&nbsp;la&nbsp;reprise</nobr></td>
                            <td class="csAB3AA82A" colspan="2" style="width:91px;height:17px;line-height:15px;text-align:center;vertical-align:middle;">'.$solde_conge_reprise.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:12px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:56px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:217px;height:54px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Nom&nbsp;et&nbsp;signature&nbsp;du&nbsp;charg&#233;&nbsp;de</nobr><br/><nobr>l'.$apt.'administration&nbsp;et&nbsp;finances</nobr></td>
                            <td class="cs82D98BB6" colspan="4" style="width:214px;height:54px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Signature&nbsp;du&nbsp;responsable&nbsp;RH</nobr></td>
                            <td class="cs82D98BB6" colspan="4" style="width:199px;height:54px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Avis&nbsp;Coordonateur&nbsp;ou&nbsp;de</nobr><br/><nobr>l'.$apt.'Administrateur&nbsp;g&#233;n&#233;ral&nbsp;(nom&nbsp;et</nobr><br/><nobr>signature)</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:37px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="csE71035DC" colspan="5" style="width:216px;height:35px;line-height:15px;text-align:center;vertical-align:top;">'.$admin_fin_conge.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:214px;height:35px;line-height:15px;text-align:center;vertical-align:top;">'.$rh_conge.'</td>
                            <td class="cs82D98BB6" colspan="4" style="width:200px;height:35px;line-height:15px;text-align:center;vertical-align:top;">'.$coordinateur_conge.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs9E712815" colspan="15" style="width:634px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>IV.&nbsp;Signature&nbsp;du&nbsp;Directeur&nbsp;ou&nbsp;de&nbsp;son&nbsp;d&#233;l&#233;gu&#233;</nobr></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csC4CEB805" colspan="3" style="width:43px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>&nbsp;NB&nbsp;:</nobr></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:634px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>-&nbsp;Les&nbsp;demandes&nbsp;de&nbsp;cong&#233;s&nbsp;annuel&nbsp;de&nbsp;3&nbsp;jours&nbsp;au&nbsp;moins&nbsp;doivent&nbsp;etre&nbsp;soumises&nbsp;au&nbsp;superviseur&nbsp;et&nbsp;transmis&nbsp;au</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:633px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>d&#233;partement&nbsp;RH&nbsp;au&nbsp;moins&nbsp;une&nbsp;semaine&nbsp;avant&nbsp;de&nbsp;prendre&nbsp;le&nbsp;cong&#233;.&nbsp;Pour&nbsp;les&nbsp;demandes&nbsp;de&nbsp;cong&#233;&nbsp;de&nbsp;plus&nbsp;de&nbsp;3&nbsp;jours</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:633px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>elles&nbsp;devront&nbsp;etre&nbsp;soumises&nbsp;au&nbsp;moins&nbsp;2&nbsp;semaines&nbsp;avant&nbsp;le&nbsp;cong&#233;.</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:18px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:633px;height:18px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>-&nbsp;Ce&nbsp;formulaire&nbsp;s'.$apt.'etablit&nbsp;en&nbsp;deux&nbsp;exemplaires&nbsp;:&nbsp;un&nbsp;pour&nbsp;le&nbsp;classement&nbsp;aux&nbsp;ressources&nbsp;humaines&nbsp;et&nbsp;un&nbsp;pour&nbsp;l'.$apt.'argent.</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:633px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>-&nbsp;Pour&nbsp;le&nbsp;cong&#233;&nbsp;de&nbsp;circonstance,&nbsp;l'.$apt.'agent&nbsp;d&#233;pose&nbsp;la&nbsp;pi&#232;ce&nbsp;justificative&nbsp;&#224;&nbsp;la&nbsp;reprise&nbsp;du&nbsp;travail.</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:634px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>-&nbsp;Pour&nbsp;le&nbsp;cong&#233;&nbsp;de&nbsp;maternit&#233;,&nbsp;le&nbsp;formulaire&nbsp;doit&nbsp;etre&nbsp;accompag&#233;&nbsp;de&nbsp;l'.$apt.'attestation&nbsp;m&#233;dicale.</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:18px;"></td>
                            <td></td>
                            <td class="csC7CA2B54" colspan="14" style="width:634px;height:18px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>-&nbsp;Pour&nbsp;le&nbsp;r&#233;sum&#233;&nbsp;des&nbsp;taches,&nbsp;il&nbsp;s'.$apt.'agit&nbsp;d'.$apt.'annexer&nbsp;le&nbsp;hand&nbsp;over&nbsp;au&nbsp;verso.</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    </body>
                    </html>
                                
            '; 

    return $output;

}





//==================== RAPPORT DES PRESENCES PAR DATE =======================================

public function fetch_rapport_presence_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->printRapportPresenceDate($date1, $date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportPresenceDate($date1, $date2)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportPresence</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:975px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:99px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="13" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;www'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="11" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;PRESENCES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:29px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:199px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:148px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>SERVICE</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:117px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs58C16240" style="width:61px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs58C16240" style="width:68px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>JOUR</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:63px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" style="width:57px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Sortie</nobr></td>
                        <td class="cs58C16240" colspan="3" style="width:62px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;Time</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:67px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Statut&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:82px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Etat&nbsp;Sortie</nobr></td>
                    </tr>
                    ';
                                                                                
                                        $output .= $this->showRapportPresenceDate($date1, $date2); 
                                                                                
                                        $output.='
                </table>
                </body>
                </html>
    
        ';  
       
        return $output; 

}

function showRapportPresenceDate($date1, $date2)
{
    $current = Carbon::now();
    $heure_debut='';
    $heure_fin='';

    $data2 =  DB::table('tperso_heure_travail')       
    ->selectRaw("TIME(heure_debut) as heure_debut")
    ->selectRaw("TIME(heure_fin) as heure_fin") 
    ->get(); 
    $output='';
    foreach ($data2 as $row) 
    {  
        $heure_debut=$row->heure_debut;
        $heure_fin=$row->heure_fin;                         
    }
    $heure1 = Carbon::parse($heure_debut);
    $heure2 = Carbon::parse($heure_fin);
        $count=0;
 
        $data = DB::table('tperso_presences_agent')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
        'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
         ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
            ELSE NULL
        END as statut_entree")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie")     
        ->where([
            ['tperso_presences_agent.created_at','>=', $date1],
            ['tperso_presences_agent.created_at','<=', $date2],
            ['dateFin', '>=', $current],
            ['conge', '=', 'NON']
        ])
        ->orderBy("tperso_presences_agent.created_at", "asc")
        ->get();
        $output='';
 
        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:29px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:199px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:148px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_serv_perso.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:117px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">>'.$row->nom_lieu.'</td>
                    <td class="csD06EB5B2" style="width:61px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->jour_presence.'</nobr></td>
                    <td class="csD06EB5B2" style="width:68px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->jour_name.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:63px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_entree.'</td>
                    <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_sortie.'</td>
                    <td class="csD06EB5B2" colspan="3" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->nbr_heure.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_entree.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_sortie.'</td>
                </tr>
            ';

    }

    return $output;

}

//==================== RAPPORT DES PRESENCES PAR SERVICE =======================================

public function fetch_rapport_presence_service_date(Request $request)
{
    //refServicePerso

    if ($request->get('date1') && $request->get('date2')&& $request->get('refServicePerso')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refServicePerso = $request->get('refServicePerso');
        
        $html = $this->printRapportPresenceServiceDate($date1, $date2,$refServicePerso);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportPresenceServiceDate($date1, $date2,$refServicePerso)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportPresence</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:975px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:99px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="13" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;www'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="11" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;PRESENCES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:29px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:199px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:148px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>SERVICE</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:117px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs58C16240" style="width:61px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs58C16240" style="width:68px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>JOUR</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:63px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" style="width:57px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Sortie</nobr></td>
                        <td class="cs58C16240" colspan="3" style="width:62px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;Time</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:67px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Statut&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:82px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Etat&nbsp;Sortie</nobr></td>
                    </tr>
                    ';
                                                                                
                                        $output .= $this->showRapportPresenceServiceDate($date1, $date2,$refServicePerso); 
                                                                                
                                        $output.='
                </table>
                </body>
                </html>
    
        ';  
       
        return $output; 

}

function showRapportPresenceServiceDate($date1, $date2,$refServicePerso)
{
    $current = Carbon::now();
    $heure_debut='';
    $heure_fin='';

    $data2 =  DB::table('tperso_heure_travail')       
    ->selectRaw("TIME(heure_debut) as heure_debut")
    ->selectRaw("TIME(heure_fin) as heure_fin") 
    ->get(); 
    $output='';
    foreach ($data2 as $row) 
    {  
        $heure_debut=$row->heure_debut;
        $heure_fin=$row->heure_fin;                         
    }
    $heure1 = Carbon::parse($heure_debut);
    $heure2 = Carbon::parse($heure_fin);
        $count=0;
 
        $data = DB::table('tperso_presences_agent')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
        'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
        //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
         ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
            ELSE NULL
        END as statut_entree")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie")     
        ->where([
            ['tperso_presences_agent.created_at','>=', $date1],
            ['tperso_presences_agent.created_at','<=', $date2],
            ['refServicePerso','=', $refServicePerso],
            ['dateFin', '>=', $current],
            ['conge', '=', 'NON']
        ])
        ->orderBy("tperso_presences_agent.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:29px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:199px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:148px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_serv_perso.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:117px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">>'.$row->nom_lieu.'</td>
                    <td class="csD06EB5B2" style="width:61px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->jour_presence.'</nobr></td>
                    <td class="csD06EB5B2" style="width:68px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->jour_name.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:63px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_entree.'</td>
                    <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_sortie.'</td>
                    <td class="csD06EB5B2" colspan="3" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->nbr_heure.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_entree.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_sortie.'</td>
                </tr>
            ';

    }

    return $output;

}

//==================== RAPPORT DES PRESENCES PAR SERVICE =======================================

public function fetch_rapport_presence_lieu_date(Request $request)
{
    //refServicePerso

    if ($request->get('date1') && $request->get('date2')&& $request->get('refLieuAffectation')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refLieuAffectation = $request->get('refLieuAffectation');
        
        $html = $this->printRapportPresenceLieuDate($date1, $date2,$refLieuAffectation);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportPresenceLieuDate($date1, $date2,$refLieuAffectation)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }
 

        $output='';           

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptRapportPresence</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE93F7424 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:975px;height:285px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:99px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="9" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="13" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="13" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;www'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="13" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csE93F7424" colspan="11" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>RAPPORTS&nbsp;DES&nbsp;PRESENCES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:335px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8CFBEB27" style="width:29px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs58C16240" colspan="4" style="width:199px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:148px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>SERVICE</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:117px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>LIEU</nobr></td>
                        <td class="cs58C16240" style="width:61px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs58C16240" style="width:68px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>JOUR</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:63px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" style="width:57px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;Sortie</nobr></td>
                        <td class="cs58C16240" colspan="3" style="width:62px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;Time</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:67px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Statut&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs58C16240" colspan="2" style="width:82px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Etat&nbsp;Sortie</nobr></td>
                    </tr>
                    ';
                                                                                
                                        $output .= $this->showRapportLieuAffectationServiceDate($date1, $date2,$refLieuAffectation); 
                                                                                
                                        $output.='
                </table>
                </body>
                </html>
    
        ';  
       
        return $output; 

}

function showRapportLieuAffectationServiceDate($date1, $date2,$refLieuAffectation)
{
    $current = Carbon::now();
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);
        $count=0;
 
        $data = DB::table('tperso_presences_agent')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
        'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
        //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
         ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
            ELSE NULL
        END as statut_entree")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie")     
        ->where([
            ['tperso_presences_agent.created_at','>=', $date1],
            ['tperso_presences_agent.created_at','<=', $date2],
            ['refLieuAffectation','=', $refLieuAffectation],
            ['dateFin', '>=', $current],
            ['conge', '=', 'NON']
        ])
        ->orderBy("tperso_presences_agent.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:29px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                    <td class="csD06EB5B2" colspan="4" style="width:199px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:148px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->name_serv_perso.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:117px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">>'.$row->nom_lieu.'</td>
                    <td class="csD06EB5B2" style="width:61px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->jour_presence.'</nobr></td>
                    <td class="csD06EB5B2" style="width:68px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->jour_name.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:63px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_entree.'</td>
                    <td class="csD06EB5B2" style="width:57px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->heure_sortie.'</td>
                    <td class="csD06EB5B2" colspan="3" style="width:62px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->nbr_heure.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:67px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_entree.'</td>
                    <td class="csD06EB5B2" colspan="2" style="width:82px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">'.$row->statut_sortie.'</td>
                </tr>
            ';

    }

    return $output;

}

//=========== PAIE SALAIRE AGENT ===================================================================

function pdf_bulletin_paie_salire_agent(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->GetBulletinPaieSalaire($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function GetBulletinPaieSalaire($id)
{
           
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
            $siege='';
            $busnessName='';
            $pic='';
            $pic2 = $this->displayImg("fichier", 'logo.png');
            $logo='';
            $bp='';
    
            $data1 = DB::table('entreprises')
            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
    
            ->join('pays','pays.id','=','entreprises.idPays')
            ->join('provinces','provinces.id','=','entreprises.idProvince')
            ->join('users','users.id','=','entreprises.ceo')
            
            ->select('entreprises.id as id','entreprises.id as idEntreprise',   
                //
    
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
                'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
                'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
                'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
    
                //forme
                'forme_juridiques.nomForme','secteurs.nomSecteur',
                //users
                'users.name','users.email','users.avatar','users.telephone','users.adresse',
                //
    
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
            ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nomEntreprise;
                $adresseEse=$row->adresseEntreprise;
                $Tel1Ese=$row->telephoneEntreprise;
                $Tel2Ese=$row->telephone;
                $siteEse=$row->siteweb;
                $emailEse=$row->emailEntreprise;
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $bp=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $nbr_dependant=0;
            $noms_agent='';
            $datenaissance_agent='';
            $lieunaissnce_agent='';
            $provinceOrigine_agent='';
            $etatcivil_agent='';
            $contact_agent='';
            $mail_agent='';
            $specialite_agent='';
            $niveauEtude_agent='';
            $conjoint_agent='';
            $nomPere_agent='';
            $nomMere_agent='';
            $Nationalite_agent='';
            $Collectivite_agent='';
            $Territoire_agent='';
            $EmployeurAnt_agent='';
            $PersRef_agent='';
            $photo='';
            $nomQuartier='';
            $codeBS='';
            $created_at='';
            $nummaison_agent='';
            $nom_poste='';
            $nom_lieu='';
            $description_lieu='';
            $nom_mutuelle='';
            $code_contrat='';


            $nomAvenue='';
            $nomCommune='';
            $nomVille='';
            $nomProvince='';
            $nomPays='';
            $dateAffectation='';
            $dureecontrat='';

            $salaire_base_paie=0;
            $fammiliale_paie=0;
            $logement_paie=0;
            $transport_paie=0;
            $sal_brut_paie=0;
            $sal_brut_imposable_paie=0;
            $inss_qpo_paie=0;
            $inss_qpp_paie=0;
            $cnss_paie=0;
            $inpp_paie=0;
            $onem_paie=0;
            $ipr_paie=0;
            $name_mois='';
            $name_annee='';
            $avance_paie=0;
            $soins_paie=0;
            $jourpreste_paie=0;
            $salaire_horaire=0;
            $heure_supp1_paie=0;
            $heure_supp2_paie=0;
            $heure_supp3_paie=0;
            $assurances_paie=0;
            $netPaie=0;
            $netPaieCash=0;
            $totalRetenu=0;

            $numCNSS=0;

            $urgence="'URGENCE";
            $identi="'IDENTIFICATION";
            $enfant="'ENFANTS";
            $origine="'ORIGINE";
            $etude="'ETUDE";

            //
            $data2 = DB::table('tperso_detail_paie_salaire')            
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
            'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
            "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
            'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",'avance_paie',
            'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie',
            'assurances_paie','refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu','conjoint_agent',
            'nomMere_agent','nomPere_agent','Nationalite_agent','Collectivite_agent','Territoire_agent','EmployeurAnt_agent',
            'PersRef_agent','nomAvenue','nomQuartier','nomCommune','nomVille','nomProvince','nomPays',
            'tperso_detail_paie_salaire.created_at')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie') 
            ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')
            ->selectRaw('((inss_qpo_paie + ipr_paie)+(avance_paie)+(soins_paie)) as totalRetenu')
            ->where('tperso_detail_paie_salaire.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $datenaissance_agent=$row->datenaissance_agent;
                $lieunaissnce_agent=$row->lieunaissnce_agent;
                $provinceOrigine_agent=$row->provinceOrigine_agent;
                $etatcivil_agent=$row->etatcivil_agent;
                $contact_agent=$row->contact_agent;
                $mail_agent=$row->mail_agent;
                $specialite_agent=$row->specialite_agent;
                $niveauEtude_agent=$row->niveauEtude_agent;
                $conjoint_agent=$row->conjoint_agent;
                $nomPere_agent=$row->nomPere_agent;
                $nomMere_agent=$row->nomMere_agent;
                $Nationalite_agent=$row->Nationalite_agent;
                $Collectivite_agent=$row->Collectivite_agent;
                $Territoire_agent=$row->Territoire_agent;
                $EmployeurAnt_agent=$row->EmployeurAnt_agent;
                $PersRef_agent=$row->PersRef_agent;
                $photo= $this->displayImg("fichier", ''.$row->photo_agent.'');
                $nomAvenue=$row->nomAvenue;
                $nomQuartier=$row->nomQuartier;                
                $nomCommune=$row->nomCommune;
                $nomVille=$row->nomVille;
                $nomProvince=$row->nomProvince;
                $nomPays=$row->nomPays;
                $codeBS=$row->age_agent;
                $created_at=$row->created_at; 
                $nummaison_agent=$row->nummaison_agent;

                $nom_poste=$row->nom_poste;
                $nom_lieu=$row->nom_lieu;
                $description_lieu=$row->description_lieu;
                $nom_mutuelle=$row->nom_mutuelle;
                $code_contrat=$row->code_contrat;
                $dateAffectation=$row->dateAffectation;
                $dureecontrat=$row->dureecontrat;
                $numCNSS=$row->numCNSS;


                $salaire_base_paie=$row->salaire_base_paie;
                $fammiliale_paie=$row->fammiliale_paie;
                $logement_paie=$row->logement_paie;
                $transport_paie=$row->transport_paie;
                $sal_brut_paie=$row->sal_brut_paie;
                $sal_brut_imposable_paie=$row->sal_brut_imposable_paie;
                $inss_qpo_paie=$row->inss_qpo_paie;
                $inss_qpp_paie=$row->inss_qpp_paie;
                $cnss_paie=$row->cnss_paie;
                $inpp_paie=$row->inpp_paie;
                $onem_paie=$row->onem_paie;
                $ipr_paie=$row->ipr_paie;
                $name_mois=$row->name_mois;
                $name_annee=$row->name_annee;
                $avance_paie=$row->avance_paie;
                $soins_paie=$row->soins_paie;
                $jourpreste_paie=$row->jourpreste_paie;
                $salaire_horaire=$row->salaire_horaire;
                $heure_supp1_paie=$row->heure_supp1_paie;
                $heure_supp2_paie=$row->heure_supp2_paie;
                $heure_supp3_paie=$row->heure_supp3_paie;
                $assurances_paie=$row->assurances_paie;
                $netPaie=$row->netPaie;
                $netPaieCash=$row->netPaieCash;
                $totalRetenu=$row->totalRetenu;
                
            }   
            
            $aps="'";
    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_BulletinPaie</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csC9937B3D {color:#000000;background-color:#FFF5EE;border-left:#000000 1px double;border-top:#000000 1px double;border-right:#000000 1px double;border-bottom:#000000 1px double;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs3796D6E0 {color:#000000;background-color:#FFF5EE;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs2E83775B {color:#000000;background-color:#FFF5EE;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csC6415EE2 {color:#000000;background-color:#FFF5EE;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA15DCDCE {color:#000000;background-color:#FFF5EE;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs6773080C {color:#000000;background-color:#FFF5EE;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs60E06550 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA5530C12 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csF7F6BBD5 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs4E709669 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csCB2997A0 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA6BC666F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs9DDFB98F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs91E9AC96 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csC526B374 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csF401957C {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE1C721DA {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csD474A643 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs19997C05 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs73FFE4E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs1D279BBD {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csD4852FAF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs1698ECB3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:654px;height:979px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:25px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:56px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:77px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="13" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:70px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" style="width:88px;height:70px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:88px;height:70px;">
                        <img alt="" src="'.$pic2.'" style="width:88px;height:70px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs1698ECB3" colspan="6" style="width:187px;height:24px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>DIOCESE&nbsp;DE&nbsp;GOMA</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csD4852FAF" colspan="13" style="width:420px;height:24px;line-height:17px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="13" style="width:420px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="13" style="width:420px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs9E712815" colspan="6" style="width:199px;height:21px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>BULLETIN&nbsp;DE&nbsp;PAIE</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csE9F2AA97" colspan="3" style="width:143px;height:21px;line-height:18px;text-align:right;vertical-align:middle;"><nobr>'.$name_mois.'&nbsp;'.$name_annee.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs9E712815" colspan="14" style="width:439px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Noms&nbsp;de&nbsp;l'.$aps.'agent&nbsp;:&nbsp;'.$noms_agent.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csC6415EE2" colspan="7" rowspan="2" style="width:214px;height:18px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>BULLETIN&nbsp;DE&nbsp;PAIE</nobr></td>
                    <td class="csA15DCDCE" colspan="6" style="width:200px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csC6415EE2" colspan="6" rowspan="2" style="width:220px;height:18px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>DATE&nbsp;DE&nbsp;PAIE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="7" style="width:214px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>CARITAS&nbsp;GOMA</nobr></td>
                    <td class="csE1C721DA" colspan="6" style="width:200px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Matricule&nbsp;N&#176;&nbsp;:&nbsp;GOMA</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="7" style="width:214px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Avenue&nbsp;'.$nomAvenue.'&nbsp;N&#176;&nbsp;'.$nummaison_agent.'</nobr></td>
                    <td class="csE1C721DA" colspan="6" style="width:200px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Grade&nbsp;:&nbsp;'.$niveauEtude_agent.'</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;d'.$aps.'engagement&nbsp;:&nbsp;'.$dateAffectation.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="7" style="width:214px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$nomProvince.',&nbsp;'.$nomPays.'</nobr></td>
                    <td class="csE1C721DA" colspan="6" style="width:200px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Fonction&nbsp;:&nbsp;'.$nom_poste.'</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>INSS&nbsp;N&#176;&nbsp;:&nbsp;'.$numCNSS.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="7" style="width:214px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;lephone&nbsp;:&nbsp;'.$contact_agent.'</nobr></td>
                    <td class="csE1C721DA" colspan="6" style="width:200px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs1D279BBD" colspan="4" style="width:142px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Jours&nbsp;prest&#233;s&nbsp;:</nobr></td>
                    <td class="csA5530C12" colspan="2" style="width:73px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$jourpreste_paie.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="7" style="width:214px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>ID&nbsp;Nat&nbsp;:</nobr></td>
                    <td class="csE1C721DA" colspan="6" style="width:200px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Situation&nbsp;familliale&nbsp;:&nbsp;2 Enfants</nobr></td>
                    <td class="cs1D279BBD" colspan="4" style="width:142px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Salaire&nbsp;horaire&nbsp;:</nobr></td>
                    <td class="csA5530C12" colspan="2" style="width:73px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$salaire_horaire.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csC9937B3D" colspan="10" style="width:321px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DESIGNATION</nobr></td>
                    <td class="cs3796D6E0" colspan="3" style="width:91px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6773080C" colspan="3" style="width:97px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Q/P&nbsp;OUVRIERE</nobr></td>
                    <td class="cs3796D6E0" colspan="3" style="width:120px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Q/P&nbsp;PATRONALE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="19" style="width:642px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="5" style="width:174px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Salaire&nbsp;de&nbsp;Base&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="4" style="width:83px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$salaire_base_paie.'</nobr></td>
                    <td></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>0</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:20px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="9" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Primes&nbsp;:</nobr></td>
                    <td></td>
                    <td class="csF7F6BBD5" colspan="3" style="width:91px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="9" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Cong&#233;&nbsp;Maladie&nbsp;:</nobr></td>
                    <td></td>
                    <td class="csF7F6BBD5" colspan="3" style="width:91px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="9" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Heures&nbsp;suppl&#233;mentaire&nbsp;130%&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nbre&nbsp;d'.$aps.'hheures&nbsp;:</nobr></td>
                    <td class="cs9DDFB98F" style="width:58px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>0</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="9" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Heures&nbsp;suppl&#233;mentaire&nbsp;160%&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nbre&nbsp;d'.$aps.'heures&nbsp;:</nobr></td>
                    <td class="cs9DDFB98F" style="width:58px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>0</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="9" style="width:263px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Heures&nbsp;suppl&#233;mentaire&nbsp;200%&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nbre&nbsp;d'.$aps.'heures&nbsp;:</nobr></td>
                    <td class="cs9DDFB98F" style="width:58px;height:18px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>0</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:20px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csD474A643" colspan="10" style="width:324px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(A)&nbsp;&nbsp;TRAITEMENT&nbsp;BRUT&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$sal_brut_paie.'</nobr></td>
                    <td class="cs1D279BBD" colspan="6" style="width:221px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Cotisation&nbsp;INSS&nbsp;(QPO&nbsp;a&nbsp;5%)</nobr></td>
                    <td class="cs4E709669" colspan="3" style="width:94px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$inss_qpo_paie.'</nobr></td>
                    <td class="csF7F6BBD5" colspan="3" style="width:120px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Cotisation&nbsp;INSS&nbsp;(QPP&nbsp;a&nbsp;5%)</nobr></td>
                    <td class="csE1C721DA" colspan="3" style="width:96px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csF401957C" colspan="3" style="width:118px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$inss_qpp_paie.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Cotisation&nbsp;Assurance&nbsp;(QPP&nbsp;a&nbsp;1.5%)</nobr></td>
                    <td class="csE1C721DA" colspan="3" style="width:96px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csF401957C" colspan="3" style="width:118px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$assurances_paie.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csD474A643" colspan="13" style="width:419px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(B)&nbsp;&nbsp;TOTAL&nbsp;COTISATION&nbsp;:</nobr></td>
                    <td class="csA5530C12" colspan="3" style="width:94px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>0</nobr></td>
                    <td class="csC526B374" colspan="3" style="width:118px;height:19px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$cnss_paie.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="10" style="width:324px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Allocation&nbsp;familliale&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$fammiliale_paie.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="10" style="width:324px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Indemnit&#233;&nbsp;de&nbsp;logement&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$logement_paie.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="19" style="width:642px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="10" style="width:324px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Indemnit&#233;&nbsp;de&nbsp;transport&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$transport_paie.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="10" style="width:324px;height:20px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs91E9AC96" colspan="3" style="width:90px;height:18px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td></td>
                    <td></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:20px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csD474A643" colspan="10" style="width:324px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(C)&nbsp;&nbsp;TOTAL&nbsp;BRUT&nbsp;NON-IMPOSABLE&nbsp;:</nobr></td>
                    <td class="csA5530C12" colspan="3" style="width:89px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$sal_brut_imposable_paie.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Impots&nbsp;(IPR)&nbsp;-&nbsp;(voir&nbsp;Bareme)&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="2" style="width:90px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$ipr_paie.'</nobr></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Avance&nbsp;sur&nbsp;salaire&nbsp;(Quinzaine)&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="2" style="width:90px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$avance_paie.'</nobr></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs19997C05" colspan="13" style="width:419px;height:19px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Retenue&nbsp;soins&nbsp;m&#233;dicaux&nbsp;:</nobr></td>
                    <td class="cs4E709669" colspan="2" style="width:90px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$soins_paie.'</nobr></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csD474A643" colspan="13" style="width:419px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(D)&nbsp;&nbsp;TOTAL&nbsp;RETENUE&nbsp;:</nobr></td>
                    <td class="csA5530C12" colspan="2" style="width:90px;height:18px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>'.$totalRetenu.'</nobr></td>
                    <td class="cs1D279BBD" colspan="4" style="width:125px;height:20px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs2E83775B" colspan="19" style="width:642px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs60E06550" colspan="19" style="width:642px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SALAIRE&nbsp;NET&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USD&nbsp;'.$netPaieCash.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs3796D6E0" colspan="19" style="width:642px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csA6BC666F" colspan="9" style="width:263px;height:17px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csFFC1C457" colspan="6" style="width:250px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs73FFE4E" colspan="4" style="width:125px;height:18px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="19" style="width:642px;height:20px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Signature&nbsp;de&nbsp;l'.$aps.'employ&#233;&nbsp;(e)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Directeur&nbsp;de&nbsp;la&nbsp;Caritas</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csE1C721DA" colspan="19" style="width:642px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csA6BC666F" colspan="9" style="width:263px;height:17px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csFFC1C457" colspan="6" style="width:250px;height:19px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csB318F1BB" colspan="4" style="width:123px;height:17px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>Date&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csCB2997A0" colspan="19" style="width:643px;height:19px;line-height:17px;text-align:left;vertical-align:middle;"><nobr>Pour&nbsp;faire&nbsp;valoir&nbsp;vos&nbsp;droits,&nbsp;conservez&nbsp;ce&nbsp;bulletin&nbsp;sans&nbsp;limitation&nbsp;de&nbsp;dur&#233;e</nobr></td>
                </tr>
            </table>
            </body>
            </html>
              
            '; 

    return $output;

}  



//==================== RAPPORT DES TIMES SHEETS =======================================

public function fetch_rapport_time_sheet_date(Request $request)
{
    //refServicePerso

    if ($request->get('date1') && $request->get('date2')&& $request->get('affectation_id')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $affectation_id = $request->get('affectation_id');
        
        $html = $this->printRapportTimeSheetDate($date1, $date2,$affectation_id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();            

    } else {
        // code...
    } 
    
}

function printRapportTimeSheetDate($date1, $date2,$affectation_id)
{

         //Info Entreprise
         $nomEse='';
         $adresseEse='';
         $Tel1Ese='';
         $Tel2Ese='';
         $siteEse='';
         $emailEse='';
         $idNatEse='';
         $numImpotEse='';
         $rccEse='';
         $siege='';
         $busnessName='';
         $pic='';
         $pic2 = $this->displayImg("fichier", 'logo.png');
         $logo='';
 
         $data1 = DB::table('entreprises')
         ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
         ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
 
         ->join('pays','pays.id','=','entreprises.idPays')
         ->join('provinces','provinces.id','=','entreprises.idProvince')
         ->join('users','users.id','=','entreprises.ceo')        
         ->select('entreprises.id as id','entreprises.id as idEntreprise',
         'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
         'entreprises.emailEntreprise','entreprises.adresseEntreprise',
         'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
         'entreprises.idforme','entreprises.etat',
         'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
         'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
         'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
         'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
             //forme
             'forme_juridiques.nomForme','secteurs.nomSecteur',
             //users
             'users.name','users.email','users.avatar','users.telephone','users.adresse',
             //
             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
         ->get();
         $output='';
         foreach ($data1 as $row) 
         {                                
             $nomEse=$row->nomEntreprise;
             $adresseEse=$row->adresseEntreprise;
             $Tel1Ese=$row->telephoneEntreprise;
             $Tel2Ese=$row->telephone;
             $siteEse=$row->siteweb;
             $emailEse=$row->emailEntreprise;
             $idNatEse=$row->rccm;
             $numImpotEse=$row->rccm;
             $busnessName=$row->nomSecteur;
             $rccmEse=$row->rccm;
             $bp=$row->edition;
             $pic = $this->displayImg("fichier", 'logo.png');
             $siege=$row->nomForme;         
         }


         $aps = "'";
         $noms_agent='';
         $titre_projet='';
         $numero_contrat=$affectation_id;
         $categorie_agent='';
         //  
         $data2 =  DB::table('tperso_affectation_agent')
         ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
         ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
         ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
         ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
         ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
         ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
         ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
         ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
         ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
         ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
         "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
         "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu',
         'nom_mutuelle','description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale',
         'logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
         'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
         "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
         "adresse_org","contact_org","rccm_org", "idnat_org","etat_contrat","salaire_prevu")
         ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
         ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante') 
        //  ->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
         ->where([
            ['tperso_affectation_agent.id','=', $affectation_id]
         ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         { 
            $noms_agent=$row->noms_agent;
            $titre_projet=$row->description_projet;
            $categorie_agent=$row->name_categorie_agent;
         }



         $nombreJour=0;
         $nombreHeure=null;
         // 
         $data2 =  DB::table('tperso_timesheet') 
         ->selectRaw('SUM(TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin))) as nbrheure')
         ->selectRaw('SUM(jour_preste) as nbrJour')
         ->where([
            ['tperso_timesheet.created_at','>=', $date1],
            ['tperso_timesheet.created_at','<=', $date2],
            ['affectation_id','=', $affectation_id]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {
            $nombreJour=$row->nbrJour;
            $nombreHeure=$row->nbrheure;                        
         }
 

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptTimeSheet</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs8CFBEB27 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs97C67C72 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:15px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csBB9284F7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs5DE5F832 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csB95EBA79 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .csECF45065 {color:#0000FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:961px;height:479px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:80px;"></td>
                    <td style="height:0px;width:53px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:81px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:224px;"></td>
                    <td style="height:0px;width:124px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:55px;"></td>
                    <td style="height:0px;width:78px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:144px;height:137px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:137px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:137px;" /></div>
                    </td>
                    <td></td>
                    <td class="csA67C9637" colspan="9" style="width:621px;height:24px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:137px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:137px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:137px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="9" style="width:621px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:&nbsp;'.$adresseEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="9" style="width:621px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="9" style="width:621px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:&nbsp;'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="9" style="width:621px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="9" style="width:621px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB95EBA79" colspan="7" style="width:565px;height:23px;line-height:21px;text-align:center;vertical-align:top;"><nobr>TIMESHEET&nbsp;pour&nbsp;'.$noms_agent.'&nbsp;(titre&nbsp;de&nbsp;l'.$aps.'agent)</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs97C67C72" colspan="5" style="width:163px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Titre&nbsp;du&nbsp;projet/Programme</nobr></td>
                    <td class="cs97C67C72" colspan="7" style="width:601px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>'.$titre_projet.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs97C67C72" colspan="5" style="width:163px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Num&#233;ro&nbsp;contrat</nobr></td>
                    <td class="cs97C67C72" colspan="7" style="width:601px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>'.$numero_contrat.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs97C67C72" colspan="5" style="width:163px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;de&nbsp;l&#180;agent</nobr></td>
                    <td class="cs97C67C72" colspan="7" style="width:601px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>'.$noms_agent.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs97C67C72" colspan="5" style="width:163px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Categorie</nobr></td>
                    <td class="cs97C67C72" colspan="7" style="width:601px;height:20px;line-height:17px;text-align:left;vertical-align:top;"><nobr>'.$categorie_agent.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="3" style="width:334px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csBB9284F7" colspan="17" style="width:945px;height:20px;line-height:18px;text-align:center;vertical-align:top;"><nobr>Veuillez&nbsp;mentionner&nbsp;chaque&nbsp;jour&nbsp;travaill&#233;&nbsp;et&nbsp;chaque&nbsp;per&nbsp;diem&nbsp;facturables&nbsp;et&nbsp;noter&nbsp;toute&nbsp;information&nbsp;requise:</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:57px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs91032837" style="width:78px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="cs479D8C74" style="width:52px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Jour</nobr><br/><nobr>pr&#233;st&#233;</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:68px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Per&nbsp;Diems</nobr><br/><nobr>facturable</nobr><br/><nobr>(par&nbsp;nuit&#233;e)</nobr></td>
                    <td class="cs479D8C74" colspan="2" style="width:138px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Lieu&nbsp;de&nbsp;travail</nobr></td>
                    <td class="cs479D8C74" colspan="3" style="width:405px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Activit&#233;s&nbsp;journali&#232;res</nobr></td>
                    <td class="cs479D8C74" colspan="5" style="width:70px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;d&#233;but</nobr></td>
                    <td class="cs479D8C74" style="width:54px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Heure&nbsp;fin</nobr></td>
                    <td class="cs479D8C74" style="width:77px;height:55px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Temps&nbsp;pr&#233;st&#233;</nobr><br/><nobr>Heure&nbsp;et</nobr><br/><nobr>Munite</nobr></td>
                </tr>
                ';
                                                                                            
                        $output .= $this->showRapportTimeSheetDate($date1, $date2,$affectation_id); 
                                                                                            
                        $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs8CFBEB27" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Tot.&nbsp;Jours&nbsp;Prest&#233;s</nobr></td>
                    <td class="cs58C16240" style="width:52px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$nombreJour.'</nobr></td>
                    <td class="csBFBB3693" colspan="3" style="width:69px;height:22px;"></td>
                    <td class="csD06EB5B2" colspan="2" style="width:138px;height:22px;"></td>
                    <td class="cs58C16240" colspan="3" style="width:405px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;Heures&nbsp;Prest&#233;es</nobr></td>
                    <td class="csBFBB3693" colspan="5" style="width:71px;height:22px;"></td>
                    <td class="csD06EB5B2" style="width:54px;height:22px;"></td>
                    <td class="cs58C16240" style="width:77px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$nombreHeure.'H&nbsp;:&nbsp;00</nobr></td>
                </tr>
            </table>
            </body>
            </html>
    
        ';  
       
        return $output; 

}

function showRapportTimeSheetDate($date1, $date2,$affectation_id)
{
    $count =0;
 
        $data = DB::table('tperso_timesheet')
        ->join('users','users.id','=','tperso_timesheet.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
        'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
        'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
        'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
        'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie")     
        ->where([
            ['tperso_timesheet.created_at','>=', $date1],
            ['tperso_timesheet.created_at','<=', $date2],
            ['affectation_id','=', $affectation_id]
        ])
        ->orderBy("tperso_timesheet.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $count ++;

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:78px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->jour_presence.'</nobr></td>
                    <td class="csD06EB5B2" style="width:52px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->jour_preste.'</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:68px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->perdieme.'</nobr></td>
                    <td class="csD06EB5B2" colspan="2" style="width:138px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_lieu.'</nobr></td>
                    <td class="csD06EB5B2" colspan="3" style="width:405px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->activite.'</td>
                    <td class="csD06EB5B2" colspan="5" style="width:70px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->heure_entree.'</nobr></td>
                    <td class="csD06EB5B2" style="width:54px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->heure_sortie.'</nobr></td>
                    <td class="csD06EB5B2" style="width:77px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->nbr_heure.'</nobr></td>
                </tr>
            ';

    }

    return $output;

}



}
