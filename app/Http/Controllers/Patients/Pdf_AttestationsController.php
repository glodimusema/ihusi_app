<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_AttestationsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


     //===================== RAPPORT MEDICAL ====================================================================
    //===========================================================================================================================


    function pdf_rapportmedical_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoRapportMedical($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoRapportMedical($id)
    {

                $titres="RAPPORT MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $datenaissance='';
                $datemvt='';
                $lieunaissance='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $plaintes='';
                $historiques='';
                $antecedents='';
                $examenohysique='';
                $diagnostics='';
                $examenparacliniques='';
                $traitements='';
                $evolutions='';
                $conclusions='';
                $codeOperation='';
                
                
                $data = DB::table('tdata_rapportmedical')
                ->join('vcarte','vcarte.numeroCarte','=','tdata_rapportmedical.refPatient')
                ->select("tdata_rapportmedical.id",'refPatient','plainte_med','historique_med','antecedent_med',
                'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med','sexe_profil',
                'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author',"Hopital",
                'refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
                'telephone_profil','datenaissance_profil','groupesanguin','photo_profil',
                'tdata_rapportmedical.created_at','tdata_rapportmedical.updated_at')
                ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
                ->where('tdata_rapportmedical.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms_profil;
                    $categorie="Patient";
                    $sexe=$row->sexe_profil;                
                    $datenaissance=$row->datenaissance_profil;
                    $datemvt=$row->created_at;
                    $lieunaissance='';
                    $societe=$row->Hopital;
                    $medecin=$row->medecin_med;
                    $speciaite=$row->specialite_med;
                    $cnom=$row->cnom_med;

                    $plaintes=$row->plainte_med;
                    $historiques=$row->historique_med;
                    $antecedents=$row->antecedent_med;
                    $examenohysique=$row->examenphysique_med;
                    $diagnostics=$row->diagnostic_med;
                    $examenparacliniques=$row->examenparaclinique_med;
                    $traitements=$row->traitement_med;
                    $evolutions=$row->evolution_med;
                    $conclusions=$row->libelle_med;
                    $codeOperation='00000';            
                }

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
                $slogan='';
                $pic='';
                $pic2 = $this->displayImg("images", 'logo.png');
                $logo='';
                $id=1;
        
                $data1 = DB::table('entreprises')
                ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
                ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
        
                ->join('pays','pays.id','=','entreprises.idPays')
                ->join('provinces','provinces.id','=','entreprises.idProvince')
                ->join('users','users.id','=','entreprises.ceo')
                
                ->select('entreprises.id as id','entreprises.id as idEntreprise',
                'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise',
                'entreprises.adresseEntreprise','entreprises.telephoneEntreprise','entreprises.solutionEntreprise',
                'entreprises.idsecteur','entreprises.idforme','entreprises.etat','entreprises.idPays','entreprises.idProvince',
                'entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb',
                'entreprises.rccm','entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
                'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
                'forme_juridiques.nomForme','secteurs.nomSecteur','users.name','users.email','users.avatar',
                'users.telephone','users.adresse',
                'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
                ->where('entreprises.id', $id)
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
                    $idNatEse=$row->invPersonnel;
                    $numImpotEse=$row->rccm;
                    $busnessName=$row->nomSecteur;
                    $rccmEse=$row->rccm;
                    $pic = $this->displayImg("images", "logo.png");
                    $siege=$row->nomForme;
                    $slogan=$row->facebook;         
                }

        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs990B052E {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:891px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:100px;"></td>
                        <td style="height:0px;width:154px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:69px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:169px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="9" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="9" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="9" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="9" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:169px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs7D52592D" colspan="14" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;MEDICAL</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:49px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:100px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:154px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:61px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:36px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:69px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:195px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;">Structure Sanitaire</td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:147px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Naissance&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$datenaissance.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:147px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;'.$signess.'&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$datemvt.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;PLAINTES&nbsp;PRINCIPALES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$plaintes.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>III.&nbsp;HISTORIQUE&nbsp;DE&nbsp;LA&nbsp;MALADIE</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$historiques.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>IV.&nbsp;ANTECEDENTS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$antecedents.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>V.&nbsp;EXAMEN&nbsp;PHYSIQUE</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$examenohysique.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VI.&nbsp;DIAGNOSTIC</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$diagnostics.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VII.&nbsp;EXAMENS&nbsp;PARACLINIQUES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$examenparacliniques.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VIII.&nbsp;TRAITEMENT</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$traitements.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>IX.&nbsp;EVOLUTIONS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$evolutions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>X.&nbsp;CONCLUSION</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:47px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:47px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:47px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:25px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:49px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:100px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:154px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:61px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:36px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:69px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:195px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }




    


    
    

    
}
