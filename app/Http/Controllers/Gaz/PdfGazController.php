<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
use IlluminateSupportFacadesDB;

class PdfGazController extends Controller
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

public function fetch_rapport_gaz_detailvente_date(Request $request)
{
    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html);        

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
 

         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente')
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }

           

        $output='

           <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportVentes</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:84px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:71px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:179px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:31px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                    <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>--</nobr></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                    <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>KIT</nobr></td>
                    <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>COMPOSANT</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                    <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                    <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailVente($date1, $date2); 

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
                    <td></td>
                    <td></td>
                    <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                    <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                    <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                    <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
            </html>
        
        ';  
       
        return $output; 

}
function showDetailVente($date1, $date2)
{
    $data = DB::table('tgaz_detail_vente')
    ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

    ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
    ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
    ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
    ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
    ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
    ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
    ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
    'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
    'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
    'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
    'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
    'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
    'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
    'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
    //Stock service
    'tgaz_stock_service_lot.refService as refService_StockServ',
    'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
    //Parametre flot
    'refProduit','pu_param','qte_param','autre_detail',
    'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
    "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
    'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
    "tvente_categorie_produit.designation as Categorie",
    //Entete Vente
    'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
    'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
    'etat_facture',
    
    'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

    ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
    'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
    'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
    )
    ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
    ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
    ->selectRaw('ROUND(montanttva,2) as montanttva')
    ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
    ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
    ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
    ->where([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2]
    ])
    ->orderBy("tgaz_detail_vente.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 

        $output .='
             <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->totalFacture.'$</td>
            </tr>
        ';   
   
    }

    return $output;

}

//==================== RAPPORT DETAIL FACTURE SELON LES SERVICES =======================================

public function fetch_rapport_detailvente_date_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Service($date1, $date2,$idService);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailVente_Service($date1, $date2,$idService)
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
 



         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente') 
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_entete_vente.refService','=', $idService],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }




         $services='';         

         $data3=DB::table('tvente_services')        
         ->select('nom_service')
         ->where([
            ['tvente_services.id','=', $idService]
        ])      
        ->first(); 
        if ($data3) 
        {
            $services=$data3->nom_service;              
        }

        $output='';          

        $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_RapportVentes</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:84px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:73px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:82px;"></td>
                        <td style="height:0px;width:179px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:58px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                        <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$services.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                        <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                        <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>KIT</nobr></td>
                        <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CONPOSANT</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                        <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                        <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                    </tr>
                    ';

                            $output .= $this->showDetailVente_Service($date1,$date2,$idService); 

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
                        <td></td>
                        <td></td>
                        <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                        <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                        <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                        <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                        <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                </html>        
        ';  
       
        return $output; 

}
function showDetailVente_Service($date1,$date2,$idService)
{
        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_services.id','=', $idService]
        ])
        ->orderBy("tgaz_detail_vente.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->Categorie.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'$</td>
            </tr>
        '; 
           
   
    }

    return $output;

}

//==================== RAPPORT DETAIL FACTURE SELON LES ORGANISATIONS =======================================

public function fetch_rapport_detailvente_date_etat_facture_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('etat_facture')&& $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $etat_facture = $request->get('etat_facture');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_EtatFacture_Service($date1, $date2,$etat_facture,$idService);       
        $html .='<script>window.print()</script>';

        echo($html); 

    } else {
        // code...
    }  
    
}
function printRapportDetailVente_EtatFacture_Service($date1, $date2,$etat_facture,$idService)
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
 



         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente')
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
          ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_entete_vente.etat_facture','=', $etat_facture],
            ['tgaz_entete_vente.refService','=', $idService]
        ])    
         ->get(); 
         //$idService
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }

         $CategorieClient = $etat_facture;  
         
         $services='';

         $data3= DB::table('tgaz_entete_vente')
         ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
         ->select('etat_facture','nom_service')
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_entete_vente.etat_facture','=', $etat_facture],
            ['tvente_services.id','=', $idService]
        ])      
        ->first();
        if ($data3) 
        {
            $services=$data3->nom_service;              
        }

        $output='';

        $output='

               <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_RapportVentes</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:84px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:73px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:82px;"></td>
                        <td style="height:0px;width:179px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:58px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                        <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$services.' : '.$etat_facture.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                        <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                        <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;PROD.</nobr></td>
                        <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                        <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                        <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                    </tr>
                    ';

                            $output .= $this->showDetailVente_EtatfactureService($date1,$date2,$etat_facture,$idService); 

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
                        <td></td>
                        <td></td>
                        <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                        <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                        <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                        <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                        <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                </html>
        
        ';  
       
        return $output; 

}
function showDetailVente_EtatfactureService($date1,$date2,$etat_facture,$idService)
{
        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_entete_vente.etat_facture','=', $etat_facture],
            ['tvente_services.id','=', $idService]
        ])
        ->orderBy("tgaz_detail_vente.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'$</td>
            </tr>
        '; 
           
   
    }

    return $output;

}

//==================== RAPPORT DETAIL Vente BY MEDICAMENT =======================================

public function fetch_rapport_detailvente_date_produit(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refLot')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refLot = $request->get('refLot');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Produit($date1, $date2,$refLot);       
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
function printRapportDetailVente_Produit($date1, $date2,$refLot)
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
 

         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente')
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')  
         ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')
         ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')      
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_lot.id','=', $refLot],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }


         $designationProduit='';
         $categorieProduit='';

         $data3=DB::table('tgaz_lot')
         ->select('tgaz_lot.id','nom_lot','code_lot') 
         ->where([
            ['tgaz_lot.id','=', $refLot],
        ])      
        ->get(); 
        foreach ($data3 as $row) 
        {
            $designationProduit=$row->nom_lot;
            $categorieProduit=$row->code_lot;                   
        }

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportVentes</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:84px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:71px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:179px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:31px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                    <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$designationProduit.' - '.$categorieProduit.'</nobr></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                    <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>KIT</nobr></td>
                    <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>COMPOSANT</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                    <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                    <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailVente_Produit($date1, $date2,$refLot); 

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
                    <td></td>
                    <td></td>
                    <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                    <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                    <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                    <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
            </html>

        ';  
       
        return $output; 

}
function showDetailVente_Produit($date1, $date2,$refLot)
{
    $data = DB::table('tgaz_detail_vente')
    ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

    ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
    ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
    ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
    ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
    ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
    ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
    ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
    'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
    'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
    'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
    'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
    'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
    'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
       ->where([
                ['dateVente','>=', $date1],
                ['dateVente','<=', $date2],
                ['tgaz_lot.id','=', $refLot]
            ])
      ->orderBy("tgaz_detail_vente.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'$</td>
            </tr>
        ';          
   
    }

    return $output;

}

//================= RAPPORT JOURNALIER DES VENTES SERVICE PRODUIT =============================================

public function fetch_rapport_detailvente_date_service_byproduit(Request $request)
{
    if ($request->get('date1') && $request->get('date2')&& $request->get('idService') && $request->get('idProduit')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');
        $idFlot = $request->get('idProduit');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Service_Produit($date1, $date2,$idService,$idFlot);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailVente_Service_Produit($date1, $date2,$idService,$idFlot)
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
 



         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente')         
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')
         ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tgaz_entete_vente.refService','=', $idService],
            ['tgaz_lot.id','=', $idFlot],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }




         $services='';
         $nom_produit='';

         $date_lot=DB::table('tgaz_lot')
         ->select('tgaz_lot.id','nom_lot','code_lot','unite_lot','stock_alerte')
         ->where([['tgaz_lot.id','=', $idFlot]])      
         ->first(); 
         if ($date_lot) 
         { 
             $nom_produit=$date_lot->nom_lot;            
         }


         $data_ser=DB::table('tvente_services')
         ->select('id','nom_service','status','active')
         ->where([['tvente_services.id','=', $idService]])      
         ->first(); 
         if ($data_ser) 
         { 
             $services = $data_ser->nom_service;            
         }

          
        $output='';

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_DetailFactureAbonne</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs8AAF79E9 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csE6D2AE99 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:925px;height:383px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:102px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:124px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:149px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:60px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="6" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                        <td class="cs101A94F7" colspan="4" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td class="cs56F73198" colspan="12" style="width:577px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$services.' - '.$nom_produit.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8AAF79E9" style="width:101px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                        <td class="cs8AAF79E9" colspan="3" style="width:230px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                        <td class="cs8AAF79E9" colspan="2" style="width:88px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACT.</nobr></td>
                        <td class="cs8AAF79E9" style="width:148px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                        <td class="cs8AAF79E9" style="width:42px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs8AAF79E9" style="width:59px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                        <td class="cs8AAF79E9" colspan="3" style="width:80px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PHT(USD)</nobr></td>
                        <td class="cs8AAF79E9" colspan="2" style="width:58px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;TVA</nobr></td>
                        <td class="csE6D2AE99" colspan="3" style="width:101px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PTTTC($)</nobr></td>
                    </tr>
                    ';

                            $output .= $this->showDetailVente_Service_Produit($date1,$date2,$idService,$idFlot); 

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
                        <td class="cs49AA1D99" colspan="2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                        <td class="cs9FE9304F" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'</nobr></td>
                        <td class="csEAC52FCD" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
        
        ';  
       
        return $output; 

}
function showDetailVente_Service_Produit($date1,$date2,$idService,$idFlot)
{
        $data = DB::table('tgaz_detail_vente')
    ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

    ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
    ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
    ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
    ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
    ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
    ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
    ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
    'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
    'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
    'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
    'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
    'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
    'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_services.id','=', $idService],
            ['tgaz_lot.id','=', $idFlot]
        ])
        ->orderBy("tgaz_detail_vente.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="cs6E02D7D2" style="width:148px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_lot.' - '.$row->designation.'</td>
                <td class="cs6E02D7D2" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="cs6E02D7D2" style="width:59px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVente.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montanttva.'</td>
                <td class="cs6C28398D" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'</td>
            </tr>
        '; 
           
   
    }

    return $output;

}

//==================== RAPPORT JOURNALIER DES ENTREES ===========================================================================

public function fetch_rapport_detail_production_date(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailProduction($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }
    
}

function printRapportDetailProduction($date1, $date2)
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
 

         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

         ->select(DB::raw('ROUND(SUM(((qteProduction * puProduction) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteProduction * puProduction) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateProduction','>=', $date1],
            ['dateProduction','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }


        $designationProduit='-';
        $categorieProduit='-';

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportVentes</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:84px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:71px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:179px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:31px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                    <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$designationProduit.' - '.$categorieProduit.'</nobr></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                    <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>KIT</nobr></td>
                    <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>UNITE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                    <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                    <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailProduction($date1, $date2); 

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
                    <td></td>
                    <td></td>
                    <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                    <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                    <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                    <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
            </html>

        ';  
       
        return $output; 

}
function showDetailProduction($date1, $date2)
{
    $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction + montanttva),2) as PTProductionTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteProduction * puProduction)/tgaz_detail_production.taux) as PTProductionFC')
       ->selectRaw('CONCAT("S",YEAR(dateProduction),"",MONTH(dateProduction),"00",refEnteteProduction) as codeFacture')
       ->where([
                ['dateProduction','>=', $date1],
                ['dateProduction','<=', $date2]
            ])
      ->orderBy("tgaz_detail_production.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_service.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateProduction.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->unite_lot.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteProduction.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puProduction.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTProduction.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTProductionTVA.'$</td>
            </tr>
        ';          
   
    }

    return $output;

}

//==================== RAPPORT DETAIL Vente BY MEDICAMENT =======================================

public function fetch_rapport_detail_production_date_produit(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refProduit')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refLot = $request->get('refLot');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailProduction_Produit($date1, $date2,$refLot);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }
    
}
function printRapportDetailProduction_Produit($date1, $date2,$refLot)
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
 

         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

         ->select(DB::raw('ROUND(SUM(((qteProduction * puProduction) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteProduction * puProduction) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateProduction','>=', $date1],
            ['dateProduction','<=', $date2],
            ['tgaz_lot.id','=', $refLot],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }


         $designationProduit='';
         $categorieProduit='';

         $data3=DB::table('tgaz_lot')
         ->select('tgaz_lot.id','nom_lot','code_lot') 
         ->where([
            ['tgaz_lot.id','=', $refLot],
        ])      
        ->get(); 
        foreach ($data3 as $row) 
        {
            $designationProduit=$row->nom_lot;
            $categorieProduit=$row->code_lot;                   
        }

        $output='';           

        $output='

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportVentes</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:84px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:71px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:179px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:31px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                    <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$designationProduit.' - '.$categorieProduit.'</nobr></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                    <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;PROD.</nobr></td>
                    <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                    <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                    <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailProduction_Produit($date1, $date2,$refLot); 

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
                    <td></td>
                    <td></td>
                    <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                    <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                    <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                    <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
            </html>

        ';  
       
        return $output; 

}
function showDetailProduction_Produit($date1, $date2,$refLot)
{
    $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction + montanttva),2) as PTProductionTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteProduction * puProduction)/tgaz_detail_production.taux) as PTProductionFC')
       ->selectRaw('CONCAT("S",YEAR(dateProduction),"",MONTH(dateProduction),"00",refEnteteProduction) as codeFacture')
       ->where([
                ['dateProduction','>=', $date1],
                ['dateProduction','<=', $date2],
                ['tgaz_lot.id','=', $refLot]
            ])
      ->orderBy("tgaz_detail_production.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->unite_lot.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'$</td>
            </tr>
        ';          
   
    }

    return $output;

}

//================= RAPPORT JOURNALIER DES VENTES SERVICE PRODUIT =============================================

public function fetch_rapport_detail_production_date_service_byproduit(Request $request)
{
    if ($request->get('date1') && $request->get('date2')&& $request->get('idService') && $request->get('idLot')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');
        $refLot = $request->get('idLot');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailProduction_Service_Produit($date1, $date2,$idService,$idLot);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailProduction_Service_Produit($date1, $date2,$idService,$idLot)
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
 



         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')
         
        ->select(DB::raw('ROUND(SUM(((qteProduction * cmupProduction) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteProduction * cmupProduction) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateProduction','>=', $date1],
            ['dateProduction','<=', $date2],
            ['tgaz_entete_production.refService','=', $idService],
            ['tgaz_lot.id','=', $idLot],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }

         $services='';
         $nom_produit='';

         $date_lot=DB::table('tgaz_lot')
         ->select('tgaz_lot.id','nom_lot','code_lot','unite_lot','stock_alerte')
         ->where([['tgaz_lot.id','=', $idFlot]])      
         ->first(); 
         if ($date_lot) 
         { 
             $nom_produit=$date_lot->nom_lot;            
         }


         $data_ser=DB::table('tvente_services')
         ->select('id','nom_service','status','active')
         ->where([['tvente_services.id','=', $idService]])      
         ->first(); 
         if ($data_ser) 
         { 
             $services = $data_ser->nom_service;            
         }

          
        $output='';

        $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_DetailFactureAbonne</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs8AAF79E9 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csE6D2AE99 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:925px;height:383px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:102px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:124px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:149px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:60px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:75px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="6" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                        <td class="cs101A94F7" colspan="4" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td class="cs56F73198" colspan="12" style="width:577px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$services.' - '.$nom_produit.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8AAF79E9" style="width:101px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                        <td class="cs8AAF79E9" colspan="3" style="width:230px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                        <td class="cs8AAF79E9" colspan="2" style="width:88px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACT.</nobr></td>
                        <td class="cs8AAF79E9" style="width:148px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                        <td class="cs8AAF79E9" style="width:42px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs8AAF79E9" style="width:59px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                        <td class="cs8AAF79E9" colspan="3" style="width:80px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PHT(USD)</nobr></td>
                        <td class="cs8AAF79E9" colspan="2" style="width:58px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;TVA</nobr></td>
                        <td class="csE6D2AE99" colspan="3" style="width:101px;height:22px;line-height:14px;text-align:center;vertical-align:middle;"><nobr>PTTTC($)</nobr></td>
                    </tr>
                    ';

                            $output .= $this->showDetailProduction_Service_Produit($date1,$date2,$idService,$idLot); 

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
                        <td class="cs49AA1D99" colspan="2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                        <td class="cs9FE9304F" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'</nobr></td>
                        <td class="csEAC52FCD" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>
        
        ';  
       
        return $output; 

}
function showDetailProduction_Service_Produit($date1,$date2,$idService,$idLot)
{
    $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")
       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction * puProduction) - montantreduction + montanttva),2) as PTProductionTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteProduction * puProduction)/tgaz_detail_production.taux) as PTProductionFC')
       ->selectRaw('CONCAT("S",YEAR(dateProduction),"",MONTH(dateProduction),"00",refEnteteProduction) as codeFacture')
        ->where([
            ['dateProduction','>=', $date1],
            ['dateProduction','<=', $date2],
            ['tvente_services.id','=', $idService],
            ['tgaz_lot.id','=', $idFlot]
        ])
        ->orderBy("tgaz_detail_production.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateProduction.'</td>
                <td class="cs6E02D7D2" style="width:148px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="cs6E02D7D2" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteProduction.'</td>
                <td class="cs6E02D7D2" style="width:59px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteProduction.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTProduction.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->montanttva.'</td>
                <td class="cs6C28398D" colspan="3" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->PTProductionTVA.'</td>
            </tr>
        '; 
           
   
    }

    return $output;

}

//=============== FICHE DE STOCK DES SERVICES BY CATEGORIE=======================================================================================

function pdf_fiche_stock_vente_service(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->getInfoFicheStockServices($date1,$date2,$idService);       
        $html .='<script>window.print()</script>';

        echo($html); 
        
    }
    else{
    }    
}

function getInfoFicheStockServices($date1,$date2,$idService)
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



           $totalVente = 0;
           $totalTransfert=0;
           $totalCMUP = 0;
           $globalTP=0;

           $data5 = DB::table('tgaz_detail_vente')
           ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')
           ->select(DB::raw('IFNULL(ROUND(SUM(qteVente * puVente),0),0) as totalSortie'))
           ->where([               
               ['tgaz_entete_vente.dateVente','>=', $date1],
               ['tgaz_entete_vente.dateVente','<=', $date2],
               ['tgaz_entete_vente.refService','=', $idService]
           ])->first(); 
           if ($data5) 
           {                                
              $totalVente=$data5->totalSortie;                           
           }  

           $CategorieClient='';
           $data3=DB::table('tvente_services')
           ->select('id','nom_service','status','active')
           ->where([
              ['tvente_services.id','=', $idService]
           ])->first();
           if ($data3) 
           {
               $CategorieClient=$data3->nom_service;              
           }

           $output='';

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
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK : '.$CategorieClient.'</nobr></td>
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
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;VENTE(USD)</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>                    
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStockService($date1,$date2,$idService); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

} 

function showCategorieFicheStockService($date1,$date2,$idService)
{
    $data = DB::table("tgaz_categorie_lot")
    ->select("tgaz_categorie_lot.id",'nom_categorie_lot',"tgaz_categorie_lot.created_at")
    ->orderBy("tgaz_categorie_lot.nom_categorie_lot", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->nom_categorie_lot.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStockServiceByCat($date1,$date2,$row->id,$idService);                                                     
                $output.='
        ';      
    }

    return $output;

}

function showDetailFicheStockServiceByCat($date1, $date2, $refCategorie, $idService)
{
    // Récupérer les données de stock, mouvements et ventes en une seule requête 
    $data11 = DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
        $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtEntree.type_mouvement', '=', 'Entree')
             ->where('dtEntree.dateMvt', '<', $date1);
    })

        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot as designation",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot as Categorie",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux",            
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteMvt), 3), 0) as totalEntree'),

        )
        ->where([
            ['tgaz_lot.refCategorieLot', '=', $refCategorie],
            ['tgaz_stock_service_lot.refService', '=', $idService]
        ])
        ->groupBy("tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux")
        ->orderBy("tgaz_lot.nom_lot", "asc")
        ->get();



    $data22 =  DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')

    ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
        $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtSortie.type_mouvement', '=', 'Sortie')
             ->where('dtSortie.dateMvt', '<', $date1);
    })
    // Utilisez distinct() avant select()
    ->distinct()
    ->select(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot as designation",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot as Categorie",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux",
        DB::raw('IFNULL(ROUND(SUM(dtSortie.qteMvt), 3), 0) as totalSortie')
    )
    ->where([
        ['tgaz_lot.refCategorieLot', '=', $refCategorie],
        ['tgaz_stock_service_lot.refService', '=', $idService]
    ])
    ->groupBy(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux"
        )
    ->orderBy("tgaz_lot.nom_lot", "asc")
    ->get();

    // ============ LEs Mouvements =========================================================================

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data1 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtEntree.type_mouvement', '=', 'Entree')
                 ->whereBetween('mvtEntree.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteMvt), 3), 0) as stockEntree'),
    
            )
            ->where([
                ['tgaz_lot.refCategorieLot', '=', $refCategorie],
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    
    //======================================================================
    
        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data2 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtSortie.type_mouvement', '=', 'Sortie')
                 ->whereBetween('mvtSortie.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteMvt), 3), 0) as stockSortie'),
    
            )
            ->where([
                ['tgaz_lot.refCategorieLot', '=', $refCategorie],
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    

    // Construction de l'output
    
    $output = '';

    // Vérifiez que les deux tableaux ont la même longueur
    if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
    && (count($data1) === count($data22)))
    {
        for ($i = 0; $i < count($data1); $i++) {
            $row11 = $data11[$i];
            $row22 = $data22[$i];
            $row1 = $data1[$i];
            $row2 = $data2[$i];            

            $totalSortie = floatval($row22->totalSortie);
            $totalEntree = floatval($row11->totalEntree);

            $stockSortie = floatval($row2->stockSortie);            
            $stockEntree = floatval($row1->stockEntree);

            $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
            $totalGEntree = floatval($stockEntree);
            $totalG = floatval($totalSI) + floatval($stockEntree);
            $TGSortie = floatval($stockSortie);
            $totalSF = floatval($totalG) - floatval($stockSortie);
            $totalPT = floatval($totalSF) * floatval($row2->cmup_lot);


            $output .= '
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->designation.'</td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.' '.$row1->unite_lot.'</td>
                    <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalGEntree.' '.$row1->unite_lot.' </td>
                    <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.' '.$row1->unite_lot.'</td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$TGSortie.' '.$row1->unite_lot.'</td>
                    <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.' '.$row1->unite_lot.'</td>                
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.round($row2->cmup_lot, 2).'$</td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.round($totalPT, 2).'$</td>
                </tr>
            ';   

    }
    } else {
        // Gérer le cas où les tableaux n'ont pas la même longueur
        echo 'Les tableaux ont pas la même longueur.';
    }

    return $output;
}

//========================== LES DETTES DES VENTES ========================================================================
//=========================================================================================================================



//==================== RAPPORT JOURNALIER DES VenteS =================================

public function fetch_rapport_gaz_detailvente_dette_date(Request $request)
{
    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVenteDette($date1, $date2);       
        $html .='<script>window.print()</script>';

        echo($html);        

    } else {
        // code...
    }
    
    
}
function printRapportDetailVenteDette($date1, $date2)
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
 

         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente')
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2]
        ]) 
        ->whereRaw("ROUND(IFNULL(montant, 0), 3) - ROUND(IFNULL(paie, 0), 3) > 0")   
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }

           

        $output='

           <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportVentes</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:3px;"></td>
                    <td style="height:0px;width:84px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:71px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:66px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:179px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:17px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:49px;"></td>
                    <td style="height:0px;width:31px;"></td>
                    <td style="height:0px;width:58px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                    <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    <td style="width:0px;height:32px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES EN CREDIT</nobr></td>
                    <td></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                    <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>--</nobr></td>
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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                    <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                    <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;PROD.</nobr></td>
                    <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                    <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                    <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                    <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailVenteDette($date1, $date2); 

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
                    <td></td>
                    <td></td>
                    <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                    <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                    <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                    <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                    <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
            </html>
        
        ';  
       
        return $output; 

}
function showDetailVenteDette($date1, $date2)
{
    $data = DB::table('tgaz_detail_vente')
    ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

    ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
    ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
    ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
    ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
    ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
    ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
    ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
    'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
    'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
    'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
    'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
    'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
    'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
    'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
    //Stock service
    'tgaz_stock_service_lot.refService as refService_StockServ',
    'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
    //Parametre flot
    'refProduit','pu_param','qte_param','autre_detail',
    'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
    "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
    'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
    "tvente_categorie_produit.designation as Categorie",
    //Entete Vente
    'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
    'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
    'etat_facture',
    
    'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

    ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
    'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
    'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
    )
    ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
    ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
    ->selectRaw('ROUND(montanttva,2) as montanttva')
    ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
    ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
    ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
    ->where([
        ['dateVente','>=', $date1],
        ['dateVente','<=', $date2]
    ])
    ->whereRaw("ROUND(IFNULL(montant, 0), 3) - ROUND(IFNULL(paie, 0), 3) > 0")
    ->orderBy("tgaz_detail_vente.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 

        $output .='
             <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->totalFacture.'$</td>
            </tr>
        ';   
   
    }

    return $output;

}

//==================== RAPPORT DETAIL FACTURE SELON LES SERVICES =======================================

public function fetch_rapport_detailvente_dette_date_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVenteDette_Service($date1, $date2,$idService);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailVenteDette_Service($date1, $date2,$idService)
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
 



         $sommePHT=0;
         $sommeTVA=0;
         $sommePTTF=0;
         // 
         $data2 =  DB::table('tgaz_detail_vente') 
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
         ->select(DB::raw('ROUND(SUM(((qteVente*puVente) - montantreduction)),4) as sommePHT, 
         ROUND(SUM(montanttva),4) as sommeTVA,
         ROUND(SUM(ROUND(((qteVente*puVente) - montantreduction + montanttva),4)),4) as sommePTTF'))
         ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_services.id','=', $idService],
        ])
        ->whereRaw("ROUND(IFNULL(montant, 0), 3) - ROUND(IFNULL(paie, 0), 3) > 0")    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $sommePHT=$row->sommePHT;
            $sommeTVA=$row->sommeTVA;
            $sommePTTF=$row->sommePTTF;                           
         }




         $services='';         

         $data3=DB::table('tvente_services')        
         ->select('nom_service')
         ->where([
            ['tvente_services.id','=', $idService]
        ])      
        ->first(); 
        if ($data3) 
        {
            $services=$data3->nom_service;              
        }

        $output='';          

        $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_RapportVentes</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs18F2469C {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs797456E3 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csFF9B7F36 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                        .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs8681714E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csD06EB5B2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                        .csBFBB3693 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:957px;height:383px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:84px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:51px;"></td>
                        <td style="height:0px;width:73px;"></td>
                        <td style="height:0px;width:66px;"></td>
                        <td style="height:0px;width:82px;"></td>
                        <td style="height:0px;width:179px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:58px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                        <td class="cs101A94F7" colspan="5" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="10" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="10" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csB6F858D0" colspan="11" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES EN CREDIT</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs56F73198" colspan="6" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                        <td class="cs56F73198" colspan="12" style="width:610px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$services.'</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9FE9304F" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                        <td class="cs9FE9304F" colspan="3" style="width:172px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                        <td class="cs9FE9304F" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:147px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;PROD.</nobr></td>
                        <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ARTICLE</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:36px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:39px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="csEAC52FCD" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PHT</nobr></td>
                        <td class="cs20251968" style="width:48px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TVA</nobr></td>
                        <td class="cs20251968" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PTTTC</nobr></td>
                    </tr>
                    ';

                            $output .= $this->showDetailVenteDette_Service($date1,$date2,$idService); 

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
                        <td></td>
                        <td></td>
                        <td class="cs18F2469C" colspan="4" style="width:75px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                        <td class="csFF9B7F36" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePHT.'$</nobr></td>
                        <td class="cs797456E3" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommeTVA.'$</nobr></td>
                        <td class="cs797456E3" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$sommePTTF.'$</nobr></td>
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
                        <td class="cs12FE94AA" colspan="4" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                </html>        
        ';  
       
        return $output; 

}
function showDetailVenteDette_Service($date1,$date2,$idService)
{
        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_services.id','=', $idService]
        ])
        ->whereRaw("ROUND(IFNULL(montant, 0), 3) - ROUND(IFNULL(paie, 0), 3) > 0")
        ->orderBy("tgaz_detail_vente.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td class="csD06EB5B2" style="width:83px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="csD06EB5B2" colspan="3" style="width:172px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="csD06EB5B2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->dateVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:147px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->Categorie.'</td>
                <td class="csD06EB5B2" style="width:178px;height:22px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->designation.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:36px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->qteVente.'</td>
                <td class="csD06EB5B2" colspan="2" style="width:39px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->puVente.'$</td>
                <td class="csBFBB3693" colspan="2" style="width:72px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVente.'$</td>
                <td class="cs8681714E" style="width:48px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->montanttva.'$</td>
                <td class="cs8681714E" colspan="2" style="width:88px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->PTVenteTVA.'$</td>
            </tr>
        '; 
           
   
    }

    return $output;

}




//==================== RAPPORT JOURNALIER DES VenteS =================================
//========================== IVENTAIRE DE STOCK =============================================================================

// function pdf_fiche_inventaire_service(Request $request)
// {

//     if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
//         // code...
//         $date1 = $request->get('date1');
//         $date2 = $request->get('date2');
//         $idService = $request->get('idService');
        
//         // $html = $this->getInfoInventaireServices($date1,$date2,$idService);
//         // $pdf = \App::make('dompdf.wrapper');

//         // $pdf->loadHTML($html);
//         // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
//         // return $pdf->stream();

//         $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
//         $html .= $this->getInfoInventaireServices($date1,$date2,$idService);       
//         $html .='<script>window.print()</script>';

//         echo($html);
        
//     }
//     else{
//     }    
// }
// function getInfoInventaireServices($date1,$date2,$idService)
// {
//            //Info Entreprise
//            $nomEse='';
//            $adresseEse='';
//            $Tel1Ese='';
//            $Tel2Ese='';
//            $siteEse='';
//            $emailEse='';
//            $idNatEse='';
//            $numImpotEse='';
//            $rccEse='';
//            $siege='';
//            $busnessName='';
//            $pic='';
//            $pic2 = $this->displayImg("fichier", 'logo.png');
//            $logo='';
   
//            $data1 = DB::table('entreprises')
//            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
//            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
   
//            ->join('pays','pays.id','=','entreprises.idPays')
//            ->join('provinces','provinces.id','=','entreprises.idProvince')
//            ->join('users','users.id','=','entreprises.ceo')        
//            ->select('entreprises.id as id','entreprises.id as idEntreprise',
//            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
//            'entreprises.emailEntreprise','entreprises.adresseEntreprise',
//            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
//            'entreprises.idforme','entreprises.etat',
//            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
//            'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
//            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
//            'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
//             //forme
//             'forme_juridiques.nomForme','secteurs.nomSecteur',
//             //users
//             'users.name','users.email','users.avatar','users.telephone','users.adresse',
//             //
//             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
//            ->first();
           
//            if ($data1) 
//            {                                
//                $nomEse=$data1->nomEntreprise;
//                $adresseEse=$data1->adresseEntreprise;
//                $Tel1Ese=$data1->telephoneEntreprise;
//                $Tel2Ese=$data1->telephone;
//                $siteEse=$data1->siteweb;
//                $emailEse=$data1->emailEntreprise;
//                $idNatEse=$data1->rccm;
//                $numImpotEse=$data1->rccm;
//                $busnessName=$data1->nomSecteur;
//                $rccmEse=$data1->rccm;
//                $pic = $this->displayImg("fichier", 'logo.png');
//                $siege=$data1->nomForme;         
//            }



//          $nom_service=''; 

//          $data3=DB::table('tvente_services')
//            ->select('id','nom_service','status','active')
//            ->where([
//               ['tvente_services.id','=', $idService]
//           ])      
//           ->first();
//           if ($data3) 
//           {
//               $nom_service=$data3->nom_service;              
//           }

//           $output='';

//         $output=' 

//            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//             <!-- saved from url=(0016)http://localhost -->
//             <html>
//             <head>
//                 <title>rptInventaire</title>
//                 <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
//                 <style type="text/css">
//                     .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
//                     .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
//                     .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
//                     .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
//                     .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
//                     .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
//                     .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
//                     .csD7F64717 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
//                     .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
//                     .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
//                 </style>
//             </head>
//             <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
//             <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:646px;height:362px;position:relative;">
//                 <tr>
//                     <td style="width:0px;height:0px;"></td>
//                     <td style="height:0px;width:10px;"></td>
//                     <td style="height:0px;width:53px;"></td>
//                     <td style="height:0px;width:45px;"></td>
//                     <td style="height:0px;width:58px;"></td>
//                     <td style="height:0px;width:21px;"></td>
//                     <td style="height:0px;width:137px;"></td>
//                     <td style="height:0px;width:85px;"></td>
//                     <td style="height:0px;width:15px;"></td>
//                     <td style="height:0px;width:22px;"></td>
//                     <td style="height:0px;width:35px;"></td>
//                     <td style="height:0px;width:34px;"></td>
//                     <td style="height:0px;width:9px;"></td>
//                     <td style="height:0px;width:19px;"></td>
//                     <td style="height:0px;width:103px;"></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:23px;"></td>
//                     <td class="cs739196BC" colspan="7" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"><nobr></nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:10px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:2px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td class="cs101A94F7" colspan="3" rowspan="6" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;"><img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
//                     </td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs8A513397" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs6105B8F3" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs8A513397" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs8A513397" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;'.$numImpotEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:20px;"></td>
//                     <td></td>
//                     <td class="cs6105B8F3" colspan="8" rowspan="2" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:2px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:23px;"></td>
//                     <td></td>
//                     <td class="cs6105B8F3" colspan="8" style="width:434px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs6105B8F3" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Site-web&nbsp;:&nbsp;'.$siteEse.'/nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs8A513397" colspan="8" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:10px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:23px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csD7F64717" colspan="5" style="width:290px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Inventaire&nbsp;:&nbsp;'.$date1.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:23px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td class="cs2C853136" colspan="10" style="width:431px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;:&nbsp;&nbsp;'.$nom_service.'</nobr></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:11px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:24px;"></td>
//                     <td></td>
//                     <td class="cs275E312D" style="width:51px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
//                     <td class="csAB3AA82A" colspan="4" style="width:260px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Produit</nobr></td>
//                     <td class="csAB3AA82A" colspan="2" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Stock&nbsp;Th&#233;orique</nobr></td>
//                     <td class="csAB3AA82A" colspan="4" style="width:99px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Stock&nbsp;Physique</nobr></td>
//                     <td class="csAB3AA82A" colspan="2" style="width:121px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Solde</nobr></td>
//                 </tr>
//                 ';
                                                                            
//                             $output .= $this->showInvetaireService($date1,$date2,$idService); 
                                                                            
//                             $output.='
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:13px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs5EA817F2" colspan="3" style="width:152px;height:22px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;'.date('Y-m-d').'</nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//             </table>
//             </body>
//             </html>
//                         '; 

//                 return $output;

//          } 

// function showInvetaireService($date1,$date2,$idService)
// {
//     //tgaz_stock_service_lot
//     $data = DB::table('tvente_detail_inventaire')
//     ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tvente_detail_inventaire.idStockService')
//     ->join('tvente_produit','tvente_produit.id','=','tgaz_stock_service_lot.refLot')
//     ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
//     ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
//     ->join('tvente_entete_inventaire','tvente_entete_inventaire.id','=','tvente_detail_inventaire.refEnteteVente')        
//     ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')    
    
//     ->select('tvente_detail_inventaire.id','refEnteteVente','tgaz_stock_service_lot.refLot',
//     'tvente_detail_inventaire.compte_vente',
//     'tvente_detail_inventaire.compte_variationstock','tvente_detail_inventaire.compte_perte',
//     'tvente_detail_inventaire.compte_produit','tvente_detail_inventaire.compte_destockage','puVente',
//     'qteVente','qteObs','uniteVente','puBase','qteBase','tvente_detail_inventaire.uniteBase','cmupVente',
//     'tvente_detail_inventaire.devise','tvente_detail_inventaire.taux','montantreduction',
//     'tvente_detail_inventaire.active','tvente_detail_inventaire.author','tvente_detail_inventaire.refUser',
//     'tvente_detail_inventaire.created_at','idStockService',

//     'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
//     'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
//     'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
//     'tvente_produit.estvendable',

//     'nom_service', "tvente_module.nom_module",'tvente_entete_inventaire.code','tgaz_stock_service_lot.refService',
//     'module_id','dateVente','libelle','priseencharge','unitePivot','qtePivot'
//    )
//    ->selectRaw('ROUND((qteVente * qteBase),2) as QtePhysique')
//    ->selectRaw('ROUND((qteObs * qteBase),2) as QteTheorique')
//    ->selectRaw('(ROUND((qteObs * qteBase),2) - ROUND((qteVente * qteBase),2)) as Solde')
//    ->selectRaw('ROUND(((qteVente * qteBase)/qtePivot),2) as QtePhysiquePivot')
//    ->selectRaw('ROUND(((qteObs * qteBase)/qtePivot),2) as QteTheoriquePivot')
//    ->selectRaw('(ROUND(((qteObs * qteBase)/qtePivot),2) - ROUND(((qteVente * qteBase)/qtePivot),2)) as SoldePivot')
//    ->where([
//         ['dateVente','>=', $date1],
//         ['dateVente','<=', $date2],
//         ['tvente_services.id','=', $idService],
//         // ['tvente_categorie_produit.id','=', $refCategorie]
//     ])
//    ->orderBy("tvente_produit.designation", "asc")
//    ->get();

//    $count = 0;
    
//     $output='';

//     foreach ($data as $row) 
//     {

//         $count ++;

//         $output .='
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:24px;"></td>
//                     <td></td>
//                     <td class="csFBCBEF30" style="width:51px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$count.'</nobr></td>
//                     <td class="csDC7EEB9" colspan="4" style="width:260px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$row->designation.'</nobr></td>
//                     <td class="csDC7EEB9" colspan="2" style="width:99px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->QteTheorique.'&nbsp;'.$row->uniteBase.'</nobr></td>
//                     <td class="csDC7EEB9" colspan="4" style="width:99px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->QtePhysique.'&nbsp;'.$row->uniteBase.'</nobr></td>
//                     <td class="csDC7EEB9" colspan="2" style="width:121px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->Solde.'&nbsp;'.$row->uniteBase.'</nobr></td>
//                 </tr>
//            ';
     
//     }

//     return $output;

// }

//==================================================================================================================
//=============== FICHE D'INVENTAIRE POUR DES GRANDES UNITES ========================================================

//=============== FICHE D'INVENTAIRE BY CATEGORIE AVEC GRAANDE UNITE=======================================================================================


//===================== RAPPORT DE PAIEMENT  DES VENTES  =======================================================
//===============================================================================================================

public function fetch_rapport_paiementfacture_date(Request $request)
{
    
    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaieFacture($date1, $date2);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }
    
    
}
function printRapportPaieFacture($date1, $date2)
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

         $totalPaie=0;
                 
         //
         $data2 = DB::table('tgaz_detail_paiement_vente')         
         ->select(DB::raw('ROUND(SUM(montant_paie),2) as TotalPaie'))
         ->where([
            ['tgaz_detail_paiement_vente.date_paie','>=', $date1],
            ['tgaz_detail_paiement_vente.date_paie','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;
                           
         }

           

        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>DEPARTEMENT</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaieFacturation($date1,$date2); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>
        ';  
       
        return $output; 

}
function showPaieFacturation($date1, $date2)
{
    $data = DB::table('tgaz_detail_paiement_vente')
    ->join('tgaz_entete_paiement_vente','tgaz_entete_paiement_vente.id','=','tgaz_detail_paiement_vente.refEntetepaie')
    ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_paiement_vente.refEnteteVente')
    // ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
    ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
    ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
    ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
    ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

    ->join('tconf_banque' , 'tconf_banque.id','=','tgaz_detail_paiement_vente.refBanque')
    ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

    ->select('tgaz_detail_paiement_vente.id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
    'tgaz_detail_paiement_vente.devise','tgaz_detail_paiement_vente.taux','date_paie','modepaie','libellepaie','numeroBordereau',
    'tgaz_detail_paiement_vente.author','tgaz_detail_paiement_vente.refUser','tgaz_detail_paiement_vente.active','tgaz_detail_paiement_vente.created_at'
    
    ,'date_entete_paie','date_paie_current'

    ,'nom_service','refClient','tgaz_entete_vente.refService',
    'tgaz_entete_vente.module_id','dateVente','libelle','tgaz_entete_vente.montant',
    'tgaz_entete_vente.paie'

    ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
    'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
    'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug', 
    "tvente_categorie_client.designation", "compte_client",
    'compteclient.nom_ssouscompte as nom_ssouscompteClient',
    'compteclient.numero_ssouscompte as numero_ssouscompteClient'

    ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
    "tconf_banque.refSscompte as refSscompteBanque",'compteBanque.nom_ssouscompte as nom_ssouscompteBanque',
    'compteBanque.numero_ssouscompte as numero_ssouscompteBanque')
    ->selectRaw('((montant_paie)/tgaz_detail_paiement_vente.taux) as montant_paieFC')
    ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tgaz_detail_paiement_vente.id) as codeRecu')
    ->selectRaw('ROUND((IFNULL(paie,0)),1) as totalPaie')
    ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
    ->selectRaw("DATE_FORMAT(tgaz_detail_paiement_vente.date_paie,'%d/%M/%Y') as date_paie")
    ->where([
        ['tgaz_detail_paiement_vente.date_paie','>=', $date1],
        ['tgaz_detail_paiement_vente.date_paie','<=', $date2]
    ])
    ->orderBy("tgaz_detail_paiement_vente.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .='
        <tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->date_paie.'</td>
		<td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
		<td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
		<td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
		<td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_paie.'$</td>
		<td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->taux.'</td>
		<td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompteBanque.'</td>
		<td></td>
	</tr>
        ';        
   
    }

    return $output;

}


public function fetch_rapport_paiementfacture_date_banque(Request $request)
{
    if ($request->get('date1') && $request->get('date2')&& $request->get('refBanque')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refBanque = $request->get('refBanque');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Banque($date1, $date2,$refBanque);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}
function printRapportPaiementFacture_Banque($date1, $date2,$refBanque)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tgaz_detail_paiement_vente')
         ->select(DB::raw('ROUND(SUM(montant_paie),2) as TotalPaie'))
         ->where([
            ['tgaz_detail_paiement_vente.date_paie','>=', $date1],
            ['tgaz_detail_paiement_vente.date_paie','<=', $date2],
            ['refBanque','=', $refBanque]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;
                           
         }

         $nom_banque='';
         $numero_ssouscompte='';

         $data3 = DB::table('tgaz_detail_paiement_vente')
         ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_paiement_vente.refEnteteVente')
         ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
 
         ->join('tconf_banque' , 'tconf_banque.id','=','tgaz_detail_paiement_vente.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
 
         ->select('tgaz_detail_paiement_vente.id','refEnteteVente','montant_paie',
         'libelle','tgaz_detail_paiement_vente.author','tgaz_detail_paiement_vente.created_at','noms','sexe',
         'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
         'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
         'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
         'tgaz_detail_paiement_vente.devise','tgaz_detail_paiement_vente.taux','tvente_categorie_client.designation as CategorieClient',
         'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
         'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
         'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
         'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
         'numero_classe','nom_typeposition',"nom_typecompte")
         ->selectRaw('((montant_paie)/tgaz_detail_paiement_vente.taux) as montant_paieFC')
         ->selectRaw('ROUND((IFNULL(paie,0)),1) as totalPaie')
         ->selectRaw('CONCAT("R",YEAR(tgaz_detail_paiement_vente.date_paie),"",MONTH(tgaz_detail_paiement_vente.date_paie),"00",tgaz_detail_paiement_vente.id) as codeRecu')
         ->selectRaw("DATE_FORMAT(tgaz_detail_paiement_vente.date_paie,'%d/%M/%Y') as date_paie")
         ->where([
            ['tgaz_detail_paiement_vente.date_paie','>=', $date1],
            ['tgaz_detail_paiement_vente.date_paie','<=', $date2],
            ['refBanque','=', $refBanque]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_banque=$row->nom_banque;
            $numero_ssouscompte=$row->numero_ssouscompte;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$nom_banque.'  : '.$numero_ssouscompte.'</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>CLIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Banque($date1, $date2,$refBanque); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}
function showPaiementFacturation_Banque($date1, $date2,$refBanque)
{
        $data = DB::table('tgaz_detail_paiement_vente')
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_paiement_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','tgaz_detail_paiement_vente.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tgaz_detail_paiement_vente.id','refEnteteVente','montant_paie',
        'libelle','tgaz_detail_paiement_vente.author','tgaz_detail_paiement_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tgaz_detail_paiement_vente.devise','tgaz_detail_paiement_vente.taux as montant_taux','tvente_categorie_client.designation as CategorieClient',
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte")
        ->selectRaw('((montant_paie)/tgaz_detail_paiement_vente.taux) as montant_paieFC')
        ->selectRaw('ROUND((IFNULL(paie,0)),1) as totalPaie')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('CONCAT("R",YEAR(tgaz_detail_paiement_vente.date_paie),"",MONTH(tgaz_detail_paiement_vente.date_paie),"00",tgaz_detail_paiement_vente.id) as codeRecu')
        ->selectRaw("DATE_FORMAT(tgaz_detail_paiement_vente.date_paie,'%d/%M/%Y') as date_paie")
        ->where([
           ['tgaz_detail_paiement_vente.date_paie','>=', $date1],
           ['tgaz_detail_paiement_vente.date_paie','<=', $date2],
           ['refBanque','=', $refBanque],
       ])
       ->orderBy("tgaz_detail_paiement_vente.created_at", "asc")
       ->get();
       $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->date_paie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_paie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
        '; 
           
   
    }

    return $output;

}

//======================= FICHE MOUVEMENT SUR LE PRODUIT ==================================================================
//=========================================================================================================================

function pdf_fiche_mouvement_produit(Request $request)
{

    if ($request->get('date1') && $request->get('date2') && $request->get('refLot') && $request->get('idService')) 
    {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refLot = $request->get('refLot');
        $refService = $request->get('idService');

        $html = $this->getInfoMouvementProduit($date1,$date2,$refLot,$refService);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }   
    
}
function getInfoMouvementProduit($date1,$date2,$refLot,$refService)
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
               //
            $totalEntree=0;
            $totalSortie=0;
            $tempEntree=0;
            $tempSortie=0;
            $report=0;
            $solde=0;

            $nom_produit=''; 
            $nom_unitebase='';  
            $nom_service='';

            $data_service = DB::table("tvente_services")
            ->select("tvente_services.id","tvente_services.nom_service","tvente_services.created_at","status",
            'tvente_services.active')
            ->where([
               ['tvente_services.id','=', $refService]
           ])      
           ->get(); 
           foreach ($data_service as $row) 
           {
              $nom_service=$row->nom_service;                 
           }


           $data_produit = DB::table("tgaz_lot")
           ->select('id','refCategorieLot','nom_lot','code_lot','unite_lot',
           'stock_alerte','author','refUser')
           ->where([
              ['tgaz_lot.id','=', $refLot]
          ])      
          ->get(); 
          foreach ($data_produit as $row) 
          {
             $nom_produit=$row->nom_lot;  
             $nom_unitebase=$row->unite_lot;                
          }
   

          $date_temp_entree = DB::table('tgaz_mouvement_stock_service_lot')   
          ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
          ->select(DB::raw('IFNULL(ROUND(SUM(qteMvt),3),0) as tempEntree'))
          ->where([               
              ['dateMvt','<', $date1],
              ['tgaz_stock_service_lot.refLot','=', $refLot],
              ['tgaz_stock_service_lot.refService','=', $refService],
              ['tgaz_mouvement_stock_service_lot.type_mouvement','=', 'Entree']                
          ])               
          ->get();
          foreach ($date_temp_entree as $row) 
          {                                
             $tempEntree=$row->tempEntree;                           
          }

          $data_temp_sortie = DB::table('tgaz_mouvement_stock_service_lot')   
          ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
          ->select(DB::raw('IFNULL(ROUND(SUM(qteMvt),3),0) as tempSortie'))
          ->where([               
              ['dateMvt','<', $date1],
              ['tgaz_stock_service_lot.refLot','=', $refLot],
              ['tgaz_stock_service_lot.refService','=', $refService],
              ['tgaz_mouvement_stock_service_lot.type_mouvement','=', 'Sortie']                
          ])               
          ->get();
          foreach ($data_temp_sortie as $row) 
          {                                
             $tempSortie=$row->tempSortie;                           
          }

          $report = floatval($tempEntree) - floatval($tempSortie);

            $data_entree = DB::table('tgaz_mouvement_stock_service_lot')   
            ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteMvt),3),0) as totalEntree'))
            ->where([               
                ['dateMvt','>=', $date1],
                ['dateMvt','<=', $date2],
                ['tgaz_stock_service_lot.refLot','=', $refLot],
                ['tgaz_stock_service_lot.refService','=', $refService],
                ['tgaz_mouvement_stock_service_lot.type_mouvement','=', 'Entree']                
            ])               
            ->get();
            foreach ($data_entree as $row) 
            {                                
               $totalEntree=$row->totalEntree;                           
            }

            $data_sortie = DB::table('tgaz_mouvement_stock_service_lot')   
            ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteMvt),3),0) as totalSortie'))
            ->where([               
                ['dateMvt','>=', $date1],
                ['dateMvt','<=', $date2],
                ['tgaz_stock_service_lot.refLot','=', $refLot],
                ['tgaz_stock_service_lot.refService','=', $refService],
                ['tgaz_mouvement_stock_service_lot.type_mouvement','=', 'Sortie']                
            ])               
            ->get();
            foreach ($data_sortie as $row) 
            {                                
               $totalSortie=$row->totalSortie;                           
            }

            $solde = floatval($report) + floatval($totalEntree) - floatval($totalSortie);            

            $output='';  
            $output=' 

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rptFicheProduit</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs82D98BB6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:614px;height:373px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:96px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:213px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:71px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="6" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="5" style="width:131px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:131px;height:110px;">
                            <img alt="" src="'.$pic2.'" style="width:131px;height:110px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM&nbsp;'.$rccEse.'.&nbsp;ID&nbsp;NAT&nbsp;'.$idNatEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;Impot : '.$numImpotEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:434px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs6105B8F3" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Site-web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8A513397" colspan="7" style="width:434px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.' - '.$Tel2Ese.'</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs5EA817F2" colspan="3" style="width:245px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                        <td class="cs8BD51C12" colspan="9" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$nom_service.':&nbsp;'.$nom_produit.'&nbsp;('.$nom_unitebase.')</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs275E312D" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                        <td class="csAB3AA82A" colspan="3" style="width:293px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Libell&#233;</nobr></td>
                        <td class="csAB3AA82A" colspan="4" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Entr&#233;e</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Sortie</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs275E312D" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date1.'</nobr></td>
                        <td class="csAB3AA82A" colspan="3" style="width:293px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Solde&nbsp;Innitial</nobr></td>
                        <td class="csAB3AA82A" colspan="4" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>0</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>0</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$report.'</nobr></td>
                    </tr>
                    ';
                                                                    
                                        $output .= $this->showMouvementProduit($date1,$date2,$refLot,$refService); 
                                                                    
                                        $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs275E312D" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date2.'</nobr></td>
                        <td class="csAB3AA82A" colspan="3" style="width:293px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Solde&nbsp;Final</nobr></td>
                        <td class="csAB3AA82A" colspan="4" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>0</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>0</nobr></td>
                        <td class="csAB3AA82A" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$solde.'</nobr></td>
                    </tr>
                </table>
                </body>
                </html>

            '; 

    return $output;

} 
function showMouvementProduit($date1,$date2,$refLot,$refService)
{
    $data = DB::table('tgaz_mouvement_stock_service_lot')
    ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
    ->join('tvente_produit','tvente_produit.id','=','tgaz_stock_service_lot.refLot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 

    ->select('tgaz_mouvement_stock_service_lot.id','idStockService','tvente_categorie_produit.compte_vente',
    'tvente_categorie_produit.compte_variationstock','tvente_categorie_produit.compte_perte',
    'tvente_categorie_produit.compte_produit','tvente_categorie_produit.compte_destockage',
    'tvente_categorie_produit.compte_achat','tvente_categorie_produit.compte_stockage','dateMvt',
    'type_mouvement','libelle_mouvement','nom_table','id_data','puMvt','qteMvt','uniteMvt',
    'cmupMvt','tgaz_mouvement_stock_service_lot.devise','tgaz_mouvement_stock_service_lot.taux','tgaz_mouvement_stock_service_lot.author',
    'tgaz_mouvement_stock_service_lot.refUser','tgaz_mouvement_stock_service_lot.created_at',

    'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
    'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
    'tvente_produit.estvendable',  

    'nom_service','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
    'tgaz_stock_service_lot.pu_lot','tgaz_stock_service_lot.qte_lot',
    'tgaz_stock_service_lot.cmup_lot','tgaz_stock_service_lot.active')
    ->selectRaw("(CASE WHEN (type_mouvement = 'Entree') THEN (qteMvt) END) as qteEntree")
    ->selectRaw("(CASE WHEN (type_mouvement = 'Sortie') THEN (qteMvt) END) as qteSortie")
    ->selectRaw("((CASE WHEN (type_mouvement = 'Entree') THEN (qteMvt) END) - (CASE WHEN (type_mouvement = 'Sortie') THEN (qteMvt) END)) as solde")
    ->where([               
        ['dateMvt','>=', $date1],
        ['dateMvt','<=', $date2],
        ['tgaz_stock_service_lot.refLot','=', $refLot],
        ['tgaz_stock_service_lot.refService','=', $refService]                
    ])
    ->orderBy("dateMvt", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
         $output .='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csE71035DC" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateMvt.'</nobr></td>
                <td class="cs82D98BB6" colspan="3" style="width:293px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->libelle_mouvement.'</td>
                <td class="cs82D98BB6" colspan="4" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->qteEntree.'</nobr></td>
                <td class="cs82D98BB6" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->qteSortie.'</nobr></td>
                <td class="cs82D98BB6" colspan="2" style="width:72px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->solde.'</nobr></td>
            </tr>
         ';
       
    }

    return $output;

}

//==================== RAPPORT TRANSFERT PAR SERVICE SOURCE =======================================

public function fetch_rapport_detailtransfert_date_service_source(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailTransfert_Service_Source($date1, $date2,$idService);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailTransfert_Service_Source($date1, $date2,$idService)
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
 
         $TotalTransfert=0;
         // 
         $data2 =  DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')

         ->select(DB::raw('ROUND(SUM(qteTransfert * puTransfert),3) as TotalTransfert'))
         ->where([
            ['date_transfert','>=', $date1],
            ['date_transfert','<=', $date2],
            ['servicesOrigine.id','=', $idService],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $TotalTransfert=$row->TotalTransfert;                    
         }




         $services='';         

         $data3=DB::table('tvente_services')       
         ->select('id','nom_service','status','active')
         ->where([
            ['tvente_services.id','=', $idService]
        ])      
        ->first(); 
        if ($data3) 
        {
            $services=$data3->nom_service;              
        }


        $output='';  

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTransfert</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:844px;height:375px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:62px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:128px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:76px;"></td>
                    <td style="height:0px;width:72px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:114px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="5" style="width:126px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:126px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:126px;height:110px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;00056789/M</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Site-web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
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
                    <td class="cs8A513397" colspan="10" style="width:586px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'</nobr></td>
                    <td></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs2C853136" colspan="12" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;TRANSFERT&nbsp;PAR&nbsp;SERVICE&nbsp;SOURCE</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;Source&nbsp;:&nbsp;'.$services.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs1E4BB091" style="width:36px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:80px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;Transfert</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:128px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;Source</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:129px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Sercive&nbsp;Destination</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:179px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Produit</nobr></td>
                    <td class="csEE1F9023" style="width:35px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:63px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEE1F9023" style="width:113px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                </tr>
                ';

                        $output .= $this->showDetailTransfert_Service_Source($date1,$date2,$idService); 

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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csDB0B2364" colspan="4" style="width:98px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalTransfert.'$</nobr></td>
                </tr>
            </table>
            </body>
            </html>      
        ';  
       
        return $output; 

}
function showDetailTransfert_Service_Source($date1,$date2,$idService)
{
        $data = DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')
        
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
        'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','tgaz_detail_transfert.created_at','refService',
        'date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,'nom_lot','code_lot','unite_lot','stock_alerte')
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->selectRaw('CONCAT("S",YEAR(date_transfert),"",MONTH(date_transfert),"00",refEnteteTransfert) as codeFacture')
        ->where([
            ['date_transfert','>=', $date1],
            ['date_transfert','<=', $date2],
            ['servicesOrigine.id','=', $idService]
        ])
        ->orderBy("tgaz_detail_transfert.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>1</nobr></td>
                    <td class="cs6AEC9C2" style="width:61px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->date_transfert.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:80px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeFacture.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:128px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->ServiceOrigine.'</td>
                    <td class="cs6AEC9C2" colspan="2" style="width:129px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->ServiceDestination.'</td>
                    <td class="cs6AEC9C2" colspan="4" style="width:179px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                    <td class="cs6AEC9C2" style="width:35px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->qteTransfert.'('.$row->uniteTransfert.')</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:63px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->puTransfert.'$</nobr></td>
                    <td class="cs6AEC9C2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->PTTransfert.'$</nobr></td>
                </tr>
            ';         
   
    }

    return $output;

}

//==================== RAPPORT DETAIL TRANSFERT SELON LES SERVICES =======================================

public function fetch_rapport_detailtransfert_date_service_destination(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('idService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailTransfert_Service_Destination($date1, $date2,$idService);       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}
function printRapportDetailTransfert_Service_Destination($date1, $date2,$idService)
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
 
         $TotalTransfert=0;
         // 
         $data2 =  DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')

         ->select(DB::raw('ROUND(SUM(qteTransfert * puTransfert),3) as TotalTransfert'))
         ->where([
            ['date_transfert','>=', $date1],
            ['date_transfert','<=', $date2],
            ['servicesDestination.id','=', $idService],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $TotalTransfert=$row->TotalTransfert;                    
         }




         $services='';         

         $data3=DB::table('tvente_services')       
         ->select('id','nom_service','status','active')
         ->where([
            ['tvente_services.id','=', $idService]
        ])      
        ->first(); 
        if ($data3) 
        {
            $services=$data3->nom_service;              
        }


        $output='';  

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rptRapportTransfert</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1E4BB091 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .csDB0B2364 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs463A9CD7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEE1F9023 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs5A34C077 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:bold; font-style:normal; }
                    .cs6AEC9C2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs8BD51C12 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs5EA817F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs2C853136 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:19px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:844px;height:375px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:38px;"></td>
                    <td style="height:0px;width:62px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:128px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:41px;"></td>
                    <td style="height:0px;width:76px;"></td>
                    <td style="height:0px;width:72px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:8px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:114px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="5" style="width:126px;height:110px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:126px;height:110px;">
                        <img alt="" src="'.$pic2.'" style="width:126px;height:110px;" /></div>
                    </td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8A513397" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#176;&nbsp;00056789/M</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>E-mail&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                    <td class="cs6105B8F3" colspan="10" style="width:586px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Site-web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
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
                    <td class="cs8A513397" colspan="10" style="width:586px;height:23px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Tel&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'</nobr></td>
                    <td></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs2C853136" colspan="12" style="width:597px;height:23px;line-height:22px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;TRANSFERT&nbsp;PAR&nbsp;SERVICE&nbsp;RECEPTEUR</nobr></td>
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
                    <td class="cs5EA817F2" colspan="4" style="width:203px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
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
                    <td class="cs8BD51C12" colspan="8" style="width:431px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;Source&nbsp;:&nbsp;'.$services.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs1E4BB091" style="width:36px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                    <td class="csEE1F9023" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Date</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:80px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;Transfert</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:128px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;Source</nobr></td>
                    <td class="csEE1F9023" colspan="2" style="width:129px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Sercive&nbsp;Destination</nobr></td>
                    <td class="csEE1F9023" colspan="4" style="width:179px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Produit</nobr></td>
                    <td class="csEE1F9023" style="width:35px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                    <td class="csEE1F9023" colspan="3" style="width:63px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="csEE1F9023" style="width:113px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                </tr>
                ';

                                        $output .= $this->showDetailTransfert_Service_Destination($date1,$date2,$idService); 

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
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="csDB0B2364" colspan="4" style="width:98px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs5A34C077" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$TotalTransfert.'$</nobr></td>
                </tr>
            </table>
            </body>
            </html>      
        ';  
       
        return $output; 

}
function showDetailTransfert_Service_Destination($date1,$date2,$idService)
{
        $data = DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')
        
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
        'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','tgaz_detail_transfert.created_at','refService',
        'date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,'nom_lot','code_lot','unite_lot','stock_alerte')
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->selectRaw('CONCAT("S",YEAR(date_transfert),"",MONTH(date_transfert),"00",refEnteteTransfert) as codeFacture')
        ->where([
            ['date_transfert','>=', $date1],
            ['date_transfert','<=', $date2],
            ['servicesDestination.id','=', $idService]
        ])
        ->orderBy("tgaz_detail_transfert.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {

            $output .='
                	<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs463A9CD7" style="width:36px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>1</nobr></td>
                    <td class="cs6AEC9C2" style="width:61px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->date_transfert.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:80px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeFacture.'</nobr></td>
                    <td class="cs6AEC9C2" colspan="2" style="width:128px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->ServiceOrigine.'</td>
                    <td class="cs6AEC9C2" colspan="2" style="width:129px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->ServiceDestination.'</td>
                    <td class="cs6AEC9C2" colspan="4" style="width:179px;height:22px;line-height:10px;text-align:left;vertical-align:middle;">'.$row->nom_lot.'</td>
                    <td class="cs6AEC9C2" style="width:35px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->qteTransfert.'('.$row->uniteTransfert.')</nobr></td>
                    <td class="cs6AEC9C2" colspan="3" style="width:63px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->puTransfert.'$</nobr></td>
                    <td class="cs6AEC9C2" style="width:113px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$row->PTTransfert.'$</nobr></td>
                </tr>
            ';         
   
    }

    return $output;

}










//== FICHE DE STOCK DES SERVICES SANS PRIX ET POUR LES FILTRES DES NON VENDABLES ET VENDABLES=======================================================================================

// function pdf_fiche_stock_vente_service_by_sans_prix(Request $request)
// {

//     if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
//         // code...
//         $date1 = $request->get('date1');
//         $date2 = $request->get('date2');
//         $idService = $request->get('idService');
        
//         $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
//         $html .= $this->getInfoFicheStockServicesBySansPrix($date1,$date2,$idService);       
//         $html .='<script>window.print()</script>';

//         echo($html); 
        
//     }
//     else{
//     }    
// }
// function getInfoFicheStockServicesBySansPrix($date1,$date2,$idService)
// {
//            //Info Entreprise
//            $nomEse='';
//            $adresseEse='';
//            $Tel1Ese='';
//            $Tel2Ese='';
//            $siteEse='';
//            $emailEse='';
//            $idNatEse='';
//            $numImpotEse='';
//            $rccEse='';
//            $siege='';
//            $busnessName='';
//            $pic='';
//            $pic2 = $this->displayImg("fichier", 'logo.png');
//            $logo='';
   
//            $data1 = DB::table('entreprises')
//            ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
//            ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')
   
//            ->join('pays','pays.id','=','entreprises.idPays')
//            ->join('provinces','provinces.id','=','entreprises.idProvince')
//            ->join('users','users.id','=','entreprises.ceo')        
//            ->select('entreprises.id as id','entreprises.id as idEntreprise',
//            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
//            'entreprises.emailEntreprise','entreprises.adresseEntreprise',
//            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur',
//            'entreprises.idforme','entreprises.etat',
//            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook',
//            'entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
//            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
//            'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',
//             //forme
//             'forme_juridiques.nomForme','secteurs.nomSecteur',
//             //users
//             'users.name','users.email','users.avatar','users.telephone','users.adresse',
//             //
//             'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
//            ->get();
//            $output='';
//            foreach ($data1 as $row1) 
//            {                                
//                $nomEse=$row1->nomEntreprise;
//                $adresseEse=$row1->adresseEntreprise;
//                $Tel1Ese=$row1->telephoneEntreprise;
//                $Tel2Ese=$row1->telephone;
//                $siteEse=$row1->siteweb;
//                $emailEse=$row1->emailEntreprise;
//                $idNatEse=$row1->rccm;
//                $numImpotEse=$row1->rccm;
//                $busnessName=$row1->nomSecteur;
//                $rccmEse=$row1->rccm;
//                $pic = $this->displayImg("fichier", 'logo.png');
//                $siege=$row1->nomForme;         
//            }


//            $totalVente = 0;
//            $totalTransfert=0;
//            $totalCMUP = 0;
//            $globalTP=0;

//            $data5 = DB::table('tgaz_detail_vente')
//            ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')
//            ->join('tvente_produit','tvente_produit.id','=','tgaz_stock_service_lot.refLot')
//            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
//            ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')
//            ->select(DB::raw('IFNULL(ROUND(SUM(qteVente*puVente),0),0) as totalSortie'))
//            ->where([               
//                ['tgaz_entete_vente.dateVente','>=', $date1],
//                ['tgaz_entete_vente.dateVente','<=', $date2],
//                ['tgaz_stock_service_lot.refService','=', $idService]
//            ])->get(); 
           
//            foreach ($data5 as $row5) 
//            {                                
//             //   $totalVente=$row5->totalSortie;  
//               $totalVente=0;                          
//            }


//            $CategorieClient=''; 

//            $data3=DB::table('tvente_services')
//            ->select('id','nom_service','status','active')
//            ->where([
//               ['tvente_services.id','=', $idService]
//           ])      
//           ->get();      
//           $output='';
//           foreach ($data3 as $row) 
//           {
//               $CategorieClient=$row->nom_service;              
//           }
  
   
//             $output=' 

//             <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//             <!-- saved from url=(0016)http://localhost -->
//             <html>
//             <head>
//                 <title>FicheStock</title>
//                 <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
//                 <style type="text/css">
//                     .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
//                     .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
//                     .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
//                     .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
//                     .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
//                     .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
//                     .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
//                     .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
//                     .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
//                     .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
//                     .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
//                     .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
//                     .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
//                     .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
//                 </style>
//             </head>
//             <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
//             <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
//                 <tr>
//                     <td style="width:0px;height:0px;"></td>
//                     <td style="height:0px;width:6px;"></td>
//                     <td style="height:0px;width:4px;"></td>
//                     <td style="height:0px;width:163px;"></td>
//                     <td style="height:0px;width:47px;"></td>
//                     <td style="height:0px;width:59px;"></td>
//                     <td style="height:0px;width:108px;"></td>
//                     <td style="height:0px;width:22px;"></td>
//                     <td style="height:0px;width:88px;"></td>
//                     <td style="height:0px;width:77px;"></td>
//                     <td style="height:0px;width:89px;"></td>
//                     <td style="height:0px;width:21px;"></td>
//                     <td style="height:0px;width:18px;"></td>
//                     <td style="height:0px;width:86px;"></td>
//                     <td style="height:0px;width:36px;"></td>
//                     <td style="height:0px;width:132px;"></td>
//                     <td style="height:0px;width:2px;"></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:23px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:3px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:10px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:13px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
//                         <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
//                     </td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:21px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:1px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:14px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:34px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK : '.$CategorieClient.'</nobr></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:7px;"></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                     <td></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:24px;"></td>
//                     <td></td>
//                     <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;VENTE(USD)</nobr></td>
//                     <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'$</nobr></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:24px;"></td>
//                     <td></td>
//                     <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
//                     <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
//                     <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
//                     <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
//                     <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
//                     <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>                    
//                     <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Unité</nobr></td>
//                     <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Obs.</nobr></td>
//                 </tr>
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:22px;"></td>
//                     <td></td>
//                     <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
//                 </tr>
//                 ';
                                                                
//                    $output .= $this->showCategorieFicheStockServiceSansPrix($date1,$date2,$idService); 
                                                                
//                  $output.='
//             </table>
//             </body>
//             </html>

//             '; 

//     return $output;

// } 
// function showCategorieFicheStockServiceSansPrix($date1,$date2,$idService)
// {
//     $data = DB::table("tvente_categorie_produit")
//     ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", 
//     "tvente_categorie_produit.created_at", "tvente_categorie_produit.author")    
//     ->orderBy("tvente_categorie_produit.designation", "asc")
//     ->get();
    
//     $output='';

//     foreach ($data as $row) 
//     {
//         $output .='
//                 <tr style="vertical-align:top;">
//                 <td style="width:0px;height:22px;"></td>
//                 <td></td>
//                 <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->designation.'</td>
//             </tr>
//             ';
                                                    
//                 $output .= $this->showDetailFicheStockServiceSansPrix($date1,$date2,$row->id,$idService);                                                     
//                 $output.='
//         ';      
//     }

//     return $output;

// }
// function showDetailFicheStockServiceSansPrix($date1, $date2, $refCategorie, $idService)
// {
//     // Récupérer les données de stock, mouvements et ventes en une seule requête 
//     $data11 = DB::table('tgaz_stock_service_lot')
//     ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//     ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//     ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

//     ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
//         $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
//              ->where('dtEntree.type_mouvement', '=', 'Entree')
//              ->where('dtEntree.dateMvt', '<', $date1);
//     })

//         // Utilisez distinct() avant select()
//         ->distinct()
//         ->select(
//             "tgaz_stock_service_lot.id",
//             'tgaz_stock_service_lot.refService',
//             'tgaz_stock_service_lot.refLot',
//             "tvente_produit.designation as designation",
//             "refCategorie",
//             "tgaz_stock_service_lot.pu",
//             "tvente_categorie_produit.designation as Categorie",
//             "tgaz_stock_service_lot.qte",
//             "tgaz_stock_service_lot.uniteBase",
//             "tgaz_stock_service_lot.cmup","tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux",            
//             DB::raw('IFNULL(ROUND(SUM(dtEntree.qteBase * dtEntree.qteMvt), 3), 0) as totalEntree'),

//         )
//         ->where([
//             ['tvente_produit.refCategorie', '=', $refCategorie],
//             ['tgaz_stock_service_lot.refService', '=', $idService]
//         ])
//         ->groupBy("tgaz_stock_service_lot.id", "tgaz_stock_service_lot.refService", "tgaz_stock_service_lot.refLot", 
//         "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
//         "tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux")
//         ->orderBy("tvente_produit.designation", "asc")
//         ->get();


//     $data22 = DB::table('tgaz_stock_service_lot')
//     ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//     ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//     ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

//     ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
//         $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
//              ->where('dtSortie.type_mouvement', '=', 'Sortie')
//              ->where('dtSortie.dateMvt', '<', $date1);
//     })
//     // Utilisez distinct() avant select()
//     ->distinct()
//     ->select(
//         "tgaz_stock_service_lot.id",
//         'tgaz_stock_service_lot.refService',
//         'tgaz_stock_service_lot.refLot',
//         "tvente_produit.designation as designation",
//         "refCategorie",
//         "tgaz_stock_service_lot.pu",
//         "tvente_categorie_produit.designation as Categorie",
//         "tgaz_stock_service_lot.qte",
//         "tgaz_stock_service_lot.uniteBase",
//         "tgaz_stock_service_lot.cmup",
//         DB::raw('IFNULL(ROUND(SUM(dtSortie.qteBase * dtSortie.qteMvt), 3), 0) as totalSortie')
//     )
//     ->where([
//         ['tvente_produit.refCategorie', '=', $refCategorie],
//         ['tgaz_stock_service_lot.refService', '=', $idService]
//     ])
//     ->groupBy("tgaz_stock_service_lot.id", "tgaz_stock_service_lot.refService", "tgaz_stock_service_lot.refLot", "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup")
//     ->orderBy("tvente_produit.designation", "asc")
//     ->get();

//     // ============ LEs Mouvements =========================================================================

//         // Récupérer les données de stock, mouvements et ventes en une seule requête 
//         $data1 = DB::table('tgaz_stock_service_lot')
//         ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//         ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//         ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
//         ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $date2, $idService) {
//             $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
//                  ->where('mvtEntree.type_mouvement', '=', 'Entree')
//                  ->whereBetween('mvtEntree.dateMvt', [$date1, $date2]);;
//         })
    
//             // Utilisez distinct() avant select()
//             ->distinct()
//             ->select(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation as designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation as Categorie",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase",
//                 "tgaz_stock_service_lot.cmup","tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux",            
//                 DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteBase * mvtEntree.qteMvt), 3), 0) as stockEntree'),
    
//             )
//             ->where([
//                 ['tvente_produit.refCategorie', '=', $refCategorie],
//                 ['tgaz_stock_service_lot.refService', '=', $idService]
//             ])
//             ->groupBy("tgaz_stock_service_lot.id", "tgaz_stock_service_lot.refService", "tgaz_stock_service_lot.refLot", 
//             "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
//             "tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux")
//             ->orderBy("tvente_produit.designation", "asc")
//             ->get();
    
//     //======================================================================
    
//         // Récupérer les données de stock, mouvements et ventes en une seule requête 
//         $data2 = DB::table('tgaz_stock_service_lot')
//         ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//         ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//         ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
//         ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $date2, $idService) {
//             $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
//                  ->where('mvtSortie.type_mouvement', '=', 'Sortie')
//                  ->whereBetween('mvtSortie.dateMvt', [$date1, $date2]);;
//         })
    
//             // Utilisez distinct() avant select()
//             ->distinct()
//             ->select(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation as designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation as Categorie",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase",
//                 "tgaz_stock_service_lot.cmup","tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux",            
//                 DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteBase * mvtSortie.qteMvt), 3), 0) as stockSortie'),
    
//             )
//             ->where([
//                 ['tvente_produit.refCategorie', '=', $refCategorie],
//                 ['tgaz_stock_service_lot.refService', '=', $idService]
//             ])
//             ->groupBy("tgaz_stock_service_lot.id", "tgaz_stock_service_lot.refService", "tgaz_stock_service_lot.refLot", 
//             "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
//             "tgaz_stock_service_lot.devise","tgaz_stock_service_lot.taux")
//             ->orderBy("tvente_produit.designation", "asc")
//             ->get();
    

//     // Construction de l'output
    
//     $output = '';

//     // Vérifiez que les deux tableaux ont la même longueur
//     if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
//     && (count($data1) === count($data22)))
//     {
//         for ($i = 0; $i < count($data1); $i++) {
//             $row11 = $data11[$i];
//             $row22 = $data22[$i];
//             $row1 = $data1[$i];
//             $row2 = $data2[$i];            

//             $totalSortie = floatval($row22->totalSortie);
//             $totalEntree = floatval($row11->totalEntree);

//             $stockSortie = floatval($row2->stockSortie);            
//             $stockEntree = floatval($row1->stockEntree);

//             $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
//             $totalGEntree = floatval($stockEntree);
//             $totalG = floatval($totalSI) + floatval($stockEntree);
//             $TGSortie = floatval($stockSortie);
//             $totalSF = floatval($totalG) - floatval($stockSortie);
//             $totalPT = floatval($totalSF) * floatval($row2->cmup);

//              $output .= '
//                 <tr style="vertical-align:top;">
//                     <td style="width:0px;height:24px;"></td>
//                     <td></td>
//                     <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->designation.'</td>
//                     <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.' '.$row1->uniteBase.'</td>
//                     <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalGEntree.' '.$row1->uniteBase.' </td>
//                     <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.' '.$row1->uniteBase.'</td>
//                     <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$TGSortie.' '.$row1->uniteBase.'</td>
//                     <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.' '.$row1->uniteBase.'</td>                
//                     <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row2->uniteBase.'</td>
//                     <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">--</td>
//                 </tr>
//             ';   

//     }
//     } else {
//         // Gérer le cas où les tableaux n'ont pas la même longueur
//         echo 'Les tableaux ont pas la même longueur.';
//     }

//     return $output;
// }


//===================================================================================================================
//======================== FICHE STOCK AVEC EXCEL ====================================================================

//=============== FICHE DE STOCK DES SERVICES EXCEL=======================================================================================
function pdf_fiche_stock_vente_service_excel(Request $request)
{
    if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $data_return = []; // Initialisation du tableau pour stocker les résultats

            // Récupérer les données de stock, mouvements et ventes en une seule requête 
    // Récupérer les données de stock, mouvements et ventes en une seule requête 
    $data11 = DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
        $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtEntree.type_mouvement', '=', 'Entree')
             ->where('dtEntree.dateMvt', '<', $date1);
    })

        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot as designation",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot as Categorie",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux",            
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteMvt), 3), 0) as totalEntree'),

        )
        ->where([
            ['tgaz_stock_service_lot.refService', '=', $idService]
        ])
        ->groupBy("tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux")
        ->orderBy("tgaz_lot.nom_lot", "asc")
        ->get();



    $data22 =  DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')

    ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
        $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtSortie.type_mouvement', '=', 'Sortie')
             ->where('dtSortie.dateMvt', '<', $date1);
    })
    // Utilisez distinct() avant select()
    ->distinct()
    ->select(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot as designation",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot as Categorie",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux",
        DB::raw('IFNULL(ROUND(SUM(dtSortie.qteMvt), 3), 0) as totalSortie')
    )
    ->where([
        ['tgaz_stock_service_lot.refService', '=', $idService]
    ])
    ->groupBy(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux"
        )
    ->orderBy("tgaz_lot.nom_lot", "asc")
    ->get();

    // ============ LEs Mouvements =========================================================================

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data1 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtEntree.type_mouvement', '=', 'Entree')
                 ->whereBetween('mvtEntree.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tvente_services.nom_service',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteMvt), 3), 0) as stockEntree'),
    
            )
            ->where([
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tvente_services.nom_service',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    
    //======================================================================
    
        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data2 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtSortie.type_mouvement', '=', 'Sortie')
                 ->whereBetween('mvtSortie.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteMvt), 3), 0) as stockSortie'),
    
            )
            ->where([
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    

    // Vérifiez que les deux tableaux ont la même longueur
    if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
    && (count($data1) === count($data22)))
    {
        for ($i = 0; $i < count($data1); $i++) {
            $row11 = $data11[$i];
            $row22 = $data22[$i];
            $row1 = $data1[$i];
            $row2 = $data2[$i];            

            $totalSortie = floatval($row22->totalSortie);
            $totalEntree = floatval($row11->totalEntree);

            $stockSortie = floatval($row2->stockSortie);            
            $stockEntree = floatval($row1->stockEntree);

            $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
            $totalGEntree = floatval($stockEntree);
            $totalG = floatval($totalSI) + floatval($stockEntree);
            $TGSortie = floatval($stockSortie);
            $totalSF = floatval($totalG) - floatval($stockSortie);
            $totalPT = floatval($totalSF) * floatval($row2->cmup_lot);

            $data_return[] = [
                'id' => $row1->id,
                'Service' => $row1->nom_service,
                'designation' => $row1->designation,
                'Categorie' => $row1->Categorie,
                'SI' => $totalSI,
                'Entree' =>$totalGEntree,
                'Total' => $totalG,
                'Sortie' => $TGSortie,
                'SF' => $totalSF,
                'PU' => round($row1->cmup_lot,2),
                'PT' => round($totalPT,2),
                'Unité' => $row1->unite_lot
            ];

        }
    } 
    else {
        // Gérer le cas où les tableaux n'ont pas la même longueur
        echo 'Les tableaux ont pas la même longueur.';
    }

    return response()->json($data_return);

    }



    return response()->json(['error' => 'Invalid parameters'], 400);
}
//=============== FICHE DE STOCK DES SERVICES EXCEL=======================================================================================
// function pdf_fiche_stock_vente_service_sans_prix_excel(Request $request)
// {
//     if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
//         $date1 = $request->get('date1');
//         $date2 = $request->get('date2');
//         $idService = $request->get('idService');

//         $data_return = []; // Initialisation du tableau pour stocker les résultats

//             // Récupérer les données de stock, mouvements et ventes en une seule requête 
//         $data11 = DB::table('tgaz_stock_service_lot')
//         ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//         ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//         ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

//         ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
//         $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
//              ->where('dtEntree.type_mouvement', '=', 'Entree')
//              ->where('dtEntree.dateMvt', '<', $date1);
//     })

//         // Utilisez distinct() avant select()
//         ->distinct()
//         ->select(
//             "tgaz_stock_service_lot.id",
//             'tgaz_stock_service_lot.refService',
//             'tgaz_stock_service_lot.refLot',
//             "tvente_produit.designation as designation",
//             "refCategorie",
//             "tgaz_stock_service_lot.pu",
//             "tvente_categorie_produit.designation as Categorie",
//             "tgaz_stock_service_lot.qte",
//             "tgaz_stock_service_lot.uniteBase",
//             "tgaz_stock_service_lot.cmup",
//             "tgaz_stock_service_lot.devise",
//             "tgaz_stock_service_lot.taux",            
//             DB::raw('IFNULL(ROUND(SUM(dtEntree.qteBase * dtEntree.qteMvt), 3), 0) as totalEntree'),

//         )
//         ->where([
//             ['tgaz_stock_service_lot.refService', '=', $idService]
//         ])
//         ->groupBy("tgaz_stock_service_lot.id",
//             'tgaz_stock_service_lot.refService',
//             'tgaz_stock_service_lot.refLot',
//             "tvente_produit.designation",
//             "refCategorie",
//             "tgaz_stock_service_lot.pu",
//             "tvente_categorie_produit.designation",
//             "tgaz_stock_service_lot.qte",
//             "tgaz_stock_service_lot.uniteBase",
//             "tgaz_stock_service_lot.cmup",
//             "tgaz_stock_service_lot.devise",
//             "tgaz_stock_service_lot.taux")
//         ->orderBy("tvente_produit.designation", "asc")
//         ->get();

//     $data22 = DB::table('tgaz_stock_service_lot')
//     ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//     ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//     ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

//     ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
//         $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
//              ->where('dtSortie.type_mouvement', '=', 'Sortie')
//              ->where('dtSortie.dateMvt', '<', $date1);
//     })
//     // Utilisez distinct() avant select()
//     ->distinct()
//     ->select(
//         "tgaz_stock_service_lot.id",
//         'tgaz_stock_service_lot.refService',
//         'tgaz_stock_service_lot.refLot',
//         "tvente_produit.designation as designation",
//         "refCategorie",
//         "tgaz_stock_service_lot.pu",
//         "tvente_categorie_produit.designation as Categorie",
//         "tgaz_stock_service_lot.qte",
//         "tgaz_stock_service_lot.uniteBase",
//         "tgaz_stock_service_lot.cmup",
//         DB::raw('IFNULL(ROUND(SUM(dtSortie.qteBase * dtSortie.qteMvt), 3), 0) as totalSortie')
//     )
//     ->where([
//         ['tgaz_stock_service_lot.refService', '=', $idService]
//     ])
//     ->groupBy("tgaz_stock_service_lot.id",
//         'tgaz_stock_service_lot.refService',
//         'tgaz_stock_service_lot.refLot',
//         "tvente_produit.designation",
//         "refCategorie",
//         "tgaz_stock_service_lot.pu",
//         "tvente_categorie_produit.designation",
//         "tgaz_stock_service_lot.qte",
//         "tgaz_stock_service_lot.uniteBase",
//         "tgaz_stock_service_lot.cmup"
//         )
//     ->orderBy("tvente_produit.designation", "asc")
//     ->get();

//     // ============ LEs Mouvements =========================================================================

//         // Récupérer les données de stock, mouvements et ventes en une seule requête 
//         $data1 = DB::table('tgaz_stock_service_lot')
//         ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//         ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//         ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
//         ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $date2, $idService) {
//             $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
//                  ->where('mvtEntree.type_mouvement', '=', 'Entree')
//                  ->whereBetween('mvtEntree.dateMvt', [$date1, $date2]);;
//         })
    
//             // Utilisez distinct() avant select()
//             ->distinct()
//             ->select(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation as designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation as Categorie",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase","nom_service",
//                 "tgaz_stock_service_lot.cmup",
//                 "tgaz_stock_service_lot.devise",
//                 "tgaz_stock_service_lot.taux",            
//                 DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteBase * mvtEntree.qteMvt), 3), 0) as stockEntree')
    
//             )
//             ->where([
//                 ['tgaz_stock_service_lot.refService', '=', $idService]
//             ])
//             ->groupBy(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase",
//                 "nom_service",
//                 "tgaz_stock_service_lot.cmup",
//                 "tgaz_stock_service_lot.devise",
//                 "tgaz_stock_service_lot.taux"
//                 )
//             ->orderBy("tvente_produit.designation", "asc")
//             ->get();
    
//     //======================================================================
    
//         // Récupérer les données de stock, mouvements et ventes en une seule requête 
//         $data2 = DB::table('tgaz_stock_service_lot')
//         ->join('tvente_services', 'tvente_services.id', '=', 'tgaz_stock_service_lot.refService')
//         ->Join('tvente_produit', 'tvente_produit.id', '=', 'tgaz_stock_service_lot.refLot')
//         ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
//         ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $date2, $idService) {
//             $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
//                  ->where('mvtSortie.type_mouvement', '=', 'Sortie')
//                  ->whereBetween('mvtSortie.dateMvt', [$date1, $date2]);;
//         })
    
//             // Utilisez distinct() avant select()
//             ->distinct()
//             ->select(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation as designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation as Categorie",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase","nom_service",
//                 "tgaz_stock_service_lot.cmup",
//                 "tgaz_stock_service_lot.devise",
//                 "tgaz_stock_service_lot.taux",            
//                 DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteBase * mvtSortie.qteMvt), 3), 0) as stockSortie'),
    
//             )
//             ->where([
//                 ['tgaz_stock_service_lot.refService', '=', $idService]
//             ])
//             ->groupBy(
//                 "tgaz_stock_service_lot.id",
//                 'tgaz_stock_service_lot.refService',
//                 'tgaz_stock_service_lot.refLot',
//                 "tvente_produit.designation",
//                 "refCategorie",
//                 "tgaz_stock_service_lot.pu",
//                 "tvente_categorie_produit.designation",
//                 "tgaz_stock_service_lot.qte",
//                 "tgaz_stock_service_lot.uniteBase",
//                 "nom_service",
//                 "tgaz_stock_service_lot.cmup",
//                 "tgaz_stock_service_lot.devise",
//                 "tgaz_stock_service_lot.taux"
//                 )
//             ->orderBy("tvente_produit.designation", "asc")
//             ->get();
    

//     // Vérifiez que les deux tableaux ont la même longueur
//     if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
//     && (count($data1) === count($data22)))
//     {
//         for ($i = 0; $i < count($data1); $i++) {
//             $row11 = $data11[$i];
//             $row22 = $data22[$i];
//             $row1 = $data1[$i];
//             $row2 = $data2[$i];            

//             $totalSortie = floatval($row22->totalSortie);
//             $totalEntree = floatval($row11->totalEntree);

//             $stockSortie = floatval($row2->stockSortie);            
//             $stockEntree = floatval($row1->stockEntree);

//             $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
//             $totalGEntree = floatval($stockEntree);
//             $totalG = floatval($totalSI) + floatval($stockEntree);
//             $TGSortie = floatval($stockSortie);
//             $totalSF = floatval($totalG) - floatval($stockSortie);
//             $totalPT = floatval($totalSF) * floatval($row2->cmup);

//             $data_return[] = [
//                 'id' => $row1->id,
//                 'Service' => $row1->nom_service,
//                 'designation' => $row1->designation,
//                 'Categorie' => $row1->Categorie,
//                 'SI' => $totalSI,
//                 'Entree' =>$totalGEntree,
//                 'Total' => $totalG,
//                 'Sortie' => $TGSortie,
//                 'SF' => $totalSF,
//                 // 'PU' => round($row1->cmup,2),
//                 // 'PT' => round($totalPT,2),
//                 'Unité' => $row1->uniteBase
//             ];

//         }
//     } 
//     else {
//         // Gérer le cas où les tableaux n'ont pas la même longueur
//         echo 'Les tableaux ont pas la même longueur.';
//     }

//     return response()->json($data_return);

//     }



//     return response()->json(['error' => 'Invalid parameters'], 400);
// }
//=============== FICHE DE STOCK DES SERVICES BY CATEGORIE EXCEL=======================================================================================
function pdf_fiche_gaz_stock_vente_service_bycategorie_excel(Request $request)
{
    if ($request->get('date1') && $request->get('date2') && $request->get('idCategorie') && $request->get('idService')) {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refCategorie = $request->get('idCategorie');
        $idService = $request->get('idService');

        $data_return = []; // Initialisation du tableau pour stocker les résultat

    $data11 = DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
        $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtEntree.type_mouvement', '=', 'Entree')
             ->where('dtEntree.dateMvt', '<', $date1);
    })

        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot as designation",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot as Categorie",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux",            
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteMvt), 3), 0) as totalEntree'),

        )
        ->where([
            ['tgaz_lot.refCategorieLot', '=', $refCategorie],
            ['tgaz_stock_service_lot.refService', '=', $idService]
        ])
        ->groupBy("tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot",
            "refCategorieLot",
            "tgaz_categorie_lot.nom_categorie_lot",
            "tgaz_stock_service_lot.pu_lot",            
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux")
        ->orderBy("tgaz_lot.nom_lot", "asc")
        ->get();



    $data22 =  DB::table('tgaz_stock_service_lot')
    ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
    ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')

    ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
        $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
             ->where('dtSortie.type_mouvement', '=', 'Sortie')
             ->where('dtSortie.dateMvt', '<', $date1);
    })
    // Utilisez distinct() avant select()
    ->distinct()
    ->select(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot as designation",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot as Categorie",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux",
        DB::raw('IFNULL(ROUND(SUM(dtSortie.qteMvt), 3), 0) as totalSortie')
    )
    ->where([
        ['tgaz_lot.refCategorieLot', '=', $refCategorie],
        ['tgaz_stock_service_lot.refService', '=', $idService]
    ])
    ->groupBy(
        "tgaz_stock_service_lot.id",
        'tgaz_stock_service_lot.refService',
        'tgaz_stock_service_lot.refLot',
        "tgaz_lot.nom_lot",
        "refCategorieLot",
        "tgaz_categorie_lot.nom_categorie_lot",
        "tgaz_stock_service_lot.pu_lot",            
        "tgaz_stock_service_lot.qte_lot",
        "tgaz_lot.unite_lot",
        "tgaz_stock_service_lot.cmup_lot",
        "tgaz_stock_service_lot.devise",
        "tgaz_stock_service_lot.taux"
        )
    ->orderBy("tgaz_lot.nom_lot", "asc")
    ->get();

    // ============ LEs Mouvements =========================================================================

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data1 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtEntree.type_mouvement', '=', 'Entree')
                 ->whereBetween('mvtEntree.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteMvt), 3), 0) as stockEntree'),
    
            )
            ->where([
                ['tgaz_lot.refCategorieLot', '=', $refCategorie],
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    
    //======================================================================
    
        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data2 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $date2, $idService) {
            $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtSortie.type_mouvement', '=', 'Sortie')
                 ->whereBetween('mvtSortie.dateMvt', [$date1, $date2]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as designation",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot as Categorie",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteMvt), 3), 0) as stockSortie'),
    
            )
            ->where([
                ['tgaz_lot.refCategorieLot', '=', $refCategorie],
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "refCategorieLot",
                "tgaz_categorie_lot.nom_categorie_lot",
                "tgaz_stock_service_lot.pu_lot",            
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux"
                )
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
        
    
        // Vérifiez que les deux tableaux ont la même longueur
        if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
        && (count($data1) === count($data22)))
        {
            for ($i = 0; $i < count($data1); $i++) {
                $row11 = $data11[$i];
                $row22 = $data22[$i];
                $row1 = $data1[$i];
                $row2 = $data2[$i];            
    
                $totalSortie = floatval($row22->totalSortie);
                $totalEntree = floatval($row11->totalEntree);
    
                $stockSortie = floatval($row2->stockSortie);            
                $stockEntree = floatval($row1->stockEntree);
    
                $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
                $totalGEntree = floatval($stockEntree);
                $totalG = floatval($totalSI) + floatval($stockEntree);
                $TGSortie = floatval($stockSortie);
                $totalSF = floatval($totalG) - floatval($stockSortie);
                $totalPT = floatval($totalSF) * floatval($row2->cmup_lot);
    
                $data_return[] = [
                    'id' => $row1->id,
                    'Service' => $row1->nom_service,
                    'designation' => $row1->designation,
                    'Categorie' => $row1->Categorie,
                    'SI' => $totalSI,
                    'Entree' =>$totalGEntree,
                    'Total' => $totalG,
                    'Sortie' => $TGSortie,
                    'SF' => $totalSF,
                    'PU' => round($row1->cmup_lot,2),
                    'PT' => round($totalPT,2),
                    'Unité' => $row1->unite_lot
                ];
    
            }
        } 
        else {
            // Gérer le cas où les tableaux n'ont pas la même longueur
            echo 'Les tableaux ont pas la même longueur.';
        }
    
        return response()->json($data_return);
    
        }
 
    return response()->json(['error' => 'Invalid parameters'], 400);
}


//===== Vente Service Excel

function pdf_detail_vente_service_excel(Request $request)
{

   if ($request->get('date1') && $request->get('date2') && $request->get('idService')) {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $idService = $request->get('idService');

        $data_return = []; // Initialisation du tableau pour stocker les résultats

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTVA')
       ->selectRaw('ROUND((IFNULL(montant,0)),2) as totalFacture')
       ->selectRaw('ROUND((montanttva),2) as TotalTVA')
       ->selectRaw('ROUND((((IFNULL(montant,0)) - montantreduction)+(montanttva)),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->selectRaw('CONCAT("S",YEAR(dateVente),"",MONTH(dateVente),"00",refEnteteVente) as codeFacture')
        ->where([
            ['dateVente','>=', $date1],
            ['dateVente','<=', $date2],
            ['tvente_services.id','=', $idService]
        ])
        ->orderBy("tgaz_detail_vente.created_at", "asc")    
        ->get();   

    // Vérifiez que les deux tableaux ont la même longueur
    if ($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $row1 = $data[$i];

            $data_return[] = [
                'N°FACT.' => $row1->codeFacture,
                'CLIENT' => $row1->noms,
                'DATE FACTURE.' => $row1->dateVente,
                'KIT' => $row1->nom_lot,
                'PRODUIT' => $row1->designation,
                'UNITE' => $row1->uniteVente,
                'QTE_VENTE' => $row1->qteVente,
                'PU_VENTE' => $row1->puVente,
                'PT_VENTE' => $row1->PTVente,
                'TVA' => $row1->montanttva,                
                'PT_TVA' => $row1->PTVenteTVA, 
                'CMUP' => $row1->cmupVente ,               
                'DEVISE' => $row1->devise 
            ];

            //cmupVente

        }
    } 
    else {
        // Gérer le cas où les tableaux n'ont pas la même longueur
        echo 'Les tableaux ont pas la même longueur.';
    }

     return response()->json($data_return);

    }

    return response()->json(['error' => 'Invalid parameters'], 400);
}







}
