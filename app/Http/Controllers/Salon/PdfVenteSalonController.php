<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfVenteSalonController extends Controller
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

    
//==================== RAPPORT JOURNALIER DES VenteS =================================

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
         $data2 =  DB::table('tsalon_detail_vente')
         ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
         ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
         ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
         ->selectRaw('ROUND(SUM(qteVente*puVente),0) as TotalFacture')
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2]
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
    $data = DB::table('tsalon_detail_vente')
    ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
    ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
    ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
    'libelle',"tsalon_produit.designation","pu","unite",
    'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
    'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
    'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
    'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
    ->selectRaw('(qteVente*puVente) as PTVente')
    ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
    ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
    ->selectRaw('CONCAT("VS",YEAR(dateVente),"",MONTH(dateVente),"00",tsalon_detail_vente.refEnteteVente) as codeFacture')
    ->where([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2]
    ])
    ->orderBy("tsalon_detail_vente.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'  : ('.$row->RestePaie.'$)</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
    </tr>';      
   
    }

    return $output;

}

//==================== RAPPORT DETAIL Vente BY PRODUIT =======================================

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
         $data2 =DB::table('tsalon_detail_vente')
         ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
         ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
         ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
         ->selectRaw('ROUND(SUM(qteVente*puVente),0) as TotalFacture')
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refProduit','=', $refProduit],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

         $designationProduit='';

         $data3 = DB::table('tsalon_detail_vente')
         ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
         ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
         ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
         ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
         'libelle',"tsalon_produit.designation","pu","unite",
         'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
         'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
         'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
         'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
         'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
         ->selectRaw('(qteVente*puVente) as PTVente')
         ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
         ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC') 
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['refProduit','=', $refProduit],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $designationProduit=$row->designation;             
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
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$designationProduit.'</td>
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
    $data = DB::table('tsalon_detail_vente')
    ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
    ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
    ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
    ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
    'libelle',"tsalon_produit.designation","pu","unite",
    'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
    'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
    'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
    'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
    ->selectRaw('(qteVente*puVente) as PTVente')
    ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
    ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
    ->selectRaw('CONCAT("VS",YEAR(dateVente),"",MONTH(dateVente),"00",tsalon_detail_vente.refEnteteVente) as codeFacture')
    ->where([
                ['dateVente','>=', $date1],
                ['dateVente','<=', $date2],
                ['refProduit','=', $refProduit]
            ])
    ->orderBy("tsalon_detail_vente.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;&nbsp;</td>
                <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.' : ('.$row->RestePaie.'$)</td>
                <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puVente.'</td>
                <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
            </tr>
        ';
           
   
    }

    return $output;

}












}
