<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfLogistiqueController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    
//==================== RAPPORT JOURNALIER DES SORTIES =================================

public function fetch_rapport_detailvente_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportDetailVente($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportDetailVente($date1, $date2)
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
            $pic = $this->displayImg("fichier", 'logo.png');
            $siege=$row->nomForme;         
        }

         $totalFact=0;
                 
         // 
         $data2 =  DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
 
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }
//
           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
                <td></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailVente($date1,$date2); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente($date1, $date2)
{
    $data = DB::table('tlog_detail_sortie')
    ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
    ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie',"name_serv_perso",
    "name_categorie_service","refCatService",'nom_agent','dateSortie',
    'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
    'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
    ->selectRaw('(qteSortie*puSortie) as prixTotal')
    ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
    ->where([
        ['dateSortie','>=', $date1],
        ['dateSortie','<=', $date2]
    ])
    ->orderBy("tlog_detail_sortie.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->name_serv_perso.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}
//==================== RAPPORT DETAIL FACTURE SELON LES ORGANISATIONS =======================================

public function fetch_rapport_detailvente_date_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refService = $request->get('refService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Service($date1, $date2,$refService);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportDetailVente_Service($date1, $date2,$refService);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }  
    
}



function printRapportDetailVente_Service($date1, $date2,$refService)
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


         $totalFact=0;
                 
         //
         $data2 = DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;                           
         }
//
         $nom_departement='';

         $data3=DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
         ->select('tlog_detail_sortie.id','refEnteteSortie','refService','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
         'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
         'tlog_detail_sortie.author','tlog_detail_sortie.created_at',"name_serv_perso","name_categorie_service",
         "refCatService")
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_departement=$row->name_serv_perso;              
        }


          

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;SORTIES</nobr></td>
                <td></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_departement.'</td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;SORTIE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Service($date1,$date2,$refService); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente_Service($date1,$date2,$refService)
{
        $data = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','refService','puSortie','qteSortie','nom_agent','dateSortie',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tlog_detail_sortie.author',"name_serv_perso","name_categorie_service","refCatService",'tlog_detail_sortie.created_at')
        ->selectRaw('(qteSortie*puSortie) as prixTotal')
        ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
        ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService]
        ])
        ->orderBy("tlog_detail_sortie.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->name_serv_perso.'</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
                    <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'</td>
                    <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                </tr>
            ';
           
   
    }

    return $output;

}

//==================== RAPPORT DETAIL SORTIE BY MEDICAMENT =======================================

public function fetch_rapport_detailvente_date_produit(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refProduit')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refProduit = $request->get('refProduit');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Produit($date1, $date2,$refProduit);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportDetailVente_Produit($date1, $date2,$refProduit);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
}


function printRapportDetailVente_Produit($date1, $date2,$refProduit)
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

         $totalFact=0;
                 
         //
         $data2 = DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')       
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refProduit','=', $refProduit],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

         $designationProduit='';
         $categorieProduit='';

         $data3=DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
         ->select('tlog_detail_sortie.id','refEnteteSortie','refService','refProduit','puSortie','qteSortie',
         'nom_agent','dateSortie','libelle',"tlog_produit.designation","refCategorie","pu","unite",
         "tvente_categorie_produit.designation as Categorie",'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
         ->selectRaw('(qteSortie*puSortie) as prixTotal')
         ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture') 
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refProduit','=', $refProduit],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $designationProduit=$row->designation;
            $categorieProduit=$row->Categorie;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                <td></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$designationProduit.' - '.$categorieProduit.'</td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;VENTE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Produit($date1,$date2,$refProduit); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente_Produit($date1, $date2,$refProduit)
{
    $data = DB::table('tlog_detail_sortie')
    ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
    ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
    ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
    ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
    ->select('tlog_detail_sortie.id','refEnteteSortie','refService','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
    'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
    'tlog_detail_sortie.author','tlog_detail_sortie.created_at',"name_serv_perso","name_categorie_service",
    "refCatService")
    ->selectRaw('(qteSortie*puSortie) as prixTotal')
    ->selectRaw('CONCAT("BS",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
    ->where([
                ['dateSortie','>=', $date1],
                ['dateSortie','<=', $date2],
                ['refProduit','=', $refProduit]
            ])
    ->orderBy("tlog_detail_sortie.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->name_serv_perso.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
                <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'</td>
                <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            </tr>
        ';
           
   
    }

    return $output;

}


//==================== RAPPORT JOURNALIER DES ENTREES ===========================================================================

public function fetch_rapport_detailentree_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailEntree($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportDetailEntree($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportDetailEntree($date1, $date2)
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

         $totalFact=0;
                 
         // 
         $data2 =  DB::table('tlog_detail_entree')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')
 
         ->select(DB::raw('ROUND(SUM(qteEntree*puEntree),0) as TotalFacture'))
         ->where([
            ['dateEntree','>=', $date1],
            ['dateEntree','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;ENTREES</nobr></td>
                <td></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FOURNISSEUR</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;ENTREE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailEntree($date1,$date2); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailEntree($date1, $date2)
{
    $data = DB::table('tlog_detail_entree')
    ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
    ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
    ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')
    ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
    'qteEntree','noms','contact','mail','adresse','dateEntree',
    'libelle',"tlog_produit.designation","refCategorie","pu","unite",
    "tvente_categorie_produit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
    ->selectRaw('(qteEntree*puEntree) as prixTotal')
    ->selectRaw('CONCAT("BE",YEAR(dateEntree),"",MONTH(dateEntree),"00",refEnteteEntree) as codeFacture')
    ->where([
        ['dateEntree','>=', $date1],
        ['dateEntree','<=', $date2]
    ])
    ->orderBy("tlog_detail_entree.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateEntree.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteEntree.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puEntree.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}






//==================== RAPPORT JOURNALIER DES REQUISITIONS ===========================================================================

public function fetch_rapport_detailcmd_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailRequisition($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
        // $html = $this->printRapportDetailRequisition($date1, $date2);
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
    
}


function printRapportDetailRequisition($date1, $date2)
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


         $totalFact=0;
                 
         // 
         $data2 =  DB::table('tlog_detail_requisition')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_requisition.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
 
         ->select(DB::raw('ROUND(SUM(qteCmd*puCmd),0) as TotalFacture'))
         ->where([
            ['dateCmd','>=', $date1],
            ['dateCmd','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;ENTREES</nobr></td>
                <td></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FOURNISSEUR</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;ENTREE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailRequisition($date1,$date2); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailRequisition($date1, $date2)
{
    $data = DB::table('tlog_detail_requisition')
    ->join('tlog_produit','tlog_produit.id','=','tlog_detail_requisition.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
    ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
    ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
    ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
    'qteCmd','noms','contact','mail','adresse','dateCmd',
    'libelle',"tlog_produit.designation","refCategorie","pu","unite",
    "tvente_categorie_produit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
    ->selectRaw('(qteCmd*puCmd) as prixTotal')
    ->selectRaw('CONCAT("BE",YEAR(dateCmd),"",MONTH(dateCmd),"00",refEnteteCmd) as codeFacture')
    ->where([
        ['dateCmd','>=', $date1],
        ['dateCmd','<=', $date2]
    ])
    ->orderBy("tlog_detail_requisition.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateCmd.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteCmd.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puCmd.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}


//=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================


function pdf_fiche_stock_logistique(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $html = $this->getInfoFicheStock($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();        
    }
    else{

    }   
    
}

function pdf_fiche_stock_logistique_cayegorie(Request $request)
{

   if ($request->get('date1') && $request->get('date2')&& $request->get('idCategorie')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idCategorie = $request->get('idCategorie');

        $html = $this->getInfoFicheStockCategorie($date1,$date2,$idCategorie);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();        
    }
    else{

    } 
    
}


function pdf_fiche_stock_logistique_emplacement(Request $request)
{

   if ($request->get('date1') && $request->get('date2')&& $request->get('idEmplacement')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idEmplacement = $request->get('idEmplacement');

        $html = $this->getInfoFicheStockParEmplacement($date1,$date2,$idEmplacement);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();        
    }
    else{

    } 
    
}


function getInfoFicheStock($date1,$date2)
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
           foreach ($data1 as $row1) 
           {                                
               $nomEse=$row1->nomEntreprise;
               $adresseEse=$row1->adresseEntreprise;
               $Tel1Ese=$row1->telephoneEntreprise;
               $Tel2Ese=$row1->telephone;
               $siteEse=$row1->siteweb;
               $emailEse=$row1->emailEntreprise;
               $idNatEse=$row1->rccm;
               $numImpotEse=$row1->rccm;
               $busnessName=$row1->nomSecteur;
               $rccmEse=$row1->rccm;
               $pic = $this->displayImg("fichier", 'logo.png');
               $siege=$row1->nomForme;         
           }
               // 
            $totalVente=0;  
            //
            $data2 = DB::table('tlog_detail_sortie')
            ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
            ->where([ 
                ['tlog_entete_sortie.dateSortie','>=', $date1],
                ['tlog_entete_sortie.dateSortie','<=', $date2]
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalVente=$row2->TotalFacture;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;SORTIE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStock($date1,$date2); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}

function showCategorieFicheStock($date1,$date2)
{
    $data = DB::table("tvente_categorie_produit")
    ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", 
    "tvente_categorie_produit.created_at", "tvente_categorie_produit.author")
    ->orderBy("tvente_categorie_produit.designation", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->designation.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStock($date1,$date2,$row->id);                                                     
                $output.='
        ';      
    }

    return $output;

}

function getInfoFicheStockCategorie($date1,$date2,$idCategorie)
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
           foreach ($data1 as $row1) 
           {                                
               $nomEse=$row1->nomEntreprise;
               $adresseEse=$row1->adresseEntreprise;
               $Tel1Ese=$row1->telephoneEntreprise;
               $Tel2Ese=$row1->telephone;
               $siteEse=$row1->siteweb;
               $emailEse=$row1->emailEntreprise;
               $idNatEse=$row1->rccm;
               $numImpotEse=$row1->rccm;
               $busnessName=$row1->nomSecteur;
               $rccmEse=$row1->rccm;
               $pic = $this->displayImg("fichier", 'logo.png');
               $siege=$row1->nomForme;         
           }
               // 
            $totalVente=0;  
            //
            $data2 = DB::table('tlog_detail_sortie')
            ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
            ->where([ 
                ['tlog_entete_sortie.dateSortie','>=', $date1],
                ['tlog_entete_sortie.dateSortie','<=', $date2],
                ['tlog_produit.refCategorie','=', $idCategorie]
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalVente=$row2->TotalFacture;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;SORTIE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStockParCategorie($date1,$date2,$idCategorie); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}

function showCategorieFicheStockParCategorie($date1,$date2,$idCategorie)
{
    $data = DB::table("tvente_categorie_produit")
    ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", 
    "tvente_categorie_produit.created_at", "tvente_categorie_produit.author")
    ->where([
        ['tvente_categorie_produit.id','=', $idCategorie]
    ])
    ->orderBy("tvente_categorie_produit.designation", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->designation.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStock($date1,$date2,$row->id);                                                     
                $output.='
        ';      
    }

    return $output;

}
//============ POUR L'EMPLACEMENT =================================

function getInfoFicheStockParEmplacement($date1,$date2,$idEmplacement)
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
           foreach ($data1 as $row1) 
           {                                
               $nomEse=$row1->nomEntreprise;
               $adresseEse=$row1->adresseEntreprise;
               $Tel1Ese=$row1->telephoneEntreprise;
               $Tel2Ese=$row1->telephone;
               $siteEse=$row1->siteweb;
               $emailEse=$row1->emailEntreprise;
               $idNatEse=$row1->rccm;
               $numImpotEse=$row1->rccm;
               $busnessName=$row1->nomSecteur;
               $rccmEse=$row1->rccm;
               $pic = $this->displayImg("fichier", 'logo.png');
               $siege=$row1->nomForme;         
           }
               // 
            $totalVente=0;  
            //
            $data2 = DB::table('tlog_detail_sortie')
            ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
            ->join('tlog_emplacements','tlog_emplacements.id','=','tlog_produit.refEmplacement')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
            ->where([ 
                ['tlog_entete_sortie.dateSortie','>=', $date1],
                ['tlog_entete_sortie.dateSortie','<=', $date2],
                ['tlog_produit.refEmplacement','=', $idEmplacement]
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalVente=$row2->TotalFacture;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;SORTIE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStockParEmplacement($date1,$date2,$idEmplacement); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}

function showCategorieFicheStockParEmplacement($date1,$date2,$idEmplacement)
{
    $data = DB::table("tlog_emplacements")
    ->select("tlog_emplacements.id", "tlog_emplacements.nom_emplacement", 
    "tlog_emplacements.created_at", "tlog_emplacements.author")
    ->where([
        ['tlog_emplacements.id','=', $idEmplacement]
    ])
    ->orderBy("tlog_emplacements.nom_emplacement", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->nom_emplacement.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStockPourEmplacement($date1,$date2,$row->id);                                                     
                $output.='
        ';      
    }

    return $output;

}


//showCategorieFicheStockParEmplacement($date1,$date2,$idEmplacement)
//Dynamique=======================================================


function showDetailFicheStock($date1,$date2,$refCategorie)
{
    $data1 = DB::table('tlog_produit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')        
    ->select("tlog_produit.id","tlog_produit.designation as designation","refCategorie",
    "pu","unite","devise","qte","tvente_categorie_produit.designation as Categorie")
    ->where([
        ['tlog_produit.refCategorie','=', $refCategorie]
    ])
    ->orderBy("tlog_produit.designation", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSI=0;        
        $totalEntree=0;
        $totalG=0;
        $totalSortie=0;        
        $totalSF=0;
        $totalPT=0;
        $totalPU=0; 
        
        $totalVente=0;
        $totalApprov=0;
        $puVente=0; 
        //
        $data2 = DB::table('tlog_detail_entree')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([               
            ['tlog_entete_entree.dateEntree','<', $date1],
            ['tlog_produit.id','=', $row1->id]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalEntree=$row2->totalEntree;                           
        }

        $data3 = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalSortie'))
        ->where([               
            ['tlog_entete_sortie.dateSortie','<', $date1],
            ['tlog_produit.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalSortie=$row3->totalSortie;                           
        }            
       

        $data4 =   DB::select(
            'select (IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SI from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteEntree' => $totalEntree,'quanteSortie'=>$totalSortie]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalSI=$row4->SI;                           
         }

         $data5 = DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalSortie'))
         ->where([               
             ['tlog_entete_sortie.dateSortie','>=', $date1],
             ['tlog_entete_sortie.dateSortie','<=', $date2],
             ['tlog_produit.id','=', $row1->id]
         ])->get(); 
        
        foreach ($data5 as $row5) 
        {                                
           $totalVente=$row5->totalSortie;                           
        }

        $data6 = DB::table('tlog_detail_entree')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([ 
            ['tlog_entete_entree.dateEntree','>=', $date1],
            ['tlog_entete_entree.dateEntree','<=', $date2],
            ['tlog_produit.id','=', $row1->id]
        ])
        ->get();        
        foreach ($data6 as $row6) 
        {                                
           $totalApprov=$row6->totalEntree;                           
        }

        $data7 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0)) as totalG from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov]
        );         
        foreach ($data7 as $row7) 
        {                                
           $totalG=$row7->totalG;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SF from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov,'quanteSortie'=>$totalVente]
        );         
        foreach ($data8 as $row8) 
        {                                
           $totalSF=$row8->SF;                           
        }


        $data9 = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie*puSortie),0),0) as PTSortie'))
        ->where([               
            ['tlog_entete_sortie.dateSortie','>=', $date1],
            ['tlog_entete_sortie.dateSortie','<=', $date2],
            ['tlog_produit.id','=', $row1->id]
        ])->get(); 
       
       foreach ($data9 as $row9) 
       {                                
          $totalPT=$row9->PTSortie;                           
       }

        $data10 =   DB::select(
            'select ((IFNULL(ROUND(:PTVente,0),0))/(IFNULL(ROUND(:quantiteVente,0),0))) as PUVente from tlog_produit  
             where tlog_produit.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data10 as $row10) 
        { 
           $puVente=$row10->PUVente;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->designation.'</td>
                <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.'</td>
                <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalApprov.'</td>
                <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.'</td>
                <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.'</td>
                <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalVente.'</td>
                <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$puVente.'$</td>
                <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPT.'$</td>
            </tr>
        ';     
    }

    return $output;

}


function showDetailFicheStockPourEmplacement($date1,$date2,$refEmplacement)
{
    $data1 = DB::table('tlog_produit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
    ->join('tlog_emplacements','tlog_emplacements.id','=','tlog_produit.refEmplacement')        
    ->select("tlog_produit.id","tlog_produit.designation as designation","refCategorie","refEmplacement",
    "pu","unite","devise","qte","tvente_categorie_produit.designation as Categorie","nom_emplacement")
    ->where([
        ['tlog_produit.refEmplacement','=', $refEmplacement]
    ])
    ->orderBy("tlog_produit.designation", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSI=0;        
        $totalEntree=0;
        $totalG=0;
        $totalSortie=0;        
        $totalSF=0;
        $totalPT=0;
        $totalPU=0; 
        
        $totalVente=0;
        $totalApprov=0;
        $puVente=0; 
        //
        $data2 = DB::table('tlog_detail_entree')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([               
            ['tlog_entete_entree.dateEntree','<', $date1],
            ['tlog_produit.id','=', $row1->id]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalEntree=$row2->totalEntree;                           
        }

        $data3 = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalSortie'))
        ->where([               
            ['tlog_entete_sortie.dateSortie','<', $date1],
            ['tlog_produit.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalSortie=$row3->totalSortie;                           
        }            
       

        $data4 =   DB::select(
            'select (IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SI from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteEntree' => $totalEntree,'quanteSortie'=>$totalSortie]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalSI=$row4->SI;                           
         }

         $data5 = DB::table('tlog_detail_sortie')
         ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
         ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
         ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalSortie'))
         ->where([               
             ['tlog_entete_sortie.dateSortie','>=', $date1],
             ['tlog_entete_sortie.dateSortie','<=', $date2],
             ['tlog_produit.id','=', $row1->id]
         ])->get(); 
        
        foreach ($data5 as $row5) 
        {                                
           $totalVente=$row5->totalSortie;                           
        }

        $data6 = DB::table('tlog_detail_entree')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([ 
            ['tlog_entete_entree.dateEntree','>=', $date1],
            ['tlog_entete_entree.dateEntree','<=', $date2],
            ['tlog_produit.id','=', $row1->id]
        ])
        ->get();        
        foreach ($data6 as $row6) 
        {                                
           $totalApprov=$row6->totalEntree;                           
        }

        $data7 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0)) as totalG from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov]
        );         
        foreach ($data7 as $row7) 
        {                                
           $totalG=$row7->totalG;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SF from tlog_produit  
             where (tlog_produit.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$totalApprov,'quanteSortie'=>$totalVente]
        );         
        foreach ($data8 as $row8) 
        {                                
           $totalSF=$row8->SF;                           
        }


        $data9 = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie*puSortie),0),0) as PTSortie'))
        ->where([               
            ['tlog_entete_sortie.dateSortie','>=', $date1],
            ['tlog_entete_sortie.dateSortie','<=', $date2],
            ['tlog_produit.id','=', $row1->id]
        ])->get(); 
       
       foreach ($data9 as $row9) 
       {                                
          $totalPT=$row9->PTSortie;                           
       }

        $data10 =   DB::select(
            'select ((IFNULL(ROUND(:PTVente,0),0))/(IFNULL(ROUND(:quantiteVente,0),0))) as PUVente from tlog_produit  
             where tlog_produit.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data10 as $row10) 
        { 
           $puVente=$row10->PUVente;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->designation.'</td>
                <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.'</td>
                <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalApprov.'</td>
                <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.'</td>
                <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.'</td>
                <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalVente.'</td>
                <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$puVente.'$</td>
                <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPT.'$</td>
            </tr>
        ';     
    }

    return $output;

}


}
