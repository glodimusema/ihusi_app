<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_PersonnelController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    function pdf_bon_soin(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBonSoin($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBonSoin($id)
    {
               //Info entreprises
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
                    $idNatEse=$row->rccm;
                    $numImpotEse=$row->rccm;
                    $busnessName=$row->nomSecteur;
                    $rccmEse=$row->rccm;
                    $pic = $this->displayImg("fichier", 'logo.png');
                    $siege=$row->nomForme;         
                }
                //
                $acs="'ACCES";
                $agens="'AGENT";
                $malade=0;
                $sexe='';  
                $datenaissance=''; 
                $degreparente='';
                $medecinConsultant=''; 
                $divRH ='';
                $AG='';
                $dateDemande='';
                $noms_agent='';
                $codeBS='';
                $created_at='';
                //
                $data2 = DB::table('tperso_demande_soin')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
                ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
                "divRH","AG","dateDemande","refAffectation",
                
                "dateAffectation","codeAgent","numCNSS","numcpteBanque",
                "numImpot","BanqueAgant","autresDetail",
                "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
                "noms_agent","sexe_agent","datenaissance_agent","tperso_demande_soin.created_at",
                "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
                "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
                "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
                "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
                ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
                ->selectRaw('CONCAT(tperso_demande_soin.id,"/ND-DRH/",YEAR(tperso_demande_soin.created_at)) as codeBS')
                ->where('tperso_demande_soin.id','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {
                    $malade=$row->malade;
                    $sexe=$row->sexe;  
                    $datenaissance=$row->datenaissance; 
                    $noms_agent=$row->noms_agent;
                    $degreparente=$row->degreparente;
                    $medecinConsultant=$row->medecinConsultant; 
                    $divRH =$row->divRH;
                    $AG=$row->AG;
                    $dateDemande=$row->dateDemande;
                    $created_at=$row->created_at;
                    $codeBS=$row->codeBS;                                    
                }        
        
                $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>BON DE DEMANDE DE SOIN</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:518px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:137px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:195px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:95px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:488px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:7px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="8" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$emailEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="8" style="width:488px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:7px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs188E5F6F" colspan="15" style="width:694px;height:33px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>BON&nbsp;D'.$acs.'&nbsp;AUX&nbsp;SOINS&nbsp;N&#176;'.$codeBS.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:137px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:34px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:202px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:44px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:70px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:50px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:95px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:24px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:142px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;DU&nbsp;MALADE&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="5" style="width:251px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$malade.'</td>
                        <td class="csCE72709D" style="width:42px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AGE&nbsp;:</nobr></td>
                        <td class="cs76421F2" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$datenaissance.'&nbsp;ans</nobr></td>
                        <td class="csCE72709D" style="width:48px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>SEXE&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="2" style="width:117px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$sexe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:137px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:202px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:70px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:50px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:10px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;DE&nbsp;L'.$agens.'&nbsp;CIMAK&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="8" style="width:483px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:137px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:202px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:70px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:50px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="3" style="width:149px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DEGRE&nbsp;DE&nbsp;PARENTE&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="10" style="width:527px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$degreparente.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:137px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:202px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:70px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:50px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="4" style="width:183px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>MEDECIN&nbsp;A&nbsp;CONSULTER&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="9" style="width:493px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$medecinConsultant.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:137px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:202px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:70px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:50px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:14px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs38AECAED" colspan="11" style="width:645px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>(A&nbsp;RETOURNER&nbsp;SVP&nbsp;APRES&nbsp;TRAITEMENT&nbsp;AU&nbsp;CDRH&nbsp;AVEC&nbsp;LES&nbsp;DETAILS&nbsp;CHIFFRES&nbsp;DU&nbsp;SERVICE)</nobr></td>
                        <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:137px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:34px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:13px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:202px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:44px;height:13px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:70px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:50px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:95px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:24px;height:13px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:13px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="13" style="width:680px;height:7px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs612ED82F" colspan="13" style="width:678px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>APPROBATION&nbsp;CHEF&nbsp;DIVRH.&nbsp;-NOMS&nbsp;:&nbsp;'.$divRH.'....SIGN&nbsp;:&nbsp;.............................DATE&nbsp;:&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="13" style="width:680px;height:32px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs612ED82F" colspan="13" style="width:678px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>APPROBATION&nbsp;AG.&nbsp;-NOMS&nbsp;:&nbsp;'.$AG.'....SIGN&nbsp;:&nbsp;...............................DATE&nbsp;:&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="13" style="width:680px;height:7px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
                    </tr>
                </table>
                </body>
                </html>                
                '; 

        return $output;

    }   



    //=============== DEMANDE DE SORTIE AGENT ==============================================================================================
    //======================================================================================================================================



    function pdf_bon_sortie_agent(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBonSortieAgent($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBonSortieAgent($id)
    {
               //Info entreprises
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
                    $idNatEse=$row->rccm;
                    $numImpotEse=$row->rccm;
                    $busnessName=$row->nomSecteur;
                    $rccmEse=$row->rccm;
                    $pic = $this->displayImg("fichier", 'logo.png');
                    $siege=$row->nomForme;         
                }
                //
                $emp="'employ";
                $agences="'ABSENCE";
                $he="'heure";
                $abse="'abasences";

                $noms_agent='';
                $fonction_agent='';
                $codeAgent='';
                $name_serv_perso='';
                $heureSortie='';
                $heureRetourPrevue='';
                $dateSortie='';
                $motif='';
                $heureRetour='';
                $dateRetour='';
                $libelleannexe='';
                $viseBRH='';
                $codeBS='';
                $created_at='';
                //
                $data2 = DB::table('tperso_sortie_agent')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
                ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
                "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
                "refAffectation","tperso_sortie_agent.author","tperso_sortie_agent.created_at",
                "dateAffectation","codeAgent","numCNSS","numcpteBanque",
                "numImpot","BanqueAgant","autresDetail",
                "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
                "noms_agent","sexe_agent","datenaissance_agent",
                "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
                "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
                "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
                "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
                ->selectRaw('CONCAT(tperso_sortie_agent.id,"/ND-DRH/",YEAR(tperso_sortie_agent.created_at)) as codeBS')
                ->where('tperso_sortie_agent.id','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {
                    $noms_agent=$row->noms_agent;
                    $fonction_agent=$row->fonction_agent;
                    $codeAgent=$row->codeAgent;
                    $name_serv_perso=$row->name_serv_perso;
                    $heureSortie=$row->heureSortie;
                    $heureRetourPrevue=$row->heureRetourPrevue;
                    $dateSortie=$row->dateSortie;
                    $motif=$row->motif;
                    $created_at=$row->created_at;
                    $heureRetour=$row->heureRetour;
                    $dateRetour=$row->dateRetour;
                    $libelleannexe=$row->libelleannexe;
                    $viseBRH=$row->viseBRH;
                    
                    $codeBS=$row->codeBS;                                    
                }        
        
                $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>BON DE SORTIE AGENT</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs6884C9DB {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Mongolian Baiti; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs3DDAFCA2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:554px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:74px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:45px;"></td>
                        <td style="height:0px;width:160px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:64px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:83px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="7" style="width:488px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:7px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="7" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="7" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="7" style="width:488px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:7px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs3DDAFCA2" colspan="14" style="width:694px;height:33px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;D'.$agences.'&nbsp;POUR&nbsp;AGENT&nbsp;PENDANT&nbsp;LES&nbsp;HEURES&nbsp;DE&nbsp;TRAVAIL</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:81px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:51px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:53px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:45px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:201px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:80px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:37px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:49px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:83px;height:7px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:183px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>1.&nbsp;Nom&nbsp;et&nbsp;Pr&#233;nom&nbsp;de&nbsp;l'.$emp.'&#233;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="8" style="width:493px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:79px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>2.&nbsp;Fonction&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="5" style="width:348px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                        <td class="cs12FE94AA" colspan="2" style="width:78px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>3.&nbsp;Division&nbsp;/&nbsp;Service&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>4.&nbsp;Dur&#233;e&nbsp;de&nbsp;sortie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>de&nbsp;'.$heureSortie.'&nbsp;&#224;&nbsp;&nbsp;'.$heureRetourPrevue.'&nbsp;&nbsp;le&nbsp;&nbsp;'.$dateSortie.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>5.&nbsp;Motif de sortie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$motif.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:130px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>6.&nbsp;L'.$he.'&nbsp;de&nbsp;retour&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$heureRetour.'&nbsp;&nbsp;&nbsp;le&nbsp;&nbsp;&nbsp;'.$dateRetour.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:81px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:51px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:45px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:201px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:80px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:83px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>L'.$emp.'&#233;&nbsp;(date&nbsp;et&nbsp;signature)&nbsp;:&nbsp;&nbsp;ASIFIWE&nbsp;CHIZA&nbsp;JEAN</nobr></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:83px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:546px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Visa&nbsp;du&nbsp;sup&#233;rieur&nbsp;(date&nbsp;et&nbsp;signature)&nbsp;:&nbsp;&nbsp;ASIFIWE&nbsp;CHIZA&nbsp;JEAN</nobr></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:83px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:228px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>(A&nbsp;retourner&nbsp;au&nbsp;DRH&nbsp;dument&nbsp;rempli)</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:201px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:83px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs612ED82F" colspan="11" style="width:595px;height:23px;line-height:13px;text-align:left;vertical-align:middle;">SI&nbsp;NECESSAIRE&nbsp;ANNEXE&nbsp;JUSTICATIF&nbsp;:&nbsp;CARNET&nbsp;MEDICAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;visa&nbsp;DRH&nbsp;:&nbsp;'.$libelleannexe.'</td>
                        <td class="cs101A94F7" style="width:83px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:81px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:51px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:45px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:201px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:80px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:83px;height:20px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:49px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:49px;"></td>
                        <td class="cs6884C9DB" colspan="12" style="width:678px;height:49px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NB&nbsp;:&nbsp;Ce&nbsp;document&nbsp;est&nbsp;&#224;&nbsp;ajouter&nbsp;au&nbsp;dossier&nbsp;individuel&nbsp;de&nbsp;l'.$emp.'&#233;&nbsp;et&nbsp;sommer&nbsp;les&nbsp;heures&nbsp;par&nbsp;mois&nbsp;qui&nbsp;seront&nbsp;d&#233;duites&nbsp;des</nobr><br/><nobr>cong&#233;s&nbsp;&#224;&nbsp;partir&nbsp;de&nbsp;08h&nbsp;heures&nbsp;d'.$abse.'&nbsp;pour&nbsp;raison&nbsp;autre&nbsp;que&nbsp;maladie&nbsp;et&nbsp;service.</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:49px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:81px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:51px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:53px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:45px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:201px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:80px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:37px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:49px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:83px;height:8px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:8px;"></td>
                    </tr>
                </table>
                </body>
                </html>                '; 

        return $output;

    }   




        //=============== APPRECIATION AGENT ==============================================================================================
    //======================================================================================================================================



    function pdf_fiche_appreciation_agent(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoAppreciationAgent($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoAppreciationAgent($id)
    {
               //Info entreprises
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
                    $idNatEse=$row->rccm;
                    $numImpotEse=$row->rccm;
                    $busnessName=$row->nomSecteur;
                    $rccmEse=$row->rccm;
                    $pic = $this->displayImg("fichier", 'logo.png');
                    $siege=$row->nomForme;         
                }
                //
                $emp="'employ";
                $agences="'ABSENCE";
                $he="'heure";
                $abse="'abasences";

                $noms_agent='';
                $fonction_agent='';
                $codeAgent='';
                $name_serv_perso='';
                $periodeDu=0;
                $connaissanceTheorique=0;
                $appliDeontologie=0;
                $manipulation=0;
                $prendConsideration=0;
                $ponctualite=0;
                $ordre=0;
                $fiabilite=0;
                $espritEquipe=0;
                $courtoisie=0;
                $sensResponsabilite=0;
                $sensEcoute=0;
                $preparationExecution=0;
                $organiseTravail=0;
                $dateAppreciation='';
                $agent='';
                $suiveur='';
                $hierarchie='';
                $rh='';
                $refAffectation='';
                $Propositions='';
                $codeBS='';
                $annnee='';
                $TotalPoints=0;
                $Mension='';
                $apress="'APPRECIATION";
                $exts="'ex";
                $ests="'&#233";
                $ests2="'&#233";
                $ests3="'am";
                $ests4="'Agent";
                //
                $data2 = DB::table('tperso_appreciation_agent')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
                ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
                "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
                "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail",
                "dateAppreciation","agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
                "dateAffectation","codeAgent","numCNSS","numcpteBanque",
                "numImpot","BanqueAgant","autresDetail",
                "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
                "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
                "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
                "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
                "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
                ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
                ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
                ->selectRaw("(
                    CASE 
                    WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
                    WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
                    WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
                    WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
                    WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
                END 
                ) as Mension")
                ->selectRaw('CONCAT("F",YEAR(tperso_appreciation_agent.created_at),"",MONTH(tperso_appreciation_agent.created_at),"00",tperso_appreciation_agent.id) as codeBS')
                ->selectRaw('CONCAT("",YEAR(tperso_appreciation_agent.created_at)) as annnee')
                ->where('tperso_appreciation_agent.id','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {
                    $noms_agent=$row->noms_agent;
                    $fonction_agent=$row->fonction_agent;
                    $codeAgent=$row->codeAgent;
                    $name_serv_perso=$row->name_serv_perso;
                    $periodeDu=$row->periodeDu;
                    $connaissanceTheorique=$row->connaissanceTheorique;
                    $appliDeontologie=$row->appliDeontologie;
                    $manipulation=$row->manipulation;
                    $prendConsideration=$row->prendConsideration;
                    $ponctualite=$row->ponctualite;
                    $ordre=$row->ordre;
                    $fiabilite=$row->fiabilite;
                    $espritEquipe=$row->espritEquipe;
                    $courtoisie=$row->courtoisie;
                    $sensResponsabilite=$row->sensResponsabilite;
                    $sensEcoute=$row->sensEcoute;
                    $preparationExecution=$row->preparationExecution;
                    $organiseTravail=$row->organiseTravail;
                    $dateAppreciation=$row->dateAppreciation;
                    $agent=$row->agent;
                    $suiveur=$row->suiveur;
                    $hierarchie=$row->hierarchie;
                    $rh=$row->rh;
                    $Propositions=$row->Propositions;                        
                    $codeBS=$row->codeBS; 
                    $TotalPoints=$row->TotalPoints;
                    $Mension=$row->Mension;                                   
                }        
        
                $output=' 

                            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>APPRECIATION AGENT</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csC059F427 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs7E1F66F0 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csDFEBE560 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs5B96C881 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csF446582 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:944px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:7px;"></td>
                <td style="height:0px;width:46px;"></td>
                <td style="height:0px;width:16px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:57px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:38px;"></td>
                <td style="height:0px;width:24px;"></td>
                <td style="height:0px;width:132px;"></td>
                <td style="height:0px;width:27px;"></td>
                <td style="height:0px;width:15px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:35px;"></td>
                <td style="height:0px;width:16px;"></td>
                <td style="height:0px;width:8px;"></td>
                <td style="height:0px;width:156px;"></td>
                <td style="height:0px;width:5px;"></td>
                <td style="height:0px;width:9px;"></td>
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
                <td class="csD24A75E0" colspan="2" style="width:13px;height:7px;"></td>
                <td class="csDDFA3242" colspan="12" style="width:488px;height:7px;"></td>
                <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:169px;height:7px;"></td>
                <td class="cs62ED362D" style="width:6px;height:7px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:23px;"></td>
                <td class="csFBB219FE" colspan="12" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                    <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                </td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                <td class="cs612ED82F" colspan="12" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:10px;"></td>
                <td></td>
                <td class="cs593B729A" colspan="2" style="width:13px;height:7px;"></td>
                <td class="csE7D235EF" colspan="12" style="width:488px;height:7px;"></td>
                <td class="csE7D235EF" style="width:16px;height:7px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:169px;height:7px;"></td>
                <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td class="cs188E5F6F" colspan="19" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>FEUILLE&nbsp;D'.$apress.'&nbsp;&nbsp;'.$annnee.'</nobr></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:10px;"></td>
                <td></td>
                <td class="csD24A75E0" style="width:6px;height:7px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:53px;height:7px;"></td>
                <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                <td class="csDDFA3242" style="width:33px;height:7px;"></td>
                <td class="csDDFA3242" style="width:57px;height:7px;"></td>
                <td class="csDDFA3242" style="width:10px;height:7px;"></td>
                <td class="csDDFA3242" style="width:38px;height:7px;"></td>
                <td class="csDDFA3242" style="width:24px;height:7px;"></td>
                <td class="csDDFA3242" style="width:132px;height:7px;"></td>
                <td class="csDDFA3242" colspan="2" style="width:42px;height:7px;"></td>
                <td class="csDDFA3242" style="width:55px;height:7px;"></td>
                <td class="csDDFA3242" colspan="3" style="width:59px;height:7px;"></td>
                <td class="csDDFA3242" style="width:156px;height:7px;"></td>
                <td class="csDDFA3242" style="width:5px;height:7px;"></td>
                <td class="cs62ED362D" style="width:6px;height:7px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="11" style="width:403px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>I.&nbsp;&nbsp;IDENTFICATION&nbsp;DU&nbsp;COLLABORATIEUR(TRICE)</nobr></td>
                <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:22px;"></td>
                <td class="cs101A94F7" style="width:156px;height:22px;"></td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="2" style="width:51px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                <td class="csDFEBE560" colspan="15" style="width:625px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="3" style="width:67px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>SERVICE&nbsp;:</nobr></td>
                <td class="csDFEBE560" colspan="14" style="width:609px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="4" style="width:100px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>PERDIODE&nbsp;DU&nbsp;:</nobr></td>
                <td class="csDFEBE560" colspan="13" style="width:576px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$periodeDu.'</td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="11" style="width:403px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>II.&nbsp;&nbsp;APPRECIATION</nobr></td>
                <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:22px;"></td>
                <td class="cs101A94F7" style="width:156px;height:22px;"></td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="7" style="width:205px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>1.&nbsp;EXERCUTION&nbsp;DU&nbsp;TRAVAIL</nobr></td>
                <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                <td class="cs101A94F7" style="width:132px;height:22px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:22px;"></td>
                <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:22px;"></td>
                <td class="cs101A94F7" style="width:156px;height:22px;"></td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>a)&nbsp;Connaissances&nbsp;th&#233;oriques&nbsp;et&nbsp;techniques&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:.........................................................................................................'.$connaissanceTheorique.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:23px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:23px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>b)&nbsp;Application&nbsp;de&nbsp;la&nbsp;d&#233;ontologie&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:.........................................................................................................'.$appliDeontologie.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>c)&nbsp;Manipulation&nbsp;/Ex&#233;cution&nbsp;/Traitement&nbsp;des&nbsp;taches&nbsp;:...........................................................................................................'.$manipulation.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>d)&nbsp;Prend&nbsp;en&nbsp;consid&#233;ration&nbsp;les&nbsp;remarques&nbsp;des&nbsp;autres&nbsp;:...........................................................................................................'.$prendConsideration.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="7" style="width:205px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>2.&nbsp;QUALITES&nbsp;PERSONNELLES</nobr></td>
                <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                <td class="cs101A94F7" style="width:132px;height:22px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:22px;"></td>
                <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:22px;"></td>
                <td class="cs101A94F7" style="width:156px;height:22px;"></td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>a)&nbsp;Ponctualit&#233;&nbsp;et&nbsp;pr&#233;sence&nbsp;sur&nbsp;le&nbsp;lieu&nbsp;du&nbsp;travail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:..........................................................................................................'.$ponctualite.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>b)&nbsp;Ordre&nbsp;et&nbsp;propret&#233;&nbsp;dans&nbsp;l'.$exts.'&#233;cution&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:..........................................................................................................'.$ordre.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>c)&nbsp;Fiabilit&#233;,&nbsp;confiance&nbsp;et&nbsp;esprit&nbsp;de&nbsp;sacrifice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:..........................................................................................................'.$fiabilite.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>d)&nbsp;Esprit&nbsp;d'.$ests2.';quipe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:..........................................................................................................'.$espritEquipe.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>e)&nbsp;Courtoisie&nbsp;et&nbsp;respect&nbsp;des&nbsp;autres&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:...........................................................................................................'.$courtoisie.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>f)&nbsp;Sens&nbsp;de&nbsp;responsabilit&#233;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:...........................................................................................................'.$sensResponsabilite.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>g)&nbsp;Sens&nbsp;d'.$ests2.';coute&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:...........................................................................................................'.$sensEcoute.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="8" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>3.&nbsp;QUALITES&nbsp;INTELLECTUELLES</nobr></td>
                <td class="cs101A94F7" style="width:132px;height:22px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:22px;"></td>
                <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:22px;"></td>
                <td class="cs101A94F7" style="width:156px;height:22px;"></td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:23px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:23px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>a)&nbsp;Pr&#233;paration&nbsp;avant&nbsp;ex&#233;cution&nbsp;du&nbsp;travail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:...........................................................................................................'.$preparationExecution.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="cs5B96C881" colspan="17" style="width:678px;height:22px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>b)&nbsp;Organise&nbsp;son&nbsp;travail&nbsp;de&nbsp;fa&#231;on&nbsp;rigoureuse&nbsp;et&nbsp;g&#232;re&nbsp;son&nbsp;temps&nbsp;convenablement&nbsp;:............................................................'.$organiseTravail.'/10</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csCE72709D" colspan="17" style="width:678px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>4.&nbsp;Quels&nbsp;axes&nbsp;d'.$ests3.'&#233;lioration&nbsp;pouvez-vous&nbsp;proposer&nbsp;au&nbsp;Collaborateur&nbsp;/&nbsp;Collaboratrice&nbsp;?</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:40px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:40px;"></td>
                <td class="csF446582" colspan="17" style="width:678px;height:40px;line-height:11px;text-align:left;vertical-align:middle;">'.$Propositions.'</td>
                <td class="cs145AAE8A" style="width:6px;height:40px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:53px;height:23px;"></td>
                <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                <td class="cs101A94F7" style="width:33px;height:23px;"></td>
                <td class="cs101A94F7" style="width:57px;height:23px;"></td>
                <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                <td class="cs101A94F7" style="width:38px;height:23px;"></td>
                <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                <td class="cs101A94F7" style="width:132px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:23px;"></td>
                <td class="cs101A94F7" style="width:55px;height:23px;"></td>
                <td class="cs7E1F66F0" colspan="5" style="width:210px;height:17px;line-height:15px;text-align:right;vertical-align:top;"><nobr>Total&nbsp;des&nbsp;points&nbsp;sur&nbsp;:&nbsp;&nbsp;'.$TotalPoints.'&nbsp;&nbsp;/100</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:53px;height:23px;"></td>
                <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                <td class="cs101A94F7" style="width:33px;height:23px;"></td>
                <td class="cs101A94F7" style="width:57px;height:23px;"></td>
                <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                <td class="cs101A94F7" style="width:38px;height:23px;"></td>
                <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                <td class="cs101A94F7" style="width:132px;height:23px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:23px;"></td>
                <td class="cs101A94F7" style="width:55px;height:23px;"></td>
                <td class="cs7E1F66F0" colspan="5" style="width:210px;height:17px;line-height:15px;text-align:right;vertical-align:top;">Observation&nbsp;:&nbsp;'.$Mension.'</td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:53px;height:24px;"></td>
                <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                <td class="cs101A94F7" style="width:33px;height:24px;"></td>
                <td class="cs101A94F7" style="width:57px;height:24px;"></td>
                <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                <td class="cs101A94F7" style="width:38px;height:24px;"></td>
                <td class="cs101A94F7" style="width:24px;height:24px;"></td>
                <td class="cs101A94F7" style="width:132px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:24px;"></td>
                <td class="cs101A94F7" style="width:55px;height:24px;"></td>
                <td class="cs7E1F66F0" colspan="5" style="width:210px;height:18px;line-height:15px;text-align:right;vertical-align:top;"><nobr>Date&nbsp;:&nbsp;'.$dateAppreciation.'</nobr></td>
                <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:23px;"></td>
                <td class="cs7658BE13" colspan="5" style="width:151px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;et&nbsp;signature(Agent)</nobr></td>
                <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                <td class="cs7658BE13" colspan="3" rowspan="2" style="width:186px;height:32px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;et&nbsp;signature&nbsp;de&nbsp;personne</nobr><br/><nobr>qui&nbsp;a&nbsp;r&#233;guli&#232;rement&nbsp;suivi&nbsp;l'.$ests4.'</nobr></td>
                <td class="cs7658BE13" colspan="6" style="width:148px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Chef&nbsp;HIERARCHIQUE</nobr></td>
                <td class="cs7658BE13" style="width:148px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Ressources&nbsp;Humaines</nobr></td>
                <td class="cs101A94F7" style="width:5px;height:23px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:15px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:15px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:53px;height:15px;"></td>
                <td class="cs101A94F7" style="width:16px;height:15px;"></td>
                <td class="cs101A94F7" style="width:33px;height:15px;"></td>
                <td class="cs101A94F7" style="width:57px;height:15px;"></td>
                <td class="cs101A94F7" style="width:10px;height:15px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:15px;"></td>
                <td class="cs101A94F7" style="width:55px;height:15px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:15px;"></td>
                <td class="cs101A94F7" style="width:156px;height:15px;"></td>
                <td class="cs101A94F7" style="width:5px;height:15px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:15px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:33px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:33px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:53px;height:33px;"></td>
                <td class="cs101A94F7" style="width:16px;height:33px;"></td>
                <td class="cs101A94F7" style="width:33px;height:33px;"></td>
                <td class="cs101A94F7" style="width:57px;height:33px;"></td>
                <td class="cs101A94F7" style="width:10px;height:33px;"></td>
                <td class="cs101A94F7" style="width:38px;height:33px;"></td>
                <td class="cs101A94F7" style="width:24px;height:33px;"></td>
                <td class="cs101A94F7" style="width:132px;height:33px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:42px;height:33px;"></td>
                <td class="cs101A94F7" style="width:55px;height:33px;"></td>
                <td class="cs101A94F7" colspan="3" style="width:59px;height:33px;"></td>
                <td class="cs101A94F7" style="width:156px;height:33px;"></td>
                <td class="cs101A94F7" style="width:5px;height:33px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:33px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:6px;height:22px;"></td>
                <td class="csC059F427" colspan="5" style="width:151px;height:16px;line-height:11px;text-align:left;vertical-align:top;">'.$agent.'</td>
                <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                <td class="csC059F427" colspan="3" style="width:186px;height:16px;line-height:11px;text-align:left;vertical-align:top;">'.$suiveur.'</td>
                <td class="csC059F427" colspan="6" style="width:148px;height:16px;line-height:11px;text-align:left;vertical-align:top;">'.$hierarchie.'</td>
                <td class="csC059F427" style="width:148px;height:16px;line-height:11px;text-align:left;vertical-align:top;">'.$rh.'</td>
                <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs593B729A" style="width:6px;height:8px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:53px;height:8px;"></td>
                <td class="csE7D235EF" style="width:16px;height:8px;"></td>
                <td class="csE7D235EF" style="width:33px;height:8px;"></td>
                <td class="csE7D235EF" style="width:57px;height:8px;"></td>
                <td class="csE7D235EF" style="width:10px;height:8px;"></td>
                <td class="csE7D235EF" style="width:38px;height:8px;"></td>
                <td class="csE7D235EF" style="width:24px;height:8px;"></td>
                <td class="csE7D235EF" style="width:132px;height:8px;"></td>
                <td class="csE7D235EF" colspan="2" style="width:42px;height:8px;"></td>
                <td class="csE7D235EF" style="width:55px;height:8px;"></td>
                <td class="csE7D235EF" colspan="3" style="width:59px;height:8px;"></td>
                <td class="csE7D235EF" style="width:156px;height:8px;"></td>
                <td class="csE7D235EF" style="width:5px;height:8px;"></td>
                <td class="cs11B2FA6F" style="width:6px;height:8px;"></td>
            </tr>
        </table>
        </body>
        </html>

                        '; 

        return $output;

    }   


//======================= CONGE ANNUEL=====================================================================================
//=========================================================================================================================

function pdf_conge_annuel(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoCongeAnnuel($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoCongeAnnuel($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $dateJourAbsent='';
            $dateDernierJour='';
            $dateRetour='';
            $nombreJour='';
            $controle=0;
            $ResteJour=0;
            $autresDetail='';
            $codeBS='';
            $agent='';
            $remplacement='';
            $chefService='';
            $hierarchie='';
            $created_at='';

            $abs1="'ABSENCES";
            $abs2="'AGENT";
            $abs3="'AVANCE";
            $abs4="'EXCEPTION";
            $abs5="'URGENCE";
            //
            $data2 = DB::table('tperso_conge_annuel')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_conge_annuel.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_conge_annuel.id","tperso_conge_annuel.autresDetail","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_conge_annuel.author","refAnne","refEnteteConge",
            "dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour","tperso_conge_annuel.created_at",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour) as nombreJour')  
            ->selectRaw('((controle)-(TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour))) as ResteJour') 
            ->selectRaw('CONCAT("F",YEAR(tperso_conge_annuel.created_at),"",MONTH(tperso_conge_annuel.created_at),"00",tperso_conge_annuel.id) as codeBS')
            ->selectRaw('CONCAT("",YEAR(tperso_conge_annuel.created_at)) as annnee')
            ->where('tperso_conge_annuel.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $fonction_agent=$row->fonction_agent;
                $dateJourAbsent=$row->dateJourAbsent;
                $dateDernierJour=$row->dateDernierJour;
                $dateRetour=$row->dateRetour;
                $nombreJour=$row->nombreJour;
                $controle=$row->controle;
                $ResteJour=$row->ResteJour;
                $autresDetail=$row->autresDetail;
                $created_at=$row->created_at;
                $codeBS=$row->codeBS;                                  
            }        
    
            $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <!-- saved from url=(0016)http://localhost -->
    <html>
    <head>
        <title>CONGE ANNUEL</title>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
        <style type="text/css">
            .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csAA0003C9 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
            .csF35B754C {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs279C008 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;}
            .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
            .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
            .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
            .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
            .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
            .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
            .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
            .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
            .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
        </style>
    </head>
    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:881px;position:relative;">
        <tr>
            <td style="width:0px;height:0px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:4px;"></td>
            <td style="height:0px;width:3px;"></td>
            <td style="height:0px;width:9px;"></td>
            <td style="height:0px;width:44px;"></td>
            <td style="height:0px;width:5px;"></td>
            <td style="height:0px;width:24px;"></td>
            <td style="height:0px;width:26px;"></td>
            <td style="height:0px;width:16px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:108px;"></td>
            <td style="height:0px;width:38px;"></td>
            <td style="height:0px;width:13px;"></td>
            <td style="height:0px;width:28px;"></td>
            <td style="height:0px;width:4px;"></td>
            <td style="height:0px;width:30px;"></td>
            <td style="height:0px;width:14px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:27px;"></td>
            <td style="height:0px;width:4px;"></td>
            <td style="height:0px;width:13px;"></td>
            <td style="height:0px;width:11px;"></td>
            <td style="height:0px;width:10px;"></td>
            <td style="height:0px;width:22px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:3px;"></td>
            <td style="height:0px;width:18px;"></td>
            <td style="height:0px;width:12px;"></td>
            <td style="height:0px;width:14px;"></td>
            <td style="height:0px;width:12px;"></td>
            <td style="height:0px;width:4px;"></td>
            <td style="height:0px;width:59px;"></td>
            <td style="height:0px;width:11px;"></td>
            <td style="height:0px;width:34px;"></td>
            <td style="height:0px;width:59px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:1px;"></td>
            <td style="height:0px;width:3px;"></td>
            <td style="height:0px;width:9px;"></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
            <td style="width:0px;height:9px;"></td>
            <td></td>
            <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
            <td class="csDDFA3242" colspan="26" style="width:488px;height:6px;"></td>
            <td class="csDDFA3242" colspan="2" style="width:16px;height:6px;"></td>
            <td class="csDDFA3242" colspan="8" style="width:169px;height:6px;"></td>
            <td class="cs62ED362D" style="width:6px;height:6px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
            <td class="csFBB219FE" colspan="26" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
            <td class="csE314B2A3" colspan="8" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
            </td>
            <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
            <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
            <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
            <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
            <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
            <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:21px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
            <td class="cs612ED82F" colspan="26" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:21px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:1px;"></td>
            <td></td>
            <td class="csBDA79072" colspan="3" style="width:13px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
            <td class="cs101A94F7" colspan="8" style="width:169px;height:1px;"></td>
            <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:9px;"></td>
            <td></td>
            <td class="cs593B729A" colspan="3" style="width:13px;height:6px;"></td>
            <td class="csE7D235EF" colspan="26" style="width:488px;height:6px;"></td>
            <td class="csE7D235EF" colspan="2" style="width:16px;height:6px;"></td>
            <td class="csE7D235EF" colspan="8" style="width:169px;height:6px;"></td>
            <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
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
            <td style="width:0px;height:32px;"></td>
            <td></td>
            <td class="cs188E5F6F" colspan="40" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>COMMUNICATION&nbsp;D'.$abs1.'</nobr></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:10px;"></td>
            <td></td>
            <td class="csD24A75E0" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:3px;height:7px;"></td>
            <td class="csDDFA3242" colspan="2" style="width:53px;height:7px;"></td>
            <td class="csDDFA3242" style="width:5px;height:7px;"></td>
            <td class="csDDFA3242" style="width:24px;height:7px;"></td>
            <td class="csDDFA3242" style="width:26px;height:7px;"></td>
            <td class="csDDFA3242" style="width:16px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:108px;height:7px;"></td>
            <td class="csDDFA3242" style="width:38px;height:7px;"></td>
            <td class="csDDFA3242" style="width:13px;height:7px;"></td>
            <td class="csDDFA3242" style="width:28px;height:7px;"></td>
            <td class="csDDFA3242" style="width:4px;height:7px;"></td>
            <td class="csDDFA3242" style="width:30px;height:7px;"></td>
            <td class="csDDFA3242" style="width:14px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:27px;height:7px;"></td>
            <td class="csDDFA3242" colspan="2" style="width:17px;height:7px;"></td>
            <td class="csDDFA3242" style="width:11px;height:7px;"></td>
            <td class="csDDFA3242" style="width:10px;height:7px;"></td>
            <td class="csDDFA3242" style="width:22px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:3px;height:7px;"></td>
            <td class="csDDFA3242" style="width:18px;height:7px;"></td>
            <td class="csDDFA3242" style="width:12px;height:7px;"></td>
            <td class="csDDFA3242" colspan="2" style="width:26px;height:7px;"></td>
            <td class="csDDFA3242" colspan="2" style="width:63px;height:7px;"></td>
            <td class="csDDFA3242" style="width:11px;height:7px;"></td>
            <td class="csDDFA3242" style="width:34px;height:7px;"></td>
            <td class="csDDFA3242" style="width:59px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="csDDFA3242" style="width:1px;height:7px;"></td>
            <td class="cs62ED362D" colspan="2" style="width:9px;height:7px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs12FE94AA" colspan="2" style="width:51px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
            <td class="csCE72709D" colspan="14" style="width:333px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
            <td class="cs12FE94AA" colspan="9" style="width:81px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
            <td class="csCE72709D" colspan="11" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:16px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:3px;height:16px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:16px;"></td>
            <td class="cs101A94F7" style="width:5px;height:16px;"></td>
            <td class="cs101A94F7" style="width:24px;height:16px;"></td>
            <td class="cs101A94F7" style="width:26px;height:16px;"></td>
            <td class="cs101A94F7" style="width:16px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:108px;height:16px;"></td>
            <td class="cs101A94F7" style="width:38px;height:16px;"></td>
            <td class="cs101A94F7" style="width:13px;height:16px;"></td>
            <td class="cs101A94F7" style="width:28px;height:16px;"></td>
            <td class="cs101A94F7" style="width:4px;height:16px;"></td>
            <td class="cs101A94F7" style="width:30px;height:16px;"></td>
            <td class="cs101A94F7" style="width:14px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:27px;height:16px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:16px;"></td>
            <td class="cs101A94F7" style="width:11px;height:16px;"></td>
            <td class="cs101A94F7" style="width:10px;height:16px;"></td>
            <td class="cs101A94F7" style="width:22px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:3px;height:16px;"></td>
            <td class="cs101A94F7" style="width:18px;height:16px;"></td>
            <td class="cs101A94F7" style="width:12px;height:16px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:16px;"></td>
            <td class="cs101A94F7" style="width:11px;height:16px;"></td>
            <td class="cs101A94F7" style="width:34px;height:16px;"></td>
            <td class="cs101A94F7" style="width:59px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs101A94F7" style="width:1px;height:16px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:16px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs12FE94AA" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
            <td class="csCE72709D" colspan="6" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
            <td class="cs12FE94AA" colspan="14" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
            <td class="csCE72709D" colspan="12" style="width:224px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:20px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:3px;height:20px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:20px;"></td>
            <td class="cs101A94F7" style="width:5px;height:20px;"></td>
            <td class="cs101A94F7" style="width:24px;height:20px;"></td>
            <td class="cs101A94F7" style="width:26px;height:20px;"></td>
            <td class="cs101A94F7" style="width:16px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:108px;height:20px;"></td>
            <td class="cs101A94F7" style="width:38px;height:20px;"></td>
            <td class="cs101A94F7" style="width:13px;height:20px;"></td>
            <td class="cs101A94F7" style="width:28px;height:20px;"></td>
            <td class="cs101A94F7" style="width:4px;height:20px;"></td>
            <td class="cs101A94F7" style="width:30px;height:20px;"></td>
            <td class="cs101A94F7" style="width:14px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:27px;height:20px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:20px;"></td>
            <td class="cs101A94F7" style="width:11px;height:20px;"></td>
            <td class="cs101A94F7" style="width:10px;height:20px;"></td>
            <td class="cs101A94F7" style="width:22px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:3px;height:20px;"></td>
            <td class="cs101A94F7" style="width:18px;height:20px;"></td>
            <td class="cs101A94F7" style="width:12px;height:20px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:20px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:20px;"></td>
            <td class="cs101A94F7" style="width:11px;height:20px;"></td>
            <td class="cs101A94F7" style="width:34px;height:20px;"></td>
            <td class="cs101A94F7" style="width:59px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs101A94F7" style="width:1px;height:20px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:20px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>PREMIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
            <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateJourAbsent.'</td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DERNIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
            <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateDernierJour.'</td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>JOUR&nbsp;DE&nbsp;RETOUR&nbsp;AU&nbsp;TRAVAIL&nbsp;:</nobr></td>
            <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateRetour.'</td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;DE&nbsp;JOURS&nbsp;TOTAL&nbsp;:</nobr></td>
            <td class="csA803F7DA" colspan="3" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nombreJour.'</td>
            <td class="csE152E1D" colspan="6" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>CONTROLE&nbsp;:</nobr></td>
            <td class="csA803F7DA" colspan="8" style="width:74px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$controle.'</td>
            <td class="csE152E1D" colspan="4" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>RESTE&nbsp;:</nobr></td>
            <td class="csA803F7DA" colspan="2" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$ResteJour.'</td>
            <td class="cs101A94F7" style="width:59px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="cs101A94F7" style="width:24px;height:22px;"></td>
            <td class="cs101A94F7" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:108px;height:22px;"></td>
            <td class="cs101A94F7" style="width:38px;height:22px;"></td>
            <td class="cs101A94F7" style="width:13px;height:22px;"></td>
            <td class="cs101A94F7" style="width:28px;height:22px;"></td>
            <td class="cs101A94F7" style="width:4px;height:22px;"></td>
            <td class="csFFC1C457" colspan="14" style="width:165px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(REMPLIR&nbsp;PAR&nbsp;DRH&nbsp;/&nbsp;AG)</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:34px;height:22px;"></td>
            <td class="cs101A94F7" style="width:59px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;DE&nbsp;L'.$abs1.'&nbsp;:</nobr></td>
            <td class="csCE72709D" colspan="27" style="width:406px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>CONGE&nbsp;ANNUEL</nobr></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:12px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
            <td class="cs101A94F7" style="width:5px;height:12px;"></td>
            <td class="cs101A94F7" style="width:24px;height:12px;"></td>
            <td class="cs101A94F7" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" style="width:16px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:108px;height:12px;"></td>
            <td class="cs101A94F7" style="width:38px;height:12px;"></td>
            <td class="cs101A94F7" style="width:13px;height:12px;"></td>
            <td class="cs101A94F7" style="width:28px;height:12px;"></td>
            <td class="cs101A94F7" style="width:4px;height:12px;"></td>
            <td class="cs101A94F7" style="width:30px;height:12px;"></td>
            <td class="cs101A94F7" style="width:14px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:27px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:10px;height:12px;"></td>
            <td class="cs101A94F7" style="width:22px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" style="width:18px;height:12px;"></td>
            <td class="cs101A94F7" style="width:12px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:34px;height:12px;"></td>
            <td class="cs101A94F7" style="width:59px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="csCE72709D" colspan="29" style="width:510px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AUTRES&nbsp;DETAILS&nbsp;</nobr></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:34px;height:22px;"></td>
            <td class="cs101A94F7" style="width:59px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:41px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:41px;"></td>
            <td class="cs66EA1E29" colspan="35" style="width:678px;height:41px;line-height:15px;text-align:left;vertical-align:middle;">'.$autresDetail.'</td>
            <td class="cs101A94F7" style="width:1px;height:41px;"></td>
            <td class="cs101A94F7" style="width:1px;height:41px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:41px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:11px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:3px;height:11px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:11px;"></td>
            <td class="cs101A94F7" style="width:5px;height:11px;"></td>
            <td class="cs101A94F7" style="width:24px;height:11px;"></td>
            <td class="cs101A94F7" style="width:26px;height:11px;"></td>
            <td class="cs101A94F7" style="width:16px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:108px;height:11px;"></td>
            <td class="cs101A94F7" style="width:38px;height:11px;"></td>
            <td class="cs101A94F7" style="width:13px;height:11px;"></td>
            <td class="cs101A94F7" style="width:28px;height:11px;"></td>
            <td class="cs101A94F7" style="width:4px;height:11px;"></td>
            <td class="cs101A94F7" style="width:30px;height:11px;"></td>
            <td class="cs101A94F7" style="width:14px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:27px;height:11px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:11px;"></td>
            <td class="cs101A94F7" style="width:11px;height:11px;"></td>
            <td class="cs101A94F7" style="width:10px;height:11px;"></td>
            <td class="cs101A94F7" style="width:22px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:3px;height:11px;"></td>
            <td class="cs101A94F7" style="width:18px;height:11px;"></td>
            <td class="cs101A94F7" style="width:12px;height:11px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:11px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:11px;"></td>
            <td class="cs101A94F7" style="width:11px;height:11px;"></td>
            <td class="cs101A94F7" style="width:34px;height:11px;"></td>
            <td class="cs101A94F7" style="width:59px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs101A94F7" style="width:1px;height:11px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:11px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:23px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:23px;"></td>
            <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
            <td class="cs101A94F7" style="width:16px;height:23px;"></td>
            <td class="csF35B754C" colspan="5" style="width:178px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;DE&nbsp;L'.$abs2.'</nobr></td>
            <td class="cs101A94F7" style="width:4px;height:23px;"></td>
            <td class="cs101A94F7" style="width:30px;height:23px;"></td>
            <td class="cs8F84A210" colspan="21" style="width:323px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;DU&nbsp;REMPLANCANT&nbsp;/COLLABORATEUR</nobr></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="cs101A94F7" style="width:24px;height:22px;"></td>
            <td class="cs101A94F7" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
            <td class="csAA0003C9" colspan="5" style="width:178px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$agent.'</td>
            <td class="cs101A94F7" style="width:4px;height:22px;"></td>
            <td class="cs101A94F7" style="width:30px;height:22px;"></td>
            <td class="csAA0003C9" colspan="21" style="width:321px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$remplacement.'</td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:27px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:3px;height:27px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:27px;"></td>
            <td class="cs101A94F7" style="width:5px;height:27px;"></td>
            <td class="cs101A94F7" style="width:24px;height:27px;"></td>
            <td class="cs101A94F7" style="width:26px;height:27px;"></td>
            <td class="cs101A94F7" style="width:16px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:108px;height:27px;"></td>
            <td class="cs101A94F7" style="width:38px;height:27px;"></td>
            <td class="cs101A94F7" style="width:13px;height:27px;"></td>
            <td class="cs101A94F7" style="width:28px;height:27px;"></td>
            <td class="cs101A94F7" style="width:4px;height:27px;"></td>
            <td class="cs101A94F7" style="width:30px;height:27px;"></td>
            <td class="cs101A94F7" style="width:14px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:27px;height:27px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:27px;"></td>
            <td class="cs101A94F7" style="width:11px;height:27px;"></td>
            <td class="cs101A94F7" style="width:10px;height:27px;"></td>
            <td class="cs101A94F7" style="width:22px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:3px;height:27px;"></td>
            <td class="cs101A94F7" style="width:18px;height:27px;"></td>
            <td class="cs101A94F7" style="width:12px;height:27px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:27px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:27px;"></td>
            <td class="cs101A94F7" style="width:11px;height:27px;"></td>
            <td class="cs101A94F7" style="width:34px;height:27px;"></td>
            <td class="cs101A94F7" style="width:59px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs101A94F7" style="width:1px;height:27px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:27px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:3px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:3px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
            <td class="cs101A94F7" style="width:5px;height:3px;"></td>
            <td class="cs101A94F7" style="width:24px;height:3px;"></td>
            <td class="cs101A94F7" style="width:26px;height:3px;"></td>
            <td class="cs101A94F7" style="width:16px;height:3px;"></td>
            <td class="cs101A94F7" colspan="5" style="width:188px;height:3px;"></td>
            <td class="cs101A94F7" style="width:4px;height:3px;"></td>
            <td class="cs101A94F7" style="width:30px;height:3px;"></td>
            <td class="cs101A94F7" style="width:14px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:27px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
            <td class="cs101A94F7" style="width:11px;height:3px;"></td>
            <td class="cs101A94F7" colspan="15" style="width:261px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:1px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:3px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
            <td class="cs101A94F7" style="width:5px;height:1px;"></td>
            <td class="cs101A94F7" style="width:24px;height:1px;"></td>
            <td class="cs101A94F7" style="width:26px;height:1px;"></td>
            <td class="cs101A94F7" style="width:16px;height:1px;"></td>
            <td class="cs5971619E" colspan="5" style="width:188px;height:1px;"></td>
            <td class="cs101A94F7" style="width:4px;height:1px;"></td>
            <td class="cs101A94F7" style="width:30px;height:1px;"></td>
            <td class="cs101A94F7" style="width:14px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:27px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
            <td class="cs101A94F7" style="width:11px;height:1px;"></td>
            <td class="cs5971619E" colspan="15" style="width:261px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:4px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:3px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
            <td class="cs101A94F7" style="width:5px;height:4px;"></td>
            <td class="cs101A94F7" style="width:24px;height:4px;"></td>
            <td class="cs101A94F7" style="width:26px;height:4px;"></td>
            <td class="cs101A94F7" style="width:16px;height:4px;"></td>
            <td class="cs101A94F7" colspan="5" style="width:188px;height:4px;"></td>
            <td class="cs101A94F7" style="width:4px;height:4px;"></td>
            <td class="cs101A94F7" style="width:30px;height:4px;"></td>
            <td class="cs101A94F7" style="width:14px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:27px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
            <td class="cs101A94F7" style="width:11px;height:4px;"></td>
            <td class="cs101A94F7" colspan="15" style="width:261px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:12px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
            <td class="cs101A94F7" style="width:5px;height:12px;"></td>
            <td class="cs101A94F7" style="width:24px;height:12px;"></td>
            <td class="cs101A94F7" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" style="width:16px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:108px;height:12px;"></td>
            <td class="cs101A94F7" style="width:38px;height:12px;"></td>
            <td class="cs101A94F7" style="width:13px;height:12px;"></td>
            <td class="cs101A94F7" style="width:28px;height:12px;"></td>
            <td class="cs101A94F7" style="width:4px;height:12px;"></td>
            <td class="cs101A94F7" style="width:30px;height:12px;"></td>
            <td class="cs101A94F7" style="width:14px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:27px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:10px;height:12px;"></td>
            <td class="cs101A94F7" style="width:22px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" style="width:18px;height:12px;"></td>
            <td class="cs101A94F7" style="width:12px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:34px;height:12px;"></td>
            <td class="cs101A94F7" style="width:59px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:23px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:23px;"></td>
            <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
            <td class="cs101A94F7" style="width:16px;height:23px;"></td>
            <td class="csF35B754C" colspan="8" style="width:226px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;CHEF&nbsp;DE&nbsp;SERVICE</nobr></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs101A94F7" style="width:27px;height:23px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:23px;"></td>
            <td class="cs101A94F7" style="width:11px;height:23px;"></td>
            <td class="cs101A94F7" style="width:10px;height:23px;"></td>
            <td class="cs101A94F7" style="width:22px;height:23px;"></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs8F84A210" colspan="12" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;CHEF&nbsp;HIERARCHIQUE</nobr></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs101A94F7" style="width:1px;height:23px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
            <td class="cs101A94F7" style="width:5px;height:22px;"></td>
            <td class="cs101A94F7" style="width:24px;height:22px;"></td>
            <td class="cs101A94F7" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
            <td class="csAA0003C9" colspan="8" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$chefService.'</td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:27px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:10px;height:22px;"></td>
            <td class="cs101A94F7" style="width:22px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="csAA0003C9" colspan="12" style="width:218px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$hierarchie.'</td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:34px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:3px;height:34px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:34px;"></td>
            <td class="cs101A94F7" style="width:5px;height:34px;"></td>
            <td class="cs101A94F7" style="width:24px;height:34px;"></td>
            <td class="cs101A94F7" style="width:26px;height:34px;"></td>
            <td class="cs101A94F7" style="width:16px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:108px;height:34px;"></td>
            <td class="cs101A94F7" style="width:38px;height:34px;"></td>
            <td class="cs101A94F7" style="width:13px;height:34px;"></td>
            <td class="cs101A94F7" style="width:28px;height:34px;"></td>
            <td class="cs101A94F7" style="width:4px;height:34px;"></td>
            <td class="cs101A94F7" style="width:30px;height:34px;"></td>
            <td class="cs101A94F7" style="width:14px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:27px;height:34px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:34px;"></td>
            <td class="cs101A94F7" style="width:11px;height:34px;"></td>
            <td class="cs101A94F7" style="width:10px;height:34px;"></td>
            <td class="cs101A94F7" style="width:22px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:3px;height:34px;"></td>
            <td class="cs101A94F7" style="width:18px;height:34px;"></td>
            <td class="cs101A94F7" style="width:12px;height:34px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:34px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:34px;"></td>
            <td class="cs101A94F7" style="width:11px;height:34px;"></td>
            <td class="cs101A94F7" style="width:34px;height:34px;"></td>
            <td class="cs101A94F7" style="width:59px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs101A94F7" style="width:1px;height:34px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:34px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:3px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:3px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
            <td class="cs101A94F7" style="width:5px;height:3px;"></td>
            <td class="cs101A94F7" style="width:24px;height:3px;"></td>
            <td class="cs101A94F7" style="width:26px;height:3px;"></td>
            <td class="cs101A94F7" style="width:16px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" colspan="8" style="width:236px;height:3px;"></td>
            <td class="cs101A94F7" style="width:27px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
            <td class="cs101A94F7" style="width:11px;height:3px;"></td>
            <td class="cs101A94F7" style="width:10px;height:3px;"></td>
            <td class="cs101A94F7" style="width:22px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" colspan="12" style="width:228px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:1px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:3px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
            <td class="cs101A94F7" style="width:5px;height:1px;"></td>
            <td class="cs101A94F7" style="width:24px;height:1px;"></td>
            <td class="cs101A94F7" style="width:26px;height:1px;"></td>
            <td class="cs101A94F7" style="width:16px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs5971619E" colspan="8" style="width:236px;height:1px;"></td>
            <td class="cs101A94F7" style="width:27px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
            <td class="cs101A94F7" style="width:11px;height:1px;"></td>
            <td class="cs101A94F7" style="width:10px;height:1px;"></td>
            <td class="cs101A94F7" style="width:22px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs5971619E" colspan="12" style="width:228px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:4px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:3px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
            <td class="cs101A94F7" style="width:5px;height:4px;"></td>
            <td class="cs101A94F7" style="width:24px;height:4px;"></td>
            <td class="cs101A94F7" style="width:26px;height:4px;"></td>
            <td class="cs101A94F7" style="width:16px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" colspan="8" style="width:236px;height:4px;"></td>
            <td class="cs101A94F7" style="width:27px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
            <td class="cs101A94F7" style="width:11px;height:4px;"></td>
            <td class="cs101A94F7" style="width:10px;height:4px;"></td>
            <td class="cs101A94F7" style="width:22px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" colspan="12" style="width:228px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:12px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
            <td class="cs101A94F7" style="width:5px;height:12px;"></td>
            <td class="cs101A94F7" style="width:24px;height:12px;"></td>
            <td class="cs101A94F7" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" style="width:16px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:108px;height:12px;"></td>
            <td class="cs101A94F7" style="width:38px;height:12px;"></td>
            <td class="cs101A94F7" style="width:13px;height:12px;"></td>
            <td class="cs101A94F7" style="width:28px;height:12px;"></td>
            <td class="cs101A94F7" style="width:4px;height:12px;"></td>
            <td class="cs101A94F7" style="width:30px;height:12px;"></td>
            <td class="cs101A94F7" style="width:14px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:27px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:10px;height:12px;"></td>
            <td class="cs101A94F7" style="width:22px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:3px;height:12px;"></td>
            <td class="cs101A94F7" style="width:18px;height:12px;"></td>
            <td class="cs101A94F7" style="width:12px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
            <td class="cs101A94F7" style="width:11px;height:12px;"></td>
            <td class="cs101A94F7" style="width:34px;height:12px;"></td>
            <td class="cs101A94F7" style="width:59px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs101A94F7" style="width:1px;height:12px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:24px;"></td>
            <td class="cs101A94F7" style="width:3px;height:24px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:24px;"></td>
            <td class="cs101A94F7" style="width:5px;height:24px;"></td>
            <td class="cs101A94F7" style="width:24px;height:24px;"></td>
            <td class="cs101A94F7" style="width:26px;height:24px;"></td>
            <td class="cs101A94F7" style="width:16px;height:24px;"></td>
            <td class="cs101A94F7" style="width:1px;height:24px;"></td>
            <td class="csF35B754C" colspan="24" style="width:448px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>********************************************************************</nobr></td>
            <td class="cs101A94F7" style="width:34px;height:24px;"></td>
            <td class="cs101A94F7" style="width:59px;height:24px;"></td>
            <td class="cs101A94F7" style="width:1px;height:24px;"></td>
            <td class="cs101A94F7" style="width:1px;height:24px;"></td>
            <td class="cs101A94F7" style="width:1px;height:24px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:24px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:10px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:3px;height:10px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:10px;"></td>
            <td class="cs101A94F7" style="width:5px;height:10px;"></td>
            <td class="cs101A94F7" style="width:24px;height:10px;"></td>
            <td class="cs101A94F7" style="width:26px;height:10px;"></td>
            <td class="cs101A94F7" style="width:16px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:108px;height:10px;"></td>
            <td class="cs101A94F7" style="width:38px;height:10px;"></td>
            <td class="cs101A94F7" style="width:13px;height:10px;"></td>
            <td class="cs101A94F7" style="width:28px;height:10px;"></td>
            <td class="cs101A94F7" style="width:4px;height:10px;"></td>
            <td class="cs101A94F7" style="width:30px;height:10px;"></td>
            <td class="cs101A94F7" style="width:14px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:27px;height:10px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:10px;"></td>
            <td class="cs101A94F7" style="width:11px;height:10px;"></td>
            <td class="cs101A94F7" style="width:10px;height:10px;"></td>
            <td class="cs101A94F7" style="width:22px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:3px;height:10px;"></td>
            <td class="cs101A94F7" style="width:18px;height:10px;"></td>
            <td class="cs101A94F7" style="width:12px;height:10px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:10px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:10px;"></td>
            <td class="cs101A94F7" style="width:11px;height:10px;"></td>
            <td class="cs101A94F7" style="width:34px;height:10px;"></td>
            <td class="cs101A94F7" style="width:59px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs101A94F7" style="width:1px;height:10px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:10px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="csAA0003C9" colspan="9" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;"><nobr>CETTE&nbsp;FICHE&nbsp;DOIT&nbsp;PARVENIR&nbsp;A&nbsp;LA&nbsp;DRH&nbsp;:</nobr></td>
            <td class="cs101A94F7" style="width:38px;height:22px;"></td>
            <td class="cs101A94F7" style="width:13px;height:22px;"></td>
            <td class="cs101A94F7" style="width:28px;height:22px;"></td>
            <td class="cs101A94F7" style="width:4px;height:22px;"></td>
            <td class="cs101A94F7" style="width:30px;height:22px;"></td>
            <td class="cs101A94F7" style="width:14px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:27px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:10px;height:22px;"></td>
            <td class="cs101A94F7" style="width:22px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs7658BE13" colspan="12" rowspan="2" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:1px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:3px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
            <td class="cs101A94F7" style="width:5px;height:1px;"></td>
            <td class="cs101A94F7" style="width:24px;height:1px;"></td>
            <td class="cs101A94F7" style="width:26px;height:1px;"></td>
            <td class="cs101A94F7" style="width:16px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:108px;height:1px;"></td>
            <td class="cs101A94F7" style="width:38px;height:1px;"></td>
            <td class="cs101A94F7" style="width:13px;height:1px;"></td>
            <td class="cs101A94F7" style="width:28px;height:1px;"></td>
            <td class="cs101A94F7" style="width:4px;height:1px;"></td>
            <td class="cs101A94F7" style="width:30px;height:1px;"></td>
            <td class="cs101A94F7" style="width:14px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:27px;height:1px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
            <td class="cs101A94F7" style="width:11px;height:1px;"></td>
            <td class="cs101A94F7" style="width:10px;height:1px;"></td>
            <td class="cs101A94F7" style="width:22px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs101A94F7" style="width:1px;height:1px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LES&nbsp;CONGES&nbsp;:&nbsp;AU&nbsp;MOINS&nbsp;24&nbsp;HEURES&nbsp;A&nbsp;L'.$abs3.'&nbsp;A&nbsp;L'.$abs4.'&nbsp;DES&nbsp;CAS&nbsp;D'.$abs5.'</nobr></td>
            <td class="cs101A94F7" style="width:22px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" style="width:18px;height:22px;"></td>
            <td class="cs101A94F7" style="width:12px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:34px;height:22px;"></td>
            <td class="cs101A94F7" style="width:59px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:22px;"></td>
            <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LA&nbsp;MALADIE&nbsp;/&nbsp;ACCIDENT&nbsp;:&nbsp;IMMEDIATEMENT&nbsp;LORS&nbsp;DU&nbsp;RETOUR</nobr></td>
            <td class="cs101A94F7" style="width:22px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:3px;height:22px;"></td>
            <td class="cs101A94F7" style="width:18px;height:22px;"></td>
            <td class="cs101A94F7" style="width:12px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
            <td class="cs101A94F7" style="width:11px;height:22px;"></td>
            <td class="cs101A94F7" style="width:34px;height:22px;"></td>
            <td class="cs101A94F7" style="width:59px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs101A94F7" style="width:1px;height:22px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:3px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:3px;"></td>
            <td class="cs279C008" colspan="21" rowspan="2" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;EVENEMENTS&nbsp;FAMILIAUX&nbsp;&amp;&nbsp;AUTRES&nbsp;RAISONS&nbsp;:&nbsp;DE&nbsp;SUITE</nobr></td>
            <td class="cs101A94F7" style="width:22px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:3px;height:3px;"></td>
            <td class="cs101A94F7" style="width:18px;height:3px;"></td>
            <td class="cs101A94F7" style="width:12px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:26px;height:3px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:63px;height:3px;"></td>
            <td class="cs101A94F7" style="width:11px;height:3px;"></td>
            <td class="cs101A94F7" style="width:34px;height:3px;"></td>
            <td class="cs101A94F7" style="width:59px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs101A94F7" style="width:1px;height:3px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:19px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:19px;"></td>
            <td class="cs101A94F7" style="width:22px;height:19px;"></td>
            <td class="csF35B754C" colspan="12" rowspan="2" style="width:218px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>.................................................................</nobr></td>
            <td class="cs101A94F7" style="width:1px;height:19px;"></td>
            <td class="cs101A94F7" style="width:1px;height:19px;"></td>
            <td class="cs101A94F7" style="width:1px;height:19px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:19px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:4px;"></td>
            <td></td>
            <td class="csBDA79072" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:3px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
            <td class="cs101A94F7" style="width:5px;height:4px;"></td>
            <td class="cs101A94F7" style="width:24px;height:4px;"></td>
            <td class="cs101A94F7" style="width:26px;height:4px;"></td>
            <td class="cs101A94F7" style="width:16px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:108px;height:4px;"></td>
            <td class="cs101A94F7" style="width:38px;height:4px;"></td>
            <td class="cs101A94F7" style="width:13px;height:4px;"></td>
            <td class="cs101A94F7" style="width:28px;height:4px;"></td>
            <td class="cs101A94F7" style="width:4px;height:4px;"></td>
            <td class="cs101A94F7" style="width:30px;height:4px;"></td>
            <td class="cs101A94F7" style="width:14px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:27px;height:4px;"></td>
            <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
            <td class="cs101A94F7" style="width:11px;height:4px;"></td>
            <td class="cs101A94F7" style="width:10px;height:4px;"></td>
            <td class="cs101A94F7" style="width:22px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs101A94F7" style="width:1px;height:4px;"></td>
            <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
        </tr>
        <tr style="vertical-align:top;">
            <td style="width:0px;height:8px;"></td>
            <td></td>
            <td class="cs593B729A" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:3px;height:5px;"></td>
            <td class="csE7D235EF" colspan="2" style="width:53px;height:5px;"></td>
            <td class="csE7D235EF" style="width:5px;height:5px;"></td>
            <td class="csE7D235EF" style="width:24px;height:5px;"></td>
            <td class="csE7D235EF" style="width:26px;height:5px;"></td>
            <td class="csE7D235EF" style="width:16px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:108px;height:5px;"></td>
            <td class="csE7D235EF" style="width:38px;height:5px;"></td>
            <td class="csE7D235EF" style="width:13px;height:5px;"></td>
            <td class="csE7D235EF" style="width:28px;height:5px;"></td>
            <td class="csE7D235EF" style="width:4px;height:5px;"></td>
            <td class="csE7D235EF" style="width:30px;height:5px;"></td>
            <td class="csE7D235EF" style="width:14px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:27px;height:5px;"></td>
            <td class="csE7D235EF" colspan="2" style="width:17px;height:5px;"></td>
            <td class="csE7D235EF" style="width:11px;height:5px;"></td>
            <td class="csE7D235EF" style="width:10px;height:5px;"></td>
            <td class="csE7D235EF" style="width:22px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:3px;height:5px;"></td>
            <td class="csE7D235EF" style="width:18px;height:5px;"></td>
            <td class="csE7D235EF" style="width:12px;height:5px;"></td>
            <td class="csE7D235EF" colspan="2" style="width:26px;height:5px;"></td>
            <td class="csE7D235EF" colspan="2" style="width:63px;height:5px;"></td>
            <td class="csE7D235EF" style="width:11px;height:5px;"></td>
            <td class="csE7D235EF" style="width:34px;height:5px;"></td>
            <td class="csE7D235EF" style="width:59px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="csE7D235EF" style="width:1px;height:5px;"></td>
            <td class="cs11B2FA6F" colspan="2" style="width:9px;height:5px;"></td>
        </tr>
    </table>
    </body>
    </html>

            '; 

    return $output;

}   

//======================= AUTRES CONGES =====================================================================================
//=========================================================================================================================

function pdf_autres_conges(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoAutresConges($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoAutresConges($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $dateJourAbsent='';
            $dateDernierJour='';
            $dateRetour='';
            $created_at='';
            $nombreJour='';
            $controle=0;
            $ResteJour=0;
            $autresDetail='';
            $codeBS='';
            $agent='';
            $remplacement='';
            $chefService='';
            $hierarchie='';

            $abs1="'ABSENCES";
            $abs2="'AGENT";
            $abs3="'AVANCE";
            $abs4="'EXCEPTION";
            $abs5="'URGENCE";
            //
            $data2 = DB::table('tperso_autre_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_autre_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_autre_conge.id","autreDetail","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_autre_conge.author","refAnne","refEnteteConge",
            "dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","dateJourAbsent","tperso_autre_conge.created_at",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour) as nombreJour')  
            ->selectRaw('((controle)-(TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour))) as ResteJour') 
            ->selectRaw('CONCAT("F",YEAR(tperso_autre_conge.created_at),"",MONTH(tperso_autre_conge.created_at),"00",tperso_autre_conge.id) as codeBS')
            ->selectRaw('CONCAT("",YEAR(tperso_autre_conge.created_at)) as annnee')
            ->where('tperso_autre_conge.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $fonction_agent=$row->fonction_agent;
                $dateJourAbsent=$row->dateJourAbsent;
                $dateDernierJour=$row->dateDernierJour;
                $dateRetour=$row->dateRetour;
                $created_at=$row->created_at;
                $nombreJour=$row->nombreJour;
                $controle=$row->controle;
                $ResteJour=$row->ResteJour;
                $autresDetail=$row->autresDetail;
                $codeBS=$row->codeBS;                                  
            }        
    
            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>AUTRES CONGES</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAA0003C9 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csF35B754C {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs279C008 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:881px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:108px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="26" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="26" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="8" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="26" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="26" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="8" style="width:169px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="cs188E5F6F" colspan="40" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>COMMUNICATION&nbsp;D'.$abs1.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:53px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:5px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:24px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:26px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:108px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:38px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:28px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:4px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:30px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:27px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:17px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:22px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:18px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:26px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:63px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:34px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:59px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="cs62ED362D" colspan="2" style="width:9px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:51px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="14" style="width:333px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        <td class="cs12FE94AA" colspan="9" style="width:81px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="11" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                        <td class="cs12FE94AA" colspan="14" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="12" style="width:224px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>PREMIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateJourAbsent.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DERNIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateDernierJour.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>JOUR&nbsp;DE&nbsp;RETOUR&nbsp;AU&nbsp;TRAVAIL&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateRetour.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;DE&nbsp;JOURS&nbsp;TOTAL&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="3" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nombreJour.'</td>
                        <td class="csE152E1D" colspan="6" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>CONTROLE&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="8" style="width:74px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$controle.'</td>
                        <td class="csE152E1D" colspan="4" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>RESTE&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="2" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$ResteJour.'</td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="14" style="width:165px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(REMPLIR&nbsp;PAR&nbsp;DRH&nbsp;/&nbsp;AG)</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;DE&nbsp;L'.$abs1.'&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="27" style="width:406px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">AUTRES RAISONS - EXPLICATION NECESSAIRE</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="29" style="width:510px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AUTRES&nbsp;DETAILS&nbsp;</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:41px;"></td>
                        <td class="cs66EA1E29" colspan="35" style="width:678px;height:41px;line-height:15px;text-align:left;vertical-align:middle;">'.$autresDetail.'</td>
                        <td class="cs101A94F7" style="width:1px;height:41px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:41px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:41px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF35B754C" colspan="5" style="width:178px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;DE&nbsp;L'.$abs2.'</nobr></td>
                        <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="21" style="width:323px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;DU&nbsp;REMPLANCANT&nbsp;/COLLABORATEUR</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="5" style="width:178px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$agent.'</td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="21" style="width:321px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$remplacement.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:27px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="5" style="width:188px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="15" style="width:261px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs5971619E" colspan="5" style="width:188px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs5971619E" colspan="15" style="width:261px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="5" style="width:188px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="15" style="width:261px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF35B754C" colspan="8" style="width:226px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;CHEF&nbsp;DE&nbsp;SERVICE</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;CHEF&nbsp;HIERARCHIQUE</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="8" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$chefService.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="12" style="width:218px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$hierarchie.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:34px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:236px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="12" style="width:228px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs5971619E" colspan="8" style="width:236px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs5971619E" colspan="12" style="width:228px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:236px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="12" style="width:228px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csF35B754C" colspan="24" style="width:448px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>********************************************************************</nobr></td>
                        <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="9" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;"><nobr>CETTE&nbsp;FICHE&nbsp;DOIT&nbsp;PARVENIR&nbsp;A&nbsp;LA&nbsp;DRH&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:38px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs7658BE13" colspan="12" rowspan="2" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LES&nbsp;CONGES&nbsp;:&nbsp;AU&nbsp;MOINS&nbsp;24&nbsp;HEURES&nbsp;A&nbsp;L'.$abs3.'&nbsp;A&nbsp;L'.$abs4.'&nbsp;DES&nbsp;CAS&nbsp;D'.$abs5.'</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LA&nbsp;MALADIE&nbsp;/&nbsp;ACCIDENT&nbsp;:&nbsp;IMMEDIATEMENT&nbsp;LORS&nbsp;DU&nbsp;RETOUR</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs279C008" colspan="21" rowspan="2" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;EVENEMENTS&nbsp;FAMILIAUX&nbsp;&amp;&nbsp;AUTRES&nbsp;RAISONS&nbsp;:&nbsp;DE&nbsp;SUITE</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:19px;"></td>
                        <td class="csF35B754C" colspan="12" rowspan="2" style="width:218px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>.................................................................</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:3px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:53px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:5px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:24px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:26px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:108px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:38px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:28px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:4px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:30px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:27px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:17px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:22px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:3px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:18px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:26px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:63px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:34px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:59px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="cs11B2FA6F" colspan="2" style="width:9px;height:5px;"></td>
                    </tr>
                </table>
                </body>
                </html>
            '; 

    return $output;

}   




//======================= CONGES DE MALADIE =====================================================================================
//=========================================================================================================================

function pdf_conge_maladie(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoCongeMaladie($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoCongeMaladie($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $dateJourAbsent='';
            $dateDernierJour='';
            $dateRetour='';
            $nombreJour='';
            $controle=0;
            $ResteJour=0;
            $autreDetail='';
            $codeBS='';
            $agent='';
            $remplacement='';
            $chefService='';
            $hierarchie='';
            $created_at='';

            $abs1="'ABSENCES";
            $abs2="'AGENT";
            $abs3="'AVANCE";
            $abs4="'EXCEPTION";
            $abs5="'URGENCE";
            //
            $data2 = DB::table('tperso_maladie_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
            ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",    
            "dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","dateJourAbsent","dateDernierJour","tperso_maladie_conge.created_at",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour) as nombreJour')  
            ->selectRaw('((controle)-(TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour))) as ResteJour') 
            ->selectRaw('CONCAT("F",YEAR(tperso_maladie_conge.created_at),"",MONTH(tperso_maladie_conge.created_at),"00",tperso_maladie_conge.id) as codeBS')
            ->selectRaw('CONCAT("",YEAR(tperso_maladie_conge.created_at)) as annnee')
            ->where('tperso_maladie_conge.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $fonction_agent=$row->fonction_agent;
                $dateJourAbsent=$row->dateJourAbsent;
                $dateDernierJour=$row->dateDernierJour;
                $dateRetour=$row->dateRetour;
                $nombreJour=$row->nombreJour;
                $controle=$row->controle;
                $ResteJour=$row->ResteJour;
                $autreDetail=$row->autreDetail;
                $created_at=$row->created_at;
                $codeBS=$row->codeBS;                                  
            }        
    
            $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>CONGE MALADIE / ACCIDENT</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAA0003C9 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csF35B754C {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs279C008 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:881px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:108px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="26" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="26" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="8" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="26" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="26" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="26" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="26" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="8" style="width:169px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="cs188E5F6F" colspan="40" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>COMMUNICATION&nbsp;D'.$abs1.'</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:53px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:5px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:24px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:26px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:108px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:38px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:28px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:4px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:30px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:27px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:17px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:22px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:18px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:26px;height:7px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:63px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:34px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:59px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                        <td class="cs62ED362D" colspan="2" style="width:9px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:51px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="14" style="width:333px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                        <td class="cs12FE94AA" colspan="9" style="width:81px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="11" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                        <td class="cs12FE94AA" colspan="14" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="12" style="width:224px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>PREMIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateJourAbsent.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DERNIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateDernierJour.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>JOUR&nbsp;DE&nbsp;RETOUR&nbsp;AU&nbsp;TRAVAIL&nbsp;:</nobr></td>
                        <td class="cs612ED82F" colspan="27" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateRetour.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;DE&nbsp;JOURS&nbsp;TOTAL&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="3" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nombreJour.'</td>
                        <td class="csE152E1D" colspan="6" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>CONTROLE&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="8" style="width:74px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$controle.'</td>
                        <td class="csE152E1D" colspan="4" style="width:85px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>RESTE&nbsp;:</nobr></td>
                        <td class="csA803F7DA" colspan="2" style="width:41px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$ResteJour.'</td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="14" style="width:165px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(REMPLIR&nbsp;PAR&nbsp;DRH&nbsp;/&nbsp;AG)</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;DE&nbsp;L'.$abs1.'&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="27" style="width:406px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">MALADIE / ACCIDENT</td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="29" style="width:510px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AUTRES&nbsp;DETAILS&nbsp;</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:41px;"></td>
                        <td class="cs66EA1E29" colspan="35" style="width:678px;height:41px;line-height:15px;text-align:left;vertical-align:middle;">'.$autreDetail.'</td>
                        <td class="cs101A94F7" style="width:1px;height:41px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:41px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:41px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF35B754C" colspan="5" style="width:178px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;DE&nbsp;L'.$abs2.'</nobr></td>
                        <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="21" style="width:323px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;DU&nbsp;REMPLANCANT&nbsp;/COLLABORATEUR</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="5" style="width:178px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$agent.'</td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="21" style="width:321px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$remplacement.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:27px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:27px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:27px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="5" style="width:188px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="15" style="width:261px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs5971619E" colspan="5" style="width:188px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs5971619E" colspan="15" style="width:261px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="5" style="width:188px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="15" style="width:261px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="6" style="width:103px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF35B754C" colspan="8" style="width:226px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;CHEF&nbsp;DE&nbsp;SERVICE</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;CHEF&nbsp;HIERARCHIQUE</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="8" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$chefService.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="12" style="width:218px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$hierarchie.'</td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:34px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:34px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:236px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="12" style="width:228px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs5971619E" colspan="8" style="width:236px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs5971619E" colspan="12" style="width:228px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="8" style="width:236px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="12" style="width:228px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csF35B754C" colspan="24" style="width:448px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>********************************************************************</nobr></td>
                        <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:10px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="csAA0003C9" colspan="9" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;"><nobr>CETTE&nbsp;FICHE&nbsp;DOIT&nbsp;PARVENIR&nbsp;A&nbsp;LA&nbsp;DRH&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:38px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs7658BE13" colspan="12" rowspan="2" style="width:220px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LES&nbsp;CONGES&nbsp;:&nbsp;AU&nbsp;MOINS&nbsp;24&nbsp;HEURES&nbsp;A&nbsp;L'.$abs3.'&nbsp;A&nbsp;L'.$abs4.'&nbsp;DES&nbsp;CAS&nbsp;D'.$abs5.'</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:22px;"></td>
                        <td class="cs279C008" colspan="21" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LA&nbsp;MALADIE&nbsp;/&nbsp;ACCIDENT&nbsp;:&nbsp;IMMEDIATEMENT&nbsp;LORS&nbsp;DU&nbsp;RETOUR</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:3px;"></td>
                        <td class="cs279C008" colspan="21" rowspan="2" style="width:421px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;EVENEMENTS&nbsp;FAMILIAUX&nbsp;&amp;&nbsp;AUTRES&nbsp;RAISONS&nbsp;:&nbsp;DE&nbsp;SUITE</nobr></td>
                        <td class="cs101A94F7" style="width:22px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:18px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:63px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:19px;"></td>
                        <td class="csF35B754C" colspan="12" rowspan="2" style="width:218px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>.................................................................</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:19px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:53px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:5px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:108px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:27px;height:4px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:17px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:9px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:3px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:53px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:5px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:24px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:26px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:108px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:38px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:28px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:4px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:30px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:27px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:17px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:22px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:3px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:18px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:26px;height:5px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:63px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:34px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:59px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:5px;"></td>
                        <td class="cs11B2FA6F" colspan="2" style="width:9px;height:5px;"></td>
                    </tr>
                </table>
                </body>
                </html>
            '; 

    return $output;

}   



//======================= CONGE FAMILLIAL =====================================================================================
//=========================================================================================================================

function pdf_conge_famillial(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoCongeFamillial($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoCongeFamillial($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $dateJourAbsent='';
            $dateDernierJour='';
            $dateRetour='';
            $nombreJour='';
            $controle=0;
            $ResteJour=0;
            $autreDetail='';
            $name_raison_famille='';
            $codeBS='';
            $agent='';
            $remplacement='';
            $chefService='';
            $hierarchie='';
            $created_at='';

            $abs1="'ABSENCES";
            $abs2="'AGENT";
            $abs3="'AVANCE";
            $abs4="'EXCEPTION";
            $abs5="'URGENCE";
            //
            $data2 = DB::table('tperso_conge_familiale')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_conge_familiale.refEnteteConge')
            ->join('tperso_raison_familiale','tperso_raison_familiale.id','=','tperso_conge_familiale.refRaison')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_conge_familiale.id","autreDetail","name_raison_famille","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_conge_familiale.author","refAnne","refEnteteConge",   
    
            "dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","tperso_conge_familiale.created_at",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour) as nombreJour')  
            ->selectRaw('((controle)-(TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour))) as ResteJour') 
            ->selectRaw('CONCAT("F",YEAR(tperso_conge_familiale.created_at),"",MONTH(tperso_conge_familiale.created_at),"00",tperso_conge_familiale.id) as codeBS')
            ->selectRaw('CONCAT("",YEAR(tperso_conge_familiale.created_at)) as annnee')
            ->where('tperso_conge_familiale.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $name_raison_famille=$row->name_raison_famille;
                $fonction_agent=$row->fonction_agent;
                $dateJourAbsent=$row->dateJourAbsent;
                $dateDernierJour=$row->dateDernierJour;
                $dateRetour=$row->dateRetour;
                $nombreJour=$row->nombreJour;
                $controle=$row->controle;
                $ResteJour=$row->ResteJour;
                $autreDetail=$row->autreDetail;
                $codeBS=$row->codeBS;  
                $created_at=$row->created_at; 
                
                $agent=$row->agent;
                $remplacement=$row->remplacement;
                $chefService=$row->chefService;
                $hierarchie=$row->hierarchie;
            }        
    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>RAISON FAMILLIALE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAA0003C9 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs96AF7B78 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs2A73E7CF {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csF35B754C {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs4B114620 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs279C008 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:914px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:44px;"></td>
                    <td style="height:0px;width:29px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:109px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:62px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:9px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="25" style="width:488px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:16px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="7" style="width:169px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:24px;"></td>
                    <td class="csFBB219FE" colspan="25" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="csE314B2A3" colspan="7" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                        <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="25" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="25" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:21px;"></td>
                    <td class="cs612ED82F" colspan="25" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:21px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:169px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="25" style="width:488px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:16px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="7" style="width:169px;height:6px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td class="cs188E5F6F" colspan="39" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>COMMUNICATION&nbsp;D'.$abs1.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:2px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:51px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:29px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:30px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:15px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:109px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:32px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:32px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:34px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:23px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:16px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:17px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:21px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:17px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:12px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:29px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:59px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:26px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:4px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:62px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:2px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="3" style="width:51px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="15" style="width:333px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                    <td class="cs12FE94AA" colspan="7" style="width:81px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="9" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:80px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="8" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                    <td class="cs12FE94AA" colspan="11" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="11" style="width:224px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>PREMIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateJourAbsent.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DERNIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateDernierJour.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>JOUR&nbsp;DE&nbsp;RETOUR&nbsp;AU&nbsp;TRAVAIL&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateRetour.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="7" style="width:215px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;DE&nbsp;JOURS&nbsp;TOTAL&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="3" style="width:42px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nombreJour.'</td>
                    <td class="csE152E1D" colspan="7" style="width:84px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>CONTROLE&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="6" style="width:75px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$controle.'</td>
                    <td class="csE152E1D" colspan="4" style="width:84px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>RESTE&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="3" style="width:42px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$ResteJour.'</td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="13" style="width:165px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(REMPLIR&nbsp;PAR&nbsp;DRH&nbsp;/&nbsp;AG)</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;DE&nbsp;L'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;FAMILLIALE</nobr></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>SPECIAFICATION&nbsp;DE&nbsp;LA&nbsp;RAISON&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$name_raison_famille.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="csCE72709D" colspan="28" style="width:510px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AUTRES&nbsp;DETAILS&nbsp;</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:40px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:40px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:40px;"></td>
                    <td class="cs66EA1E29" colspan="34" style="width:677px;height:40px;line-height:15px;text-align:left;vertical-align:middle;">'.$autreDetail.'</td>
                    <td class="cs101A94F7" style="width:2px;height:40px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:40px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:40px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs4B114620" colspan="23" style="width:422px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Les&nbsp;cong&#233;s&nbsp;de&nbsp;circonstances&nbsp;ne&nbsp;peuvent&nbsp;etre&nbsp;fractionn&#233;s.</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs4B114620" colspan="29" style="width:552px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Joindre&nbsp;&#224;&nbsp;ce&nbsp;formulaire&nbsp;un&nbsp;JUSTIFICATIF&nbsp;:&nbsp;Demande&nbsp;de&nbsp;cong&#233;&nbsp;ou&nbsp;un&nbsp;Certificat&nbsp;ou&nbsp;Invitation</nobr></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="5" style="width:103px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs2A73E7CF" colspan="6" style="width:178px;height:16px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;DE&nbsp;L'.$abs2.'</nobr></td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="21" style="width:323px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;DU&nbsp;REMPLANCANT&nbsp;/COLLABORATEUR</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="6" style="width:178px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$agent.'</td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="21" style="width:321px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$remplacement.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:37px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:37px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="6" style="width:188px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="15" style="width:261px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="6" style="width:188px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs5971619E" colspan="15" style="width:261px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="6" style="width:188px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="15" style="width:261px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="6" style="width:107px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs2A73E7CF" colspan="9" style="width:226px;height:16px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;CHEZ&nbsp;DE&nbsp;SERVICE</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="12" style="width:220px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;CHEF&nbsp;HIERARCHIQUE</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="9" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$chefService.'</td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="12" style="width:218px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$hierarchie.'</td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="9" style="width:236px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="12" style="width:228px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="9" style="width:236px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="12" style="width:228px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="9" style="width:236px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="12" style="width:228px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:9px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="csF35B754C" colspan="23" style="width:448px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>********************************************************************</nobr></td>
                    <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="8" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;"><nobr>CETTE&nbsp;FICHE&nbsp;DOIT&nbsp;PARVENIR&nbsp;A&nbsp;LA&nbsp;DRH&nbsp;:</nobr></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs279C008" colspan="21" style="width:422px;height:17px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LES&nbsp;CONGES&nbsp;:&nbsp;AU&nbsp;MOINS&nbsp;24&nbsp;HEURES&nbsp;A&nbsp;L'.$abs3.'&nbsp;A&nbsp;L'.$abs4.'&nbsp;DES&nbsp;CAS&nbsp;D'.$abs5.'</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs7658BE13" colspan="12" rowspan="2" style="width:220px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs279C008" colspan="21" style="width:422px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LA&nbsp;MALADIE&nbsp;/&nbsp;ACCIDENT&nbsp;:&nbsp;IMMEDIATEMENT&nbsp;LORS&nbsp;DU&nbsp;RETOUR</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs279C008" colspan="21" rowspan="2" style="width:422px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;EVENEMENTS&nbsp;FAMILIAUX&nbsp;&amp;&nbsp;AUTRES&nbsp;RAISONS&nbsp;:&nbsp;DE&nbsp;SUITE</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="csF35B754C" colspan="12" rowspan="2" style="width:218px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>.................................................................</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:3px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:2px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:29px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:30px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:15px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:109px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:32px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:32px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:34px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:23px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:17px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:11px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:21px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:17px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:12px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:29px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:59px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:26px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:4px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:62px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:2px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:3px;"></td>
                </tr>
            </table>
            </body>
            </html>

            '; 

    return $output;

}   




//======================= CONGE MATERNITE =====================================================================================
//=========================================================================================================================

function pdf_conge_maternite(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoCongeMaternite($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoCongeMaternite($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $dateJourAbsent='';
            $dateDernierJour='';
            $dateRetour='';
            $nombreJour='';
            $controle=0;
            $ResteJour=0;
            $autresDetail='';
            $dateAccouchement='';
            $modeAccouchement='';
            $codeBS='';
            $agent='';
            $remplacement='';
            $chefService='';
            $hierarchie='';
            $created_at='';

            $abs1="'ABSENCES";
            $abs2="'AGENT";
            $abs3="'AVANCE";
            $abs4="'EXCEPTION";
            $abs5="'URGENCE";
            //
            $data2 = DB::table('tperso_maternite')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maternite.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_maternite.id","refEnteteConge","dateAccouchement",
            "modeAccouchement","tperso_maternite.autresDetail","annexeMaternite","tperso_maternite.author","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maternite.author","refAnne","refEnteteConge",
            "dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","dateJourAbsent","dateDernierJour","tperso_maternite.created_at",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour) as nombreJour')  
            ->selectRaw('((controle)-(TIMESTAMPDIFF(DAY, dateJourAbsent, dateDernierJour))) as ResteJour') 
            ->selectRaw('CONCAT("F",YEAR(tperso_maternite.created_at),"",MONTH(tperso_maternite.created_at),"00",tperso_maternite.id) as codeBS')
            ->selectRaw('CONCAT("",YEAR(tperso_maternite.created_at)) as annnee')
            ->where('tperso_maternite.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $dateAccouchement=$row->dateAccouchement;
                $modeAccouchement=$row->modeAccouchement;
                $fonction_agent=$row->fonction_agent;
                $dateJourAbsent=$row->dateJourAbsent;
                $dateDernierJour=$row->dateDernierJour;
                $dateRetour=$row->dateRetour;
                $nombreJour=$row->nombreJour;
                $controle=$row->controle;
                $ResteJour=$row->ResteJour;
                $autreDetail=$row->autresDetail;
                $codeBS=$row->codeBS;  
                $created_at=$row->created_at; 
                
                $agent=$row->agent;
                $remplacement=$row->remplacement;
                $chefService=$row->chefService;
                $hierarchie=$row->hierarchie;
            }        
    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>CONGE DE MATERNITE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAA0003C9 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs96AF7B78 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs2A73E7CF {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csF35B754C {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs4B114620 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs279C008 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csE152E1D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:914px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:44px;"></td>
                    <td style="height:0px;width:29px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:109px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:58px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:62px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:9px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="25" style="width:488px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:16px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="7" style="width:169px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:24px;"></td>
                    <td class="csFBB219FE" colspan="25" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="csE314B2A3" colspan="7" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                        <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="25" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="25" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="25" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:21px;"></td>
                    <td class="cs612ED82F" colspan="25" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:21px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:169px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="25" style="width:488px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:16px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="7" style="width:169px;height:6px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td class="cs188E5F6F" colspan="39" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>COMMUNICATION&nbsp;D'.$abs1.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:3px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:2px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:51px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:29px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:30px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:15px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:109px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:32px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:32px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:34px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:23px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:16px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:17px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:11px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:21px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:17px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:12px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:29px;height:7px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:59px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:26px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:4px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:62px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:2px;height:7px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:7px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="3" style="width:51px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="15" style="width:333px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                    <td class="cs12FE94AA" colspan="7" style="width:81px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="9" style="width:206px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$codeAgent.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:16px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:16px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:80px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="8" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                    <td class="cs12FE94AA" colspan="11" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="11" style="width:224px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>PREMIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateJourAbsent.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DERNIER&nbsp;JOUR&nbsp;D'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateDernierJour.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>JOUR&nbsp;DE&nbsp;RETOUR&nbsp;AU&nbsp;TRAVAIL&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateRetour.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="7" style="width:215px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMBRE&nbsp;DE&nbsp;JOURS&nbsp;TOTAL&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="3" style="width:42px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nombreJour.'</td>
                    <td class="csE152E1D" colspan="7" style="width:84px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>CONTROLE&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="6" style="width:75px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$controle.'</td>
                    <td class="csE152E1D" colspan="4" style="width:84px;height:22px;line-height:13px;text-align:right;vertical-align:middle;"><nobr>RESTE&nbsp;:</nobr></td>
                    <td class="csA803F7DA" colspan="3" style="width:42px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$ResteJour.'</td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="13" style="width:165px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>(REMPLIR&nbsp;PAR&nbsp;DRH&nbsp;/&nbsp;AG)</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>RAISON&nbsp;DE&nbsp;L'.$abs1.'&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>CONGE DE MATERNITE</nobr></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="8" style="width:216px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">DATE ET MODE ACCOUCHEMENT</td>
                    <td class="cs612ED82F" colspan="23" style="width:406px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$dateAccouchement.'  - '.$modeAccouchement.'</td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="csCE72709D" colspan="28" style="width:510px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AUTRES&nbsp;DETAILS&nbsp;</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:40px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:40px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:40px;"></td>
                    <td class="cs66EA1E29" colspan="34" style="width:677px;height:40px;line-height:15px;text-align:left;vertical-align:middle;">'.$autreDetail.'</td>
                    <td class="cs101A94F7" style="width:2px;height:40px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:40px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:40px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs4B114620" colspan="23" style="width:422px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Les&nbsp;cong&#233;s&nbsp;de&nbsp;circonstances&nbsp;ne&nbsp;peuvent&nbsp;etre&nbsp;fractionn&#233;s.</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs4B114620" colspan="29" style="width:552px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Joindre&nbsp;&#224;&nbsp;ce&nbsp;formulaire&nbsp;un&nbsp;JUSTIFICATIF&nbsp;:&nbsp;Demande&nbsp;de&nbsp;cong&#233;&nbsp;ou&nbsp;un&nbsp;Certificat&nbsp;ou&nbsp;Invitation</nobr></td>
                    <td class="cs101A94F7" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:11px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:11px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="5" style="width:103px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs2A73E7CF" colspan="6" style="width:178px;height:16px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;DE&nbsp;L'.$abs2.'</nobr></td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="21" style="width:323px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;DU&nbsp;REMPLANCANT&nbsp;/COLLABORATEUR</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="6" style="width:178px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$agent.'</td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="21" style="width:321px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$remplacement.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:37px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:37px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:37px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:37px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:37px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="6" style="width:188px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="15" style="width:261px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="6" style="width:188px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs5971619E" colspan="15" style="width:261px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="6" style="width:188px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="15" style="width:261px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="6" style="width:107px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>DATE:&nbsp;'.$created_at.'</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="cs2A73E7CF" colspan="9" style="width:226px;height:16px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SIGNATURE&nbsp;CHEZ&nbsp;DE&nbsp;SERVICE</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs96AF7B78" colspan="12" style="width:220px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>SOGNATURE&nbsp;CHEF&nbsp;HIERARCHIQUE</nobr></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="9" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;">'.$chefService.'</td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="12" style="width:218px;height:16px;line-height:11px;text-align:right;vertical-align:top;">'.$hierarchie.'</td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="9" style="width:236px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="12" style="width:228px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="9" style="width:236px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="12" style="width:228px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="9" style="width:236px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="12" style="width:228px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:9px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="csF35B754C" colspan="23" style="width:448px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>********************************************************************</nobr></td>
                    <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="csAA0003C9" colspan="8" style="width:226px;height:16px;line-height:11px;text-align:center;vertical-align:top;"><nobr>CETTE&nbsp;FICHE&nbsp;DOIT&nbsp;PARVENIR&nbsp;A&nbsp;LA&nbsp;DRH&nbsp;:</nobr></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:23px;"></td>
                    <td class="cs279C008" colspan="21" style="width:422px;height:17px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LES&nbsp;CONGES&nbsp;:&nbsp;AU&nbsp;MOINS&nbsp;24&nbsp;HEURES&nbsp;A&nbsp;L'.$abs3.'&nbsp;A&nbsp;L'.$abs4.'&nbsp;DES&nbsp;CAS&nbsp;D'.$abs5.'</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs7658BE13" colspan="12" rowspan="2" style="width:220px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs279C008" colspan="21" style="width:422px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;LA&nbsp;MALADIE&nbsp;/&nbsp;ACCIDENT&nbsp;:&nbsp;IMMEDIATEMENT&nbsp;LORS&nbsp;DU&nbsp;RETOUR</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs279C008" colspan="21" rowspan="2" style="width:422px;height:16px;line-height:10px;text-align:left;vertical-align:top;"><nobr>-&nbsp;POUR&nbsp;EVENEMENTS&nbsp;FAMILIAUX&nbsp;&amp;&nbsp;AUTRES&nbsp;RAISONS&nbsp;:&nbsp;DE&nbsp;SUITE</nobr></td>
                    <td class="cs101A94F7" style="width:21px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:2px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:59px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:4px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:62px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:2px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:20px;"></td>
                    <td class="csF35B754C" colspan="12" rowspan="2" style="width:218px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>.................................................................</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:3px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:2px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:30px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:15px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:109px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:32px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:34px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:23px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:11px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:21px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:6px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:3px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:2px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:51px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:29px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:30px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:15px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:109px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:32px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:32px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:34px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:23px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:17px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:11px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:21px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:17px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:12px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:29px;height:3px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:59px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:26px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:4px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:62px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:2px;height:3px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:3px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:3px;"></td>
                </tr>
            </table>
            </body>
            </html>

            '; 

    return $output;

}   






//======================= BULLETINN DE PAIE =====================================================================================
//=========================================================================================================================

function pdf_bulletin_paie(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoBulletinPaie($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }   
    
}

function getInfoBulletinPaie($id)
{
           //Info entreprises
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
                $idNatEse=$row->rccm;
                $numImpotEse=$row->rccm;
                $busnessName=$row->nomSecteur;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", 'logo.png');
                $siege=$row->nomForme;         
            }
            //
            $noms_agent='';
            $name_serv_perso='';
            $codeAgent='';
            $fonction_agent='';
            $numCNSS='';
            $numcpteBanque='';
            $numImpot='';
            $BanqueAgant='';
            $name_mois='';
            $name_annee='';
            $Adresse='';
            $codeBS='';
            $refAnne=0;
            $refMois=0;
            $refAffectation=0;
            //
            $data2 = DB::table('tperso_entete_paiement')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_entete_paiement.id","name_mois","name_annee","dateFiche","refAnne",
            "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie',
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent",
            "provinceOrigine_agent","etatcivil_agent","refAvenue_agent","contact_agent",
            "mail_agent","grade_agent","fonction_agent","specialite_agent","Categorie_agent",
            "niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',"refAffectation",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
            "communes.idVille","communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays",
            "provinces.nomProvince","pays.nomPays")            
            ->selectRaw('CONCAT("PAIE",YEAR(tperso_entete_paiement.created_at),"",MONTH(tperso_entete_paiement.created_at),"00",tperso_entete_paiement.id) as codeBS')
            ->selectRaw('CONCAT("",nomVille,";Com.",nomCommune,";Q.",nomQuartier,";Av.",nomAvenue) as Adresse')
            ->where('tperso_entete_paiement.id','=', $id)    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {
                $noms_agent=$row->noms_agent;
                $name_serv_perso=$row->name_serv_perso;
                $codeAgent=$row->codeAgent;
                $fonction_agent=$row->fonction_agent;
                $codeBS=$row->codeBS;
                $numCNSS=$row->numCNSS;
                $numcpteBanque=$row->numcpteBanque;
                $numImpot=$row->numImpot;
                $BanqueAgant=$row->BanqueAgant;
                $name_mois=$row->name_mois;
                $name_annee=$row->name_annee;
                $Adresse=$row->Adresse;
                $refAnne=$row->refAnne;
                $refMois=$row->refMois;
                $refAffectation=$row->refAffectation;
            } 
            
            $totalBase=0;
            $totalBrut=0;
            $totalAvance=0;
            $totalNet=0;
                    
            //
            $data2 = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique')

            ->selectRaw('ROUND(SUM(IFNULL(montant,0)),0) as totalBase')
            ->where([               
               ['refEntetePaie','=', $id],
               ['name_categorie_rubrique','=', 'SALAIRE DE BASE']
           ])    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {                                
               $totalBase=$row->totalBase;
            }
   
            $data3 = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique')

            ->selectRaw('ROUND(SUM(IFNULL(montant,0)),0) as totalBrut')
            ->where([               
               ['refEntetePaie','=', $id],
               ['name_categorie_rubrique','!=', 'RETENU']
           ])    
            ->get(); 
            $output='';
            foreach ($data3 as $row) 
            {                                
               $totalBrut=$row->totalBrut;
            }

            $data4 = DB::table('tperso_avance_salaire')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->selectRaw('IFNULL(ROUND(SUM(IFNULL(montant_avance,0)),0),0) as totalAvance')
            ->where([               
               ['refAffectation','=', $refAffectation],
               ['refMois','=', $refMois],
               ['refAnne','=', $refAnne]
           ])    
            ->get(); 
            $output='';
            foreach ($data4 as $row) 
            {                                
               $totalAvance=$row->totalAvance;
            }

           $data5 =   DB::select(
                'select ((ROUND(SUM(IFNULL(montant,0)),0)) - (:avances)) as totalNet from tperso_detail_paiement_sal  
                inner join tperso_entete_paiement on tperso_entete_paiement.id = tperso_detail_paiement_sal.refEntetePaie
                inner join tperso_detail_affectation_ribrique on tperso_detail_affectation_ribrique.id = tperso_detail_paiement_sal.refDetailAffectRibrique
                inner join tperso_affectation_agent on tperso_affectation_agent.id = tperso_entete_paiement.refAffectation
                inner join tperso_fiche_paie on tperso_fiche_paie.id = tperso_entete_paiement.refFichePaie 
                inner join tconf_banque on tconf_banque.id = tperso_fiche_paie.refBanque
                inner join tperso_parametre_rubrique on tperso_parametre_rubrique.id = tperso_detail_affectation_ribrique.refParametre
                inner join tperso_categorie_agent on tperso_categorie_agent.id = tperso_parametre_rubrique.refCategorieAgent
                inner join tperso_rubrique on tperso_rubrique.id = tperso_parametre_rubrique.refRubrique
                inner join tperso_categorie_rubrique on tperso_categorie_rubrique.id = tperso_rubrique.refCatRubrique
                where refEntetePaie = :id',
                ['id' => $id,'avances' => $totalAvance]
                
            );
            $output='';
            foreach ($data5 as $row) 
            {                                
               $totalNet=$row->totalNet;
            }


            $taux=0;
            $data6 = DB::table('tperso_detail_paiement_sal')
            ->select("taux")
            ->where([               
               ['refEntetePaie','=', $id]
           ])    
            ->get(); 
            $output='';
            foreach ($data6 as $row) 
            {                                
               $taux=$row->taux;
            }


            $ags="'Agent";
            //    
    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>BULLETIN DE PAIE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs5971619E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs61FA619A {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs7658BE13 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs7E1F66F0 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs82D98BB6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs2BD0FD01 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:748px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:68px;"></td>
                    <td style="height:0px;width:56px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:126px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:29px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:44px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:46px;"></td>
                    <td style="height:0px;width:15px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:8px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="16" style="width:488px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:169px;height:6px;"></td>
                    <td class="cs62ED362D" colspan="2" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:24px;"></td>
                    <td class="csFBB219FE" colspan="16" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                        <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                    </td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="16" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="16" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:21px;"></td>
                    <td class="cs612ED82F" colspan="16" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="4" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                    <td class="cs145AAE8A" colspan="2" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="4" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="16" style="width:488px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:169px;height:6px;"></td>
                    <td class="cs11B2FA6F" colspan="2" style="width:6px;height:6px;"></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td class="cs188E5F6F" colspan="26" style="width:694px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>BULLETIN&nbsp;DE&nbsp;PAIE&nbsp;&nbsp;N&#176;&nbsp;'.$codeBS.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:4px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:18px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:52px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:12px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:68px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:56px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:10px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:126px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:14px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:29px;height:18px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:51px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:1px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:8px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:17px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:18px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:38px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:108px;height:18px;"></td>
                    <td class="csDDFA3242" style="width:46px;height:18px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:16px;height:18px;"></td>
                    <td class="cs62ED362D" style="width:5px;height:18px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:52px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>NOMS&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="6" style="width:286px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$noms_agent.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:79px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CIMAK&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="9" style="width:244px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$codeAgent.'</nobr></td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="5" style="width:79px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>FONCTION&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="4" style="width:258px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$fonction_agent.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:79px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;CNSS&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="9" style="width:244px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$numCNSS.'</nobr></td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="6" style="width:147px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>DIV&nbsp;/&nbsp;COORD&nbsp;/&nbsp;SERVICE&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="3" style="width:190px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$name_serv_perso.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="3" style="width:78px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;IMPO&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="10" style="width:245px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$numImpot.'</td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="4" style="width:67px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>ADRESSE&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="5" style="width:270px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$Adresse.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="3" style="width:78px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;COMPTE&nbsp;&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="10" style="width:245px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$numcpteBanque.'</td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="3" style="width:78px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>BANQUE&nbsp;&nbsp;:</nobr></td>
                    <td class="cs612ED82F" colspan="10" style="width:245px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$BanqueAgant.'</td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:9px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:9px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:9px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:9px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:23px;"></td>
                    <td class="cs12FE94AA" colspan="6" style="width:80px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Taux&nbsp;du&nbsp;jour&nbsp;:</nobr></td>
                    <td class="cs612ED82F" style="width:66px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$taux.'&nbsp;FC</nobr></td>
                    <td class="cs101A94F7" style="width:56px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:13px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:13px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:13px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:13px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:13px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:13px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:24px;"></td>
                    <td class="cs61FA619A" colspan="18" style="width:473px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Libell&#233;</nobr></td>
                    <td class="cs2BD0FD01" colspan="3" style="width:145px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant$</nobr></td>
                    <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
                </tr>
                ';
                                                    
                                                                $output .= $this->showDetailSalaireBase($id); 
                                                    
                                                                $output.='
            ';
                                                    
                                                                $output .= $this->showDetailAvantage($id); 
                                                    
                                                                $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:24px;"></td>
                    <td class="cs58AC6944" colspan="18" style="width:473px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>MONTANT&nbsp;BRUT</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalBrut.'&nbsp;$</td>
                    <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
                </tr>
            ';
                                                    
                                                                $output .= $this->showDetailRetenu($id); 
                                                    
                                                                $output.='
            ';
                                                    
                                                                $output .= $this->showDetailAvanceSalaire($refAffectation,$refMois,$refAnne); 
                                                    
                                                                $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:24px;"></td>
                    <td class="cs58AC6944" colspan="6" style="width:88px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Net&nbsp;&#224;&nbsp;Payer&nbsp;:</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalNet.'&nbsp;$</nobr></td>
                    <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="2" style="width:146px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:12px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:12px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:12px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:12px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:12px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                    <td class="cs7658BE13" colspan="6" style="width:196px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;Signature&nbsp;de&nbsp;l'.$ags.'</nobr></td>
                    <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                    <td class="cs7658BE13" colspan="7" style="width:221px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Le&nbsp;service&nbsp;de&nbsp;Finance</nobr></td>
                    <td class="cs101A94F7" style="width:17px;height:24px;"></td>
                    <td class="cs7E1F66F0" colspan="5" style="width:195px;height:18px;line-height:15px;text-align:right;vertical-align:top;"><nobr>VISA&nbsp;DRH&nbsp;/&nbsp;AG&nbsp;/&nbsp;MD&nbsp;/&nbsp;GERANT</nobr></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:47px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:47px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:52px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:12px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:68px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:56px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:126px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:29px;height:47px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:51px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:8px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:47px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:38px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:108px;height:47px;"></td>
                    <td class="cs101A94F7" style="width:46px;height:47px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:47px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:47px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:205px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:229px;height:3px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="5" style="width:205px;height:3px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:3px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:3px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                    <td class="cs5971619E" colspan="7" style="width:205px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                    <td class="cs5971619E" colspan="7" style="width:229px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:1px;"></td>
                    <td class="cs5971619E" colspan="5" style="width:205px;height:1px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:4px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:4px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:205px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="7" style="width:229px;height:4px;"></td>
                    <td class="cs101A94F7" style="width:17px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="5" style="width:205px;height:4px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:16px;height:4px;"></td>
                    <td class="cs145AAE8A" style="width:5px;height:4px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:4px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:18px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:52px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:12px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:68px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:56px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:10px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:126px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:14px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:29px;height:18px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:51px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:1px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:8px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:17px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:18px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:38px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:108px;height:18px;"></td>
                    <td class="csE7D235EF" style="width:46px;height:18px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:16px;height:18px;"></td>
                    <td class="cs11B2FA6F" style="width:5px;height:18px;"></td>
                </tr>
            </table>
            </body>
            </html>

            '; 

    return $output;

}   

function showDetailSalaireBase($id)
{
    $data = DB::table('tperso_detail_paiement_sal')
    ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
    ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
    ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
    ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
    ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
    "montant","taux","tperso_entete_paiement.refAffectation")
    ->where([
        ['refEntetePaie','=', $id],
        ['name_categorie_rubrique','=', 'SALAIRE DE BASE']
    ])
    ->orderBy("tperso_detail_paiement_sal.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:4px;height:24px;"></td>
                <td class="cs22DF2452" colspan="18" style="width:473px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$row->name_rubrique.'</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant.'$</nobr></td>
                <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
            </tr>
        ';
    }

    return $output;

}



function showDetailAvantage($id)
{
    $data = DB::table('tperso_detail_paiement_sal')
    ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
    ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
    ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
    ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
    ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
    "montant","taux","tperso_entete_paiement.refAffectation")
    ->where([
        ['refEntetePaie','=', $id],
        ['name_categorie_rubrique','=', 'AVANTAGE']
    ])
    ->orderBy("tperso_detail_paiement_sal.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:4px;height:24px;"></td>
                <td class="csE71035DC" colspan="18" style="width:473px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->name_rubrique.'</td>
                <td class="cs82D98BB6" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
                <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
            </tr>
        ';

    }

    return $output;

}

function showDetailRetenu($id)
{
    $data = DB::table('tperso_detail_paiement_sal')
    ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
    ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
    ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
    ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
    ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
    ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
    ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
    ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
    "montant","taux","tperso_entete_paiement.refAffectation")
    ->where([
        ['refEntetePaie','=', $id],
        ['name_categorie_rubrique','=', 'RETENU']
    ])
    ->orderBy("tperso_detail_paiement_sal.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:4px;height:24px;"></td>
                <td class="csE71035DC" colspan="18" style="width:473px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->name_rubrique.'</td>
                <td class="cs82D98BB6" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant.'$</td>
                <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
            </tr>
        ';
    }

    return $output;

}

function showDetailAvanceSalaire($refAffectation,$refMois,$refAnne)
{
    $data = DB::table('tperso_avance_salaire')
    ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
    ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
    ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
    ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
    ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refServicePerso')
    ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refCategorieAgent')
    ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')

    ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
    "refAffectation","refAnne",'refMois','name_mois',"dateAffectation","codeAgent","numCNSS","numcpteBanque",
    "numImpot","BanqueAgant","autresDetail",
    "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
    "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
    "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
    "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
    "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
    ->where([
        ['refMois','=', $refMois],
        ['refAnne','=', $refAnne],
        ['refAffectation','=', $refAffectation]
    ])
    ->orderBy("tperso_avance_salaire.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {

        $output .='
        
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csBDA79072" style="width:4px;height:24px;"></td>
                <td class="cs58AC6944" colspan="18" style="width:473px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>AVANCE&nbsp;SUR&nbsp;SALAIRE</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:145px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montant_avance.'$</td>
                <td class="cs101A94F7" style="width:46px;height:24px;"></td>
                <td class="cs101A94F7" colspan="2" style="width:16px;height:24px;"></td>
                <td class="cs145AAE8A" style="width:5px;height:24px;"></td>
            </tr>
        
        ';

    }

    return $output;

}


//==================== RAPPORT JOURNALIER DES PAIEMENTS =================================

public function fetch_rapport_paiement_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiement($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportPaiement($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportPaiement($date1, $date2)
{

         //Info entreprises
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
        $bp='';
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
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $bp=$row->rccm;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
        }


        $salaire_base_paie=0;
        $fammiliale_paie= 0;
        $logement_paie= 0;
        $transport_paie= 0;
        $sal_brut_paie= 0;
        $sal_brut_imposable_paie= 0;
        $inss_qpo_paie= 0;
        $inss_qpp_paie= 0;
        $cnss_paie= 0;
        $inpp_paie= 0;
        $onem_paie= 0;
        $ipr_paie= 0;
        $net_paie=0;
                 
         // 
         $data2 =  DB::table('tperso_detail_paie_salaire')            
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

         ->select(DB::raw('ROUND(SUM(salaire_base_paie),0) as salaire_base_paie, ROUND(SUM(fammiliale_paie),0) as fammiliale_paie,
         ROUND(SUM(logement_paie),0) as logement_paie,ROUND(SUM(transport_paie),0) as transport_paie,
         ROUND(SUM(sal_brut_paie),0) as sal_brut_paie,ROUND(SUM(sal_brut_imposable_paie),0) as sal_brut_imposable_paie,
         ROUND(SUM(inss_qpo_paie),0) as inss_qpo_paie,ROUND(SUM(inss_qpp_paie),0) as inss_qpp_paie,
         ROUND(SUM(cnss_paie),0) as cnss_paie,ROUND(SUM(inpp_paie),0) as inpp_paie,
         ROUND(SUM(onem_paie),0) as onem_paie,ROUND(SUM(ipr_paie),0) as ipr_paie,
         ROUND(SUM(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)),0) as net_paie'))
         ->where([
            ['tperso_detail_paie_salaire.created_at','>=', $date1],
            ['tperso_detail_paie_salaire.created_at','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $salaire_base_paie=$row->salaire_base_paie;
            $fammiliale_paie= $row->fammiliale_paie;
            $logement_paie= $row->logement_paie;
            $transport_paie= $row->transport_paie;
            $sal_brut_paie= $row->sal_brut_paie;
            $sal_brut_imposable_paie= $row->sal_brut_imposable_paie;
            $inss_qpo_paie= $row->inss_qpo_paie;
            $inss_qpp_paie= $row->inss_qpp_paie;
            $cnss_paie= $row->cnss_paie;
            $inpp_paie= $row->inpp_paie;
            $onem_paie= $row->onem_paie;
            $ipr_paie= $row->ipr_paie;
            $net_paie=$row->net_paie;                           
         }

        
        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptListingPaie</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs96C832E3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                    .cs79F8CBE2 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                    .cs302BEDA6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                    .cs6738495F {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                    .cs95B50E2B {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs5B74C6EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:362px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:114px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:104px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:57px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:57px;"></td>
                    <td style="height:0px;width:40px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:61px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                    </td>
                    <td></td>
                    <td class="csA67C9637" colspan="16" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                        <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="16" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="16" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csECF45065" colspan="16" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="16" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs5DE5F832" colspan="16" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
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
                    <td class="csE93F7424" colspan="13" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>FEUILLE&nbsp;DE&nbsp;PAIE&nbsp;DU&nbsp;MOIS&nbsp;DE&nbsp;:&nbsp;du '.$date1.'&nbsp; au '.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs96C832E3" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="cs302BEDA6" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                    <td class="cs302BEDA6" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>FONCTION</nobr></td>
                    <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>SALAIRE</nobr><br/><nobr>DE.BASE</nobr></td>
                    <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ALL.&nbsp;FAM.</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>LOGEMENT</nobr></td>
                    <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>TRANSPORT</nobr></td>
                    <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TRAITEMENT</nobr><br/><nobr>BRUT</nobr></td>
                    <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BRUT</nobr><br/><nobr>IMPOSABLE</nobr></td>
                    <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS</nobr><br/><nobr>(QPO5%)</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;(QPP</nobr><br/><nobr>13%)</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;TOTAL</nobr><br/><nobr>(18%)</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INPP&nbsp;2%</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ONEM</nobr><br/><nobr>0.2%</nobr></td>
                    <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>CONTRIBUT</nobr><br/><nobr>(IPR)</nobr></td>
                    <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NET&nbsp;A&nbsp;PAYER</nobr></td>
                </tr>
                ';
                                                                            
                        $output .= $this->showPaiement($date1, $date2); 
                                                                            
                        $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs96C832E3" colspan="6" style="width:307px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$salaire_base_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$fammiliale_paie.'$</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$logement_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$transport_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_imposable_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpo_paie.'$</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpp_paie.'$</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$cnss_paie.'$</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inpp_paie.'$</nobr></td>
                    <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$onem_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$ipr_paie.'$</nobr></td>
                    <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$net_paie.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs5B74C6EF" colspan="6" style="width:305px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Abb&#233;&nbsp;Toussaint&nbsp;SERUTOKE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:31px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Admin.&nbsp;G&#233;n.&nbsp;et&nbsp;Mod&#233;rateur&nbsp;du&nbsp;coll&#232;ge&nbsp;de&nbsp;Direction</nobr></td>
                </tr>
            </table>
            </body>
            </html>
         
        ';  
       
        return $output; 

}

function showPaiement($date1, $date2)
{
    $data = DB::table('tperso_detail_paie_salaire')            
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
    "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')
    ->selectRaw('CONCAT("PAIE",YEAR(tperso_detail_paie_salaire.created_at),"",MONTH(tperso_detail_paie_salaire.created_at),"00",tperso_detail_paie_salaire.id) as codeBS')
    ->where([
        ['tperso_detail_paie_salaire.created_at','>=', $date1],
        ['tperso_detail_paie_salaire.created_at','<=', $date2]
    ])
    ->orderBy("tperso_detail_paie_salaire.created_at", "asc")
    ->get();

        $count =0;

    $output='';

    foreach ($data as $row) 
    { 
        $count ++;
        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs79F8CBE2" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
                <td class="cs6738495F" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
                <td class="cs6738495F" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->nom_poste.'</td>
                <td class="cs6738495F" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->salaire_base_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->fammiliale_paie.'$</nobr></td>
                <td class="cs6738495F" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->logement_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->transport_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_imposable_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpo_paie.'$</nobr></td>
                <td class="cs6738495F" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpp_paie.'$</nobr></td>
                <td class="cs6738495F" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->cnss_paie.'$</nobr></td>
                <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inpp_paie.'$</nobr></td>
                <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->onem_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->ipr_paie.'$</nobr></td>
                <td class="cs6738495F" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->netPaie.'$</nobr></td>
            </tr>
        ';    
   
    }

    return $output;

}


//==================== RAPPORT DETAIL DES PAIEMENTS PAR MOIS =======================================

public function fetch_rapport_paiement_date_mois(Request $request)
{
    //

    if ($request->get('refMois')&& $request->get('refAnne')) {
        // code...
        $refMois = $request->get('refMois');
        $refAnne = $request->get('refAnne');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementMois($refMois,$refAnne);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportPaiementMois($refMois,$refAnne);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportPaiementMois($refMois,$refAnne)
{

        //Info entreprises
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
        $bp='';
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
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $bp=$row->rccm;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
        }


        $salaire_base_paie=0;
        $fammiliale_paie= 0;
        $logement_paie= 0;
        $transport_paie= 0;
        $sal_brut_paie= 0;
        $sal_brut_imposable_paie= 0;
        $inss_qpo_paie= 0;
        $inss_qpp_paie= 0;
        $cnss_paie= 0;
        $inpp_paie= 0;
        $onem_paie= 0;
        $ipr_paie= 0;
        $net_paie=0;
                 
         // 
         $data2 =  DB::table('tperso_detail_paie_salaire')            
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

         ->select(DB::raw('ROUND(SUM(salaire_base_paie),0) as salaire_base_paie, ROUND(SUM(fammiliale_paie),0) as fammiliale_paie,
         ROUND(SUM(logement_paie),0) as logement_paie,ROUND(SUM(transport_paie),0) as transport_paie,
         ROUND(SUM(sal_brut_paie),0) as sal_brut_paie,ROUND(SUM(sal_brut_imposable_paie),0) as sal_brut_imposable_paie,
         ROUND(SUM(inss_qpo_paie),0) as inss_qpo_paie,ROUND(SUM(inss_qpp_paie),0) as inss_qpp_paie,
         ROUND(SUM(cnss_paie),0) as cnss_paie,ROUND(SUM(inpp_paie),0) as inpp_paie,
         ROUND(SUM(onem_paie),0) as onem_paie,ROUND(SUM(ipr_paie),0) as ipr_paie,
         ROUND(SUM(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)),0) as net_paie'))
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         { 
            $salaire_base_paie=$row->salaire_base_paie;
            $fammiliale_paie= $row->fammiliale_paie;
            $logement_paie= $row->logement_paie;
            $transport_paie= $row->transport_paie;
            $sal_brut_paie= $row->sal_brut_paie;
            $sal_brut_imposable_paie= $row->sal_brut_imposable_paie;
            $inss_qpo_paie= $row->inss_qpo_paie;
            $inss_qpp_paie= $row->inss_qpp_paie;
            $cnss_paie= $row->cnss_paie;
            $inpp_paie= $row->inpp_paie;
            $onem_paie= $row->onem_paie;
            $ipr_paie= $row->ipr_paie;
            $net_paie=$row->net_paie;                            
         }

           
         $name_annee='';
         $name_mois='';
         $data3 =  DB::table('tperso_detail_paie_salaire')            
         ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
         ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
         ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
          ->select("name_mois","name_annee")
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne]
        ])    
         ->get(); 
         $output='';
         foreach ($data3 as $row) 
         {                                
            $name_annee=$row->name_annee;
            $name_mois=$row->name_mois;                           
         }




        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptListingPaie</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs96C832E3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs79F8CBE2 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs302BEDA6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs6738495F {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs95B50E2B {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs5B74C6EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:362px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:104px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:61px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="16" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
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
                        <td class="csE93F7424" colspan="13" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>FEUILLE&nbsp;DE&nbsp;PAIE&nbsp;DU&nbsp;MOIS&nbsp;DE&nbsp;:&nbsp;'.$name_mois.'&nbsp;'.$name_annee.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs302BEDA6" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs302BEDA6" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>FONCTION</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>SALAIRE</nobr><br/><nobr>DE.BASE</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ALL.&nbsp;FAM.</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>LOGEMENT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>TRANSPORT</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TRAITEMENT</nobr><br/><nobr>BRUT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BRUT</nobr><br/><nobr>IMPOSABLE</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS</nobr><br/><nobr>(QPO5%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;(QPP</nobr><br/><nobr>13%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;TOTAL</nobr><br/><nobr>(18%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INPP&nbsp;2%</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ONEM</nobr><br/><nobr>0.2%</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>CONTRIBUT</nobr><br/><nobr>(IPR)</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NET&nbsp;A&nbsp;PAYER</nobr></td>
                    </tr>
                    ';
                                                                                
                            $output .= $this->showPaiementMois($refMois,$refAnne); 
                                                                                
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" colspan="6" style="width:307px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$salaire_base_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$fammiliale_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$logement_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$transport_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_imposable_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpo_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$cnss_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$onem_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$ipr_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$net_paie.'$</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs5B74C6EF" colspan="6" style="width:305px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Abb&#233;&nbsp;Toussaint&nbsp;SERUTOKE</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Admin.&nbsp;G&#233;n.&nbsp;et&nbsp;Mod&#233;rateur&nbsp;du&nbsp;coll&#232;ge&nbsp;de&nbsp;Direction</nobr></td>
                    </tr>
                </table>
                </body>
                </html>
         
        ';  
       
        return $output; 

}

function showPaiementMois($refMois,$refAnne)
{
    $data = DB::table('tperso_detail_paie_salaire')            
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
    "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')
    ->selectRaw('CONCAT("PAIE",YEAR(tperso_detail_paie_salaire.created_at),"",MONTH(tperso_detail_paie_salaire.created_at),"00",tperso_detail_paie_salaire.id) as codeBS')
    ->where([
        ['refMois','=', $refMois],
        ['refAnne','=', $refAnne]
    ])
    ->orderBy("noms_agent", "asc")
    ->get();

    $count=0;

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='

            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs79F8CBE2" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
            <td class="cs6738495F" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
            <td class="cs6738495F" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->nom_poste.'</td>
            <td class="cs6738495F" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->salaire_base_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->fammiliale_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->logement_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->transport_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_imposable_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpo_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->cnss_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->onem_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->ipr_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->netPaie.'$</nobr></td>
        </tr>
        
        ';

    }

    return $output;

}



//==================== RAPPORT DETAIL DES PAIEMENTS PAR MOIS POSTE =======================================

public function fetch_rapport_paiement_date_mois_poste(Request $request)
{
    //refPoste

    if ($request->get('refMois')&& $request->get('refAnne') && $request->get('refPoste')) {
        // code...
        $refMois = $request->get('refMois');
        $refAnne = $request->get('refAnne');
        $refPoste = $request->get('refPoste');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementMoisPoste($refMois,$refAnne,$refPoste);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportPaiementMois($refMois,$refAnne);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportPaiementMoisPoste($refMois,$refAnne,$refPoste)
{

        //Info entreprises
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
        $bp='';
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
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $bp=$row->rccm;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
        }


        $salaire_base_paie=0;
        $fammiliale_paie= 0;
        $logement_paie= 0;
        $transport_paie= 0;
        $sal_brut_paie= 0;
        $sal_brut_imposable_paie= 0;
        $inss_qpo_paie= 0;
        $inss_qpp_paie= 0;
        $cnss_paie= 0;
        $inpp_paie= 0;
        $onem_paie= 0;
        $ipr_paie= 0;
        $net_paie=0;
                 
         // 
         $data2 =  DB::table('tperso_detail_paie_salaire')            
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

         ->select(DB::raw('ROUND(SUM(salaire_base_paie),0) as salaire_base_paie, ROUND(SUM(fammiliale_paie),0) as fammiliale_paie,
         ROUND(SUM(logement_paie),0) as logement_paie,ROUND(SUM(transport_paie),0) as transport_paie,
         ROUND(SUM(sal_brut_paie),0) as sal_brut_paie,ROUND(SUM(sal_brut_imposable_paie),0) as sal_brut_imposable_paie,
         ROUND(SUM(inss_qpo_paie),0) as inss_qpo_paie,ROUND(SUM(inss_qpp_paie),0) as inss_qpp_paie,
         ROUND(SUM(cnss_paie),0) as cnss_paie,ROUND(SUM(inpp_paie),0) as inpp_paie,
         ROUND(SUM(onem_paie),0) as onem_paie,ROUND(SUM(ipr_paie),0) as ipr_paie,
         ROUND(SUM(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)),0) as net_paie'))
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne],
            ['refPoste','=', $refPoste]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         { 
            $salaire_base_paie=$row->salaire_base_paie;
            $fammiliale_paie= $row->fammiliale_paie;
            $logement_paie= $row->logement_paie;
            $transport_paie= $row->transport_paie;
            $sal_brut_paie= $row->sal_brut_paie;
            $sal_brut_imposable_paie= $row->sal_brut_imposable_paie;
            $inss_qpo_paie= $row->inss_qpo_paie;
            $inss_qpp_paie= $row->inss_qpp_paie;
            $cnss_paie= $row->cnss_paie;
            $inpp_paie= $row->inpp_paie;
            $onem_paie= $row->onem_paie;
            $ipr_paie= $row->ipr_paie;
            $net_paie=$row->net_paie;                            
         }

           
         $name_annee='';
         $name_mois='';
         $data3 =  DB::table('tperso_detail_paie_salaire')            
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
          ->select("name_mois","name_annee")
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne],
            ['tperso_affectation_agent.refPoste','=', $refPoste]
        ])    
         ->get(); 
         $output='';
         foreach ($data3 as $row) 
         {                                
            $name_annee=$row->name_annee;
            $name_mois=$row->name_mois;                           
         }




        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptListingPaie</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs96C832E3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs79F8CBE2 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs302BEDA6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs6738495F {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs95B50E2B {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs5B74C6EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:362px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:104px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:61px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="16" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
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
                        <td class="csE93F7424" colspan="13" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>FEUILLE&nbsp;DE&nbsp;PAIE&nbsp;DU&nbsp;MOIS&nbsp;DE&nbsp;:&nbsp;'.$name_mois.'&nbsp;'.$name_annee.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs302BEDA6" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs302BEDA6" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>FONCTION</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>SALAIRE</nobr><br/><nobr>DE.BASE</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ALL.&nbsp;FAM.</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>LOGEMENT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>TRANSPORT</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TRAITEMENT</nobr><br/><nobr>BRUT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BRUT</nobr><br/><nobr>IMPOSABLE</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS</nobr><br/><nobr>(QPO5%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;(QPP</nobr><br/><nobr>13%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;TOTAL</nobr><br/><nobr>(18%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INPP&nbsp;2%</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ONEM</nobr><br/><nobr>0.2%</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>CONTRIBUT</nobr><br/><nobr>(IPR)</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NET&nbsp;A&nbsp;PAYER</nobr></td>
                    </tr>
                    ';
                                                                                
                            $output .= $this->showPaiementMoisPoste($refMois,$refAnne,$refPoste); 
                                                                                
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" colspan="6" style="width:307px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$salaire_base_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$fammiliale_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$logement_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$transport_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_imposable_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpo_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$cnss_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$onem_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$ipr_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$net_paie.'$</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs5B74C6EF" colspan="6" style="width:305px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Abb&#233;&nbsp;Toussaint&nbsp;SERUTOKE</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Admin.&nbsp;G&#233;n.&nbsp;et&nbsp;Mod&#233;rateur&nbsp;du&nbsp;coll&#232;ge&nbsp;de&nbsp;Direction</nobr></td>
                    </tr>
                </table>
                </body>
                </html>
         
        ';  
       
        return $output; 

}

function showPaiementMoisPoste($refMois,$refAnne,$refPoste)
{
    $data = DB::table('tperso_detail_paie_salaire')            
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
    "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')
    ->selectRaw('CONCAT("PAIE",YEAR(tperso_detail_paie_salaire.created_at),"",MONTH(tperso_detail_paie_salaire.created_at),"00",tperso_detail_paie_salaire.id) as codeBS')
    ->where([
        ['refMois','=', $refMois],
        ['refAnne','=', $refAnne],
        ['tperso_affectation_agent.refPoste','=', $refPoste]
    ])
    ->orderBy("noms_agent", "asc")
    ->get();

    $count=0;

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='

            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs79F8CBE2" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
            <td class="cs6738495F" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
            <td class="cs6738495F" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->nom_poste.'</td>
            <td class="cs6738495F" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->salaire_base_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->fammiliale_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->logement_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->transport_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_imposable_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpo_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->cnss_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->onem_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->ipr_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->netPaie.'$</nobr></td>
        </tr>
        
        ';

    }

    return $output;

}


//==================== RAPPORT DETAIL DES PAIEMENTS PAR MOIS PROJET =======================================

public function fetch_rapport_paiement_date_mois_projet(Request $request)
{
    //refPoste

    if ($request->get('refMois')&& $request->get('refAnne') && $request->get('projet_id')) {
        // code...
        $refMois = $request->get('refMois');
        $refAnne = $request->get('refAnne');
        $projet_id = $request->get('projet_id');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementMoisProjet($refMois,$refAnne,$projet_id);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportPaiementMois($refMois,$refAnne);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}
function printRapportPaiementMoisProjet($refMois,$refAnne,$projet_id)
{

        //Info entreprises
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
        $bp='';
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
            $idNatEse=$row->rccm;
            $numImpotEse=$row->rccm;
            $busnessName=$row->nomSecteur;
            $bp=$row->rccm;
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
        }


        $salaire_base_paie=0;
        $fammiliale_paie= 0;
        $logement_paie= 0;
        $transport_paie= 0;
        $sal_brut_paie= 0;
        $sal_brut_imposable_paie= 0;
        $inss_qpo_paie= 0;
        $inss_qpp_paie= 0;
        $cnss_paie= 0;
        $inpp_paie= 0;
        $onem_paie= 0;
        $ipr_paie= 0;
        $net_paie=0;
                 
         // 
         $data2 =  DB::table('tperso_detail_paie_salaire')            
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

         ->select(DB::raw('ROUND(SUM(salaire_base_paie),0) as salaire_base_paie, ROUND(SUM(fammiliale_paie),0) as fammiliale_paie,
         ROUND(SUM(logement_paie),0) as logement_paie,ROUND(SUM(transport_paie),0) as transport_paie,
         ROUND(SUM(sal_brut_paie),0) as sal_brut_paie,ROUND(SUM(sal_brut_imposable_paie),0) as sal_brut_imposable_paie,
         ROUND(SUM(inss_qpo_paie),0) as inss_qpo_paie,ROUND(SUM(inss_qpp_paie),0) as inss_qpp_paie,
         ROUND(SUM(cnss_paie),0) as cnss_paie,ROUND(SUM(inpp_paie),0) as inpp_paie,
         ROUND(SUM(onem_paie),0) as onem_paie,ROUND(SUM(ipr_paie),0) as ipr_paie,
         ROUND(SUM(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)),0) as net_paie'))
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne],
            ['projet_id','=', $projet_id]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         { 
            $salaire_base_paie=$row->salaire_base_paie;
            $fammiliale_paie= $row->fammiliale_paie;
            $logement_paie= $row->logement_paie;
            $transport_paie= $row->transport_paie;
            $sal_brut_paie= $row->sal_brut_paie;
            $sal_brut_imposable_paie= $row->sal_brut_imposable_paie;
            $inss_qpo_paie= $row->inss_qpo_paie;
            $inss_qpp_paie= $row->inss_qpp_paie;
            $cnss_paie= $row->cnss_paie;
            $inpp_paie= $row->inpp_paie;
            $onem_paie= $row->onem_paie;
            $ipr_paie= $row->ipr_paie;
            $net_paie=$row->net_paie;                            
         }

           
         $name_annee='';
         $name_mois='';
         $data3 =  DB::table('tperso_detail_paie_salaire')            
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
          ->select("name_mois","name_annee")
         ->where([
            ['refMois','=', $refMois],
            ['refAnne','=', $refAnne],
            ['projet_id','=', $projet_id]
        ])    
         ->get(); 
         $output='';
         foreach ($data3 as $row) 
         {                                
            $name_annee=$row->name_annee;
            $name_mois=$row->name_mois;                           
         }




        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptListingPaie</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs96C832E3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs79F8CBE2 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs302BEDA6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:bold; font-style:normal; }
                        .cs6738495F {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:8px; font-weight:normal; font-style:normal; }
                        .cs95B50E2B {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs5B74C6EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:971px;height:362px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:104px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:61px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="10" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="6" style="width:144px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:144px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:144px;height:128px;" /></div>
                        </td>
                        <td></td>
                        <td class="csA67C9637" colspan="16" style="width:643px;height:24px;line-height:21px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="6" style="width:145px;height:128px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:145px;height:128px;">
                            <img alt="" src="'.$pic2.'" style="width:145px;height:128px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Adresse&nbsp;:'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:25px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csECF45065" colspan="16" style="width:643px;height:24px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Contact&nbsp;:'.$Tel1Ese.','.$Tel2Ese.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" style="width:643px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Website&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs5DE5F832" colspan="16" rowspan="2" style="width:643px;height:21px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>BP.'.$bp.'</nobr></td>
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
                        <td class="csE93F7424" colspan="13" style="width:565px;height:27px;line-height:25px;text-align:center;vertical-align:top;"><nobr>FEUILLE&nbsp;DE&nbsp;PAIE&nbsp;DU&nbsp;MOIS&nbsp;DE&nbsp;:&nbsp;'.$name_mois.'&nbsp;'.$name_annee.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs302BEDA6" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NOMS</nobr></td>
                        <td class="cs302BEDA6" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>FONCTION</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>SALAIRE</nobr><br/><nobr>DE.BASE</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ALL.&nbsp;FAM.</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>LOGEMENT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>IDEMNITE&nbsp;DE</nobr><br/><nobr>TRANSPORT</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TRAITEMENT</nobr><br/><nobr>BRUT</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BRUT</nobr><br/><nobr>IMPOSABLE</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS</nobr><br/><nobr>(QPO5%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;(QPP</nobr><br/><nobr>13%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INSS&nbsp;TOTAL</nobr><br/><nobr>(18%)</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>INPP&nbsp;2%</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>ONEM</nobr><br/><nobr>0.2%</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>CONTRIBUT</nobr><br/><nobr>(IPR)</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>NET&nbsp;A&nbsp;PAYER</nobr></td>
                    </tr>
                    ';
                                                                                
                            $output .= $this->showPaiementMoisProjet($refMois,$refAnne,$projet_id); 
                                                                                
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs96C832E3" colspan="6" style="width:307px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                        <td class="cs302BEDA6" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$salaire_base_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$fammiliale_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$logement_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$transport_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$sal_brut_imposable_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpo_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inss_qpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$cnss_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$inpp_paie.'$</nobr></td>
                        <td class="cs302BEDA6" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$onem_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$ipr_paie.'$</nobr></td>
                        <td class="cs302BEDA6" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$net_paie.'$</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs5B74C6EF" colspan="6" style="width:305px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Fais&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Abb&#233;&nbsp;Toussaint&nbsp;SERUTOKE</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:31px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs95B50E2B" colspan="9" style="width:262px;height:21px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Admin.&nbsp;G&#233;n.&nbsp;et&nbsp;Mod&#233;rateur&nbsp;du&nbsp;coll&#232;ge&nbsp;de&nbsp;Direction</nobr></td>
                    </tr>
                </table>
                </body>
                </html>
         
        ';  
       
        return $output; 

}
function showPaiementMoisProjet($refMois,$refAnne,$projet_id)
{
    $data = DB::table('tperso_detail_paie_salaire')            
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
    "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte')
    ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
    ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')
    ->selectRaw('CONCAT("PAIE",YEAR(tperso_detail_paie_salaire.created_at),"",MONTH(tperso_detail_paie_salaire.created_at),"00",tperso_detail_paie_salaire.id) as codeBS')
    ->where([
        ['refMois','=', $refMois],
        ['refAnne','=', $refAnne],
        ['projet_id','=', $projet_id]
    ])
    ->orderBy("noms_agent", "asc")
    ->get();

    $count=0;

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='

            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="cs79F8CBE2" style="width:28px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
            <td class="cs6738495F" colspan="4" style="width:174px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->noms_agent.'</td>
            <td class="cs6738495F" style="width:103px;height:22px;line-height:8px;text-align:center;vertical-align:middle;">'.$row->nom_poste.'</td>
            <td class="cs6738495F" style="width:46px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->salaire_base_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:41px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->fammiliale_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:59px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->logement_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->transport_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:58px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:56px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->sal_brut_imposable_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:39px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpo_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:44px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inss_qpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:57px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->cnss_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->inpp_paie.'$</nobr></td>
            <td class="cs6738495F" colspan="2" style="width:37px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->onem_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:49px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->ipr_paie.'$</nobr></td>
            <td class="cs6738495F" style="width:60px;height:22px;line-height:8px;text-align:center;vertical-align:middle;"><nobr>'.$row->netPaie.'$</nobr></td>
        </tr>
        
        ';

    }

    return $output;

}

    
    
}
