<?php

namespace App\Http\Controllers\Vehicule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfVehiculeController extends Controller
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

//=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================


function pdf_fiche_stock_vehicule(Request $request)
{

    if ($request->get('date1') && $request->get('date2')&& $request->get('refVehicule')&& $request->get('refProvenance')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refVehicule = $request->get('refVehicule');
        $refProvenance = $request->get('refProvenance');
        
        $html = $this->getInfoFicheStock($date1,$date2,$refVehicule,$refProvenance);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoFicheStock($date1,$date2,$refVehicule,$refProvenance)
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
            $totalBanque=0;
            $sommeSorties=0;        
            $sommeRetours=0;
            $sommeCasse=0;
            $sommeVente=0;        
            $sommeEmballage=0;
            $sommeDiffEmballage=0;
            $sommePU=0;
            $sommePT=0; 
            $sommeDiffBanque=0;
            
           //,$refVehicule,$refProvenance
            $data2 = DB::table('tcar_detail_entree')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_entree.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_entree.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as sommeEntree'))
            ->where([               
                ['tcar_entete_mouvement.dateMvt','>=', $date1],
                ['tcar_entete_mouvement.dateMvt','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])               
            ->get();
            foreach ($data2 as $row2) 
            {                                
               $sommeSorties=$row2->sommeEntree;                           
            }
    
            $data3 = DB::table('tcar_detail_solde')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_solde.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteSolde),0),0) as sommeSolde'))
            ->where([               
                ['tcar_entete_mouvement.dateMvt','>=', $date1],
                ['tcar_entete_mouvement.dateMvt','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])
            ->get(); 
            
            foreach ($data3 as $row3) 
            {                                
               $sommeRetours=$row3->sommeSolde;                           
            } 
            
            $data4 = DB::table('tcar_detail_casse')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteCasse),0),0) as sommeCasse'))
            ->where([               
                ['tcar_entete_mouvement.dateMvt','>=', $date1],
                ['tcar_entete_mouvement.dateMvt','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])
            ->get(); 
            
            foreach ($data4 as $row4) 
            {                                
               $sommeCasse=$row4->sommeCasse;                           
            } 
           
    
            $data5 =   DB::select(
                'select (IFNULL(ROUND(:quanteSortie,0),0) - IFNULL(ROUND(:quanteRetour,0),0)) as Vente from tcar_produit',
                 ['quanteSortie' => $sommeSorties,'quanteRetour'=>$sommeRetours]
            );         
             foreach ($data5 as $row5) 
             {                                
                $sommeVente=$row5->Vente;                           
             }
    
    
             $data6 = DB::table('tcar_emballage')
             ->join('tcar_produit','tcar_produit.id','=','tcar_emballage.refProduit')
             ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_emballage.refEnteteMvt')
             ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
             ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
             ->select(DB::raw('IFNULL(ROUND(SUM(qteEmballage),0),0) as sommeEmballage'))
             ->where([               
                 ['tcar_entete_mouvement.dateMvt','>=', $date1],
                 ['tcar_entete_mouvement.dateMvt','<=', $date2],
                 ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                 ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
             ])
             ->get(); 
             
             foreach ($data6 as $row6) 
             {                                
                $sommeEmballage=$row6->sommeEmballage;                           
             }
    
    
             $data7 =   DB::select(
                'select (IFNULL(ROUND(:quanteVente,0),0) - IFNULL(ROUND(:quanteEmballage,0),0)) as diffrence from tcar_produit',
                 ['quanteVente' => $sommeVente,'quanteEmballage'=>$sommeEmballage]
            );         
             foreach ($data7 as $row7) 
             {                                
                $sommeDiffEmballage=$row7->diffrence;                           
             }
    
            $data8 =   DB::select(
                'select ((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) as PT from tcar_produit',
                 ['quantiteVente'=>$sommeVente]
            );         
            foreach ($data8 as $row8) 
            { 
               $sommePT=$row8->PT;                         
            }


            //
            $data9 = DB::table('tcar_paiement')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')    
            ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select(DB::raw('ROUND(SUM(montant_paie),0) as TotalFacture'))
            ->where([
                ['tcar_entete_mouvement.dateMvt','>=', $date1],
                ['tcar_entete_mouvement.dateMvt','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])               
            ->get();

            foreach ($data9 as $row9) 
            {                                
               $totalBanque=$row9->TotalFacture;                           
            }            

            $data10 =   DB::select(
                'select (((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) - (IFNULL(:sommeBanque,0))) as DiffBanque from tcar_produit',
                 ['quantiteVente'=>$sommeVente,'sommeBanque'=>$totalBanque]
            );         
            foreach ($data10 as $row10) 
            { 
               $sommeDiffBanque=$row10->DiffBanque;                         
            }

            $numBS ='';
            $numCD ='';
            $numSR = '';
            $chauffeur='';
            $data11 = DB::table('tcar_entete_mouvement')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
            'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
            'adresse_prod','contact_prod','mail_prod','autres_details',
            'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at')
            ->where([
                ['tcar_entete_mouvement.dateMvt','>=', $date1],
                ['tcar_entete_mouvement.dateMvt','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])               
            ->get();

            foreach ($data11 as $row11) 
            { 
                $numBS =$row11->numBS;
                $numCD =$row11->numCD;
                $numSR = $row11->numSR;
                $chauffeur=$row11->Chauffeur;                          
            }

            $taux ='';
            $data12 = DB::table('tcar_detail_solde')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
            ->select('tcar_detail_solde.taux')
            ->where([
                ['tcar_entete_mouvement.created_at','>=', $date1],
                ['tcar_entete_mouvement.created_at','<=', $date2],
                ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
                ['tcar_entete_mouvement.refProvenance','<=', $refProvenance]
            ])               
            ->get();

            foreach ($data12 as $row12) 
            { 
                $taux =$row12->taux;                         
            }
    
            $output=' 
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheVehicule</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs521614FC {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:21px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE8F05E7D {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csE3533A66 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs42A10089 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF5E0124A {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csCA245929 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs5FFBCC93 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs8F6FECFF {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs19BA95F9 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEDFC256 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs922335F6 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .csBBE8595E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs5CD81C98 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs74C60957 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csA24373A {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs63A2338B {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0133C2C {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:282px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:94px;"></td>
                    <td style="height:0px;width:120px;"></td>
                    <td style="height:0px;width:69px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:92px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:58px;"></td>
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
                    <td style="width:0px;height:28px;"></td>
                    <td></td>
                    <td class="cs521614FC" colspan="11" style="width:648px;height:26px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;MOUVEMENTS&nbsp;DES&nbsp;VEHICULES</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:119px;height:88px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:119px;height:88px;">
                        <img alt="" src="'.$pic2.'" style="width:119px;height:88px;" /></div>
                    </td>
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
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;BS&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numBS.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs86F8EF7F" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;CD&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numCD.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs86F8EF7F" rowspan="2" style="width:92px;height:15px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;SR&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" rowspan="2" style="width:258px;height:15px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numSR.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csCE72709D" colspan="2" rowspan="3" style="width:63px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&nbsp;:</nobr></td>
                    <td class="cs38AECAED" colspan="3" rowspan="3" style="width:178px;height:22px;line-height:15px;text-align:right;vertical-align:top;"><nobr>Du&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$date2.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" rowspan="3" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Chaiffeur&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" rowspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$chauffeur.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:92px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TAUX&nbsp;:</nobr></td>
                    <td class="csAB3AA82A" style="width:119px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$taux.'&nbsp;FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs922335F6" colspan="13" style="width:723px;height:15px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SUIVI&nbsp;PRODUITS</nobr></td>
                    <td class="cs5CD81C98" colspan="4" style="width:218px;height:15px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SUIVI&nbsp;EMBALLAGES</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:212px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" style="width:68px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIES</nobr></td>
                    <td class="cs8F6FECFF" style="width:69px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RETOURS</nobr></td>
                    <td class="cs63A2338B" colspan="2" style="width:60px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CASSE</nobr></td>
                    <td class="cs42A10089" colspan="2" style="width:73px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>VENTES</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:92px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="cs6F7E55AC" colspan="3" style="width:147px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                    <td class="csC73F4F41" style="width:91px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RET&nbsp;THEO</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:72px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RET&nbsp;PHY</nobr></td>
                    <td class="cs6F7E55AC" style="width:57px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DIF</nobr></td>
                </tr>
                ';
                                                                                        
                                  $output .= $this->showDetailFicheStock($date1,$date2,$refVehicule,$refProvenance); 
                                                                                        
                                  $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csCA245929" colspan="2" style="width:212px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs6F7E55AC" style="width:68px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeSorties.'</nobr></td>
                    <td class="cs5FFBCC93" style="width:69px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeRetours.'</nobr></td>
                    <td class="cs74C60957" colspan="2" style="width:60px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeCasse.'</nobr></td>
                    <td class="csE8F05E7D" colspan="2" style="width:73px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeVente.'</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:92px;height:17px;"></td>
                    <td class="csE3533A66" colspan="3" style="width:147px;height:17px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$sommePT.'&nbsp;FC</nobr></td>
                    <td class="csC73F4F41" style="width:91px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeVente.'</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:72px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeEmballage.'</nobr></td>
                    <td class="cs6F7E55AC" style="width:57px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeDiffEmballage.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csBBE8595E" colspan="6" style="width:408px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>BANQUE</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csCA245929" colspan="2" style="width:212px;height:15px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BANQUE&nbsp;FC</nobr></td>
                    <td class="cs42A10089" colspan="4" style="width:199px;height:15px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalBanque.'&nbsp;FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td class="csCA245929" colspan="2" style="width:212px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DIFFERENCE</nobr></td>
                    <td class="cs42A10089" colspan="4" style="width:199px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$sommeDiffBanque.'FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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






function showDetailFicheStock($date1,$date2,$refVehicule,$refProvenance)
{
    $data1 = DB::table('tcar_produit')        
    ->select("tcar_produit.id","tcar_produit.designation as designation",
    'pu','devise','taux','unite','author')   
    ->orderBy("tcar_produit.id", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSorties=0;        
        $totalRetours=0;
        $totalCasse=0;
        $totalVente=0;        
        $totalEmballage=0;
        $totalDiffEmballage=0;
        $totalPU=0;
        $totalPT=0;   
        //
        $data2 = DB::table('tcar_detail_entree')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_entree.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_entree.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([               
            ['tcar_entete_mouvement.dateMvt','>=', $date1],
            ['tcar_entete_mouvement.dateMvt','<=', $date2],
            ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
            ['tcar_entete_mouvement.refProvenance','<=', $refProvenance],
            ['tcar_produit.id','=', $row1->id]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalSorties=$row2->totalEntree;                           
        }

        $data3 = DB::table('tcar_detail_solde')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_solde.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSolde),0),0) as totalSolde'))
        ->where([               
            ['tcar_entete_mouvement.dateMvt','>=', $date1],
            ['tcar_entete_mouvement.dateMvt','<=', $date2],
            ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
            ['tcar_entete_mouvement.refProvenance','<=', $refProvenance],
            ['tcar_produit.id','=', $row1->id]
        ])
        ->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalRetours=$row3->totalSolde;                           
        } 
        
        $data4 = DB::table('tcar_detail_casse')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteCasse),0),0) as totalCasse'))
        ->where([               
            ['tcar_entete_mouvement.dateMvt','>=', $date1],
            ['tcar_entete_mouvement.dateMvt','<=', $date2],
            ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
            ['tcar_entete_mouvement.refProvenance','<=', $refProvenance],
            ['tcar_produit.id','=', $row1->id]
        ])
        ->get(); 
        
        foreach ($data4 as $row4) 
        {                                
           $totalCasse=$row4->totalCasse;                           
        } 
       

        $data5 =   DB::select(
            'select (IFNULL(ROUND(:quanteSortie,0),0) - IFNULL(ROUND(:quanteRetour,0),0)) as Vente from tcar_produit  
             where (tcar_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteSortie' => $totalSorties,'quanteRetour'=>$totalRetours]
        );         
         foreach ($data5 as $row5) 
         {                                
            $totalVente=$row5->Vente;                           
         }


         $data6 = DB::table('tcar_emballage')
         ->join('tcar_produit','tcar_produit.id','=','tcar_emballage.refProduit')
         ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_emballage.refEnteteMvt')
         ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
         ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
         ->select(DB::raw('IFNULL(ROUND(SUM(qteEmballage),0),0) as totalEmballage'))
         ->where([               
             ['tcar_entete_mouvement.dateMvt','>=', $date1],
             ['tcar_entete_mouvement.dateMvt','<=', $date2],
             ['tcar_entete_mouvement.refVehicule','<=', $refVehicule],
             ['tcar_entete_mouvement.refProvenance','<=', $refProvenance],
             ['tcar_produit.id','=', $row1->id]
         ])
         ->get(); 
         
         foreach ($data6 as $row6) 
         {                                
            $totalEmballage=$row6->totalEmballage;                           
         }


         $data7 =   DB::select(
            'select (IFNULL(ROUND(:quanteVente,0),0) - IFNULL(ROUND(:quanteEmballage,0),0)) as diffrence from tcar_produit  
             where (tcar_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteVente' => $totalVente,'quanteEmballage'=>$totalEmballage]
        );         
         foreach ($data7 as $row7) 
         {                                
            $totalDiffEmballage=$row7->diffrence;                           
         }

        $data8 =   DB::select(
            'select ((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) as PT from tcar_produit  
             where tcar_produit.id = :idPro',
             ['quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data8 as $row8) 
        { 
           $totalPT=$row8->PT;                         
        }

        $data9 = DB::select(
            'select ((IFNULL(ROUND(:PTVente,0),0))/(IFNULL(ROUND(:quantiteVente,0),0))) as PU from tcar_produit  
             where tcar_produit.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data9 as $row9) 
        { 
           $totalPU=$row9->PU;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:18px;"></td>
                <td></td>
                <td class="csCA245929" colspan="2" style="width:212px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row1->designation.'</nobr></td>
                <td class="csE3533A66" style="width:68px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalSorties.'</nobr></td>
                <td class="cs19BA95F9" style="width:69px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalRetours.'</nobr></td>
                <td class="csE0133C2C" colspan="2" style="width:60px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalCasse.'</nobr></td>
                <td class="csF5E0124A" colspan="2" style="width:73px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'</nobr></td>
                <td class="csEDFC256" colspan="2" style="width:92px;height:16px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$totalPU.'&nbsp;FC</nobr></td>
                <td class="csE8F05E7D" colspan="3" style="width:147px;height:16px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$totalPT.'&nbsp;FC</nobr></td>
                <td class="csA24373A" style="width:91px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'</nobr></td>
                <td class="csA24373A" colspan="2" style="width:72px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalEmballage.'</nobr></td>
                <td class="csE3533A66" style="width:57px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalDiffEmballage.'</nobr></td>
            </tr>
        ';
 
    }

    return $output;

}













//=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================


function pdf_fiche_stock_vehicule_entete(Request $request)
{

    if ($request->get('id')) {
        // code...
        $id = $request->get('id');
        
        $html = $this->getInfoFicheStockEntete($id);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoFicheStockEntete($id)
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
            $totalBanque=0;
            $sommeSorties=0;        
            $sommeRetours=0;
            $sommeCasse=0;
            $sommeVente=0;        
            $sommeEmballage=0;
            $sommeDiffEmballage=0;
            $sommePU=0;
            $sommePT=0; 
            $sommeDiffBanque=0;
            

            $data2 = DB::table('tcar_detail_entree')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_entree.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_entree.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as sommeEntree'))
            ->where([               
                ['tcar_entete_mouvement.id','=', $id]
            ])               
            ->get();
            foreach ($data2 as $row2) 
            {                                
               $sommeSorties=$row2->sommeEntree;                           
            }
    
            $data3 = DB::table('tcar_detail_solde')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_solde.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteSolde),0),0) as sommeSolde'))
            ->where([               
                ['tcar_entete_mouvement.id','=', $id]
            ])
            ->get(); 
            
            foreach ($data3 as $row3) 
            {                                
               $sommeRetours=$row3->sommeSolde;                           
            } 
            
            $data4 = DB::table('tcar_detail_casse')
            ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select(DB::raw('IFNULL(ROUND(SUM(qteCasse),0),0) as sommeCasse'))
            ->where([               
                ['tcar_entete_mouvement.id','=', $id]
            ])
            ->get(); 
            
            foreach ($data4 as $row4) 
            {                                
               $sommeCasse=$row4->sommeCasse;                           
            } 
           
    
            $data5 =   DB::select(
                'select (IFNULL(ROUND(:quanteSortie,0),0) - IFNULL(ROUND(:quanteRetour,0),0)) as Vente from tcar_produit',
                 ['quanteSortie' => $sommeSorties,'quanteRetour'=>$sommeRetours]
            );         
             foreach ($data5 as $row5) 
             {                                
                $sommeVente=$row5->Vente;                           
             }
    
    
             $data6 = DB::table('tcar_emballage')
             ->join('tcar_produit','tcar_produit.id','=','tcar_emballage.refProduit')
             ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_emballage.refEnteteMvt')
             ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
             ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
             ->select(DB::raw('IFNULL(ROUND(SUM(qteEmballage),0),0) as sommeEmballage'))
             ->where([               
                ['tcar_entete_mouvement.id','=', $id]
             ])
             ->get(); 
             
             foreach ($data6 as $row6) 
             {                                
                $sommeEmballage=$row6->sommeEmballage;                           
             }
    
    
             $data7 =   DB::select(
                'select (IFNULL(ROUND(:quanteVente,0),0) - IFNULL(ROUND(:quanteEmballage,0),0)) as diffrence from tcar_produit',
                 ['quanteVente' => $sommeVente,'quanteEmballage'=>$sommeEmballage]
            );         
             foreach ($data7 as $row7) 
             {                                
                $sommeDiffEmballage=$row7->diffrence;                           
             }
    
            $data8 =   DB::select(
                'select ((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) as PT from tcar_produit',
                 ['quantiteVente'=>$sommeVente]
            );         
            foreach ($data8 as $row8) 
            { 
               $sommePT=$row8->PT;                         
            }

            


            //
            $data9 = DB::table('tcar_paiement')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')    
            ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select(DB::raw('ROUND(SUM(montant_paie),0) as TotalFacture'))
            ->where([
                ['tcar_entete_mouvement.id','=', $id]
            ])               
            ->get();

            foreach ($data9 as $row9) 
            {                                
               $totalBanque=$row9->TotalFacture;                           
            }            

            $data10 =   DB::select(
                'select (((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) - (IFNULL(:sommeBanque,0))) as DiffBanque from tcar_produit',
                 ['quantiteVente'=>$sommeVente,'sommeBanque'=>$totalBanque]
            );         
            foreach ($data10 as $row10) 
            { 
               $sommeDiffBanque=$row10->DiffBanque;                         
            }

            $numBS ='';
            $numCD ='';
            $numSR = '';
            $chauffeur='';
            $dateMvt='';

            $data11 = DB::table('tcar_entete_mouvement')
            ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
            ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
            ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
            'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
            'adresse_prod','contact_prod','mail_prod','autres_details',
            'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at')
            ->where([
                ['tcar_entete_mouvement.id','=', $id]
            ])               
            ->get();

            foreach ($data11 as $row11) 
            { 
                $numBS =$row11->numBS;
                $numCD =$row11->numCD;
                $numSR = $row11->numSR;
                $chauffeur=$row11->Chauffeur;
                $dateMvt=$row11->dateMvt;                          
            }

            $taux ='';
            $data12 = DB::table('tcar_detail_solde')
            ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
            ->select('tcar_detail_solde.taux')
            ->where([
                ['tcar_entete_mouvement.id','=', $id]
            ])               
            ->get();

            foreach ($data12 as $row12) 
            { 
                $taux =$row12->taux;                         
            }
    
            $output=' 
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheVehicule</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs521614FC {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:21px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE8F05E7D {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csE3533A66 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs42A10089 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF5E0124A {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csCA245929 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs5FFBCC93 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs8F6FECFF {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .cs19BA95F9 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .csEDFC256 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs86F8EF7F {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; }
                    .cs922335F6 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .csBBE8595E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .cs58C16240 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .cs5CD81C98 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:italic; padding-left:2px;padding-right:2px;}
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs74C60957 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; }
                    .csA24373A {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                    .cs63A2338B {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0133C2C {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; }
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:282px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:94px;"></td>
                    <td style="height:0px;width:120px;"></td>
                    <td style="height:0px;width:69px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:32px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:23px;"></td>
                    <td style="height:0px;width:70px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:39px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:92px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:58px;"></td>
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
                    <td style="width:0px;height:28px;"></td>
                    <td></td>
                    <td class="cs521614FC" colspan="11" style="width:648px;height:26px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;MOUVEMENTS&nbsp;DES&nbsp;VEHICULES</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:119px;height:88px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:119px;height:88px;">
                        <img alt="" src="'.$pic2.'" style="width:119px;height:88px;" /></div>
                    </td>
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
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;BS&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numBS.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs86F8EF7F" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;CD&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numCD.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs86F8EF7F" rowspan="2" style="width:92px;height:15px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;SR&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" rowspan="2" style="width:258px;height:15px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$numSR.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csCE72709D" colspan="2" rowspan="3" style="width:63px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Periode&nbsp;:</nobr></td>
                    <td class="cs38AECAED" colspan="3" rowspan="3" style="width:178px;height:22px;line-height:15px;text-align:right;vertical-align:top;"><nobr>Du&nbsp;'.$dateMvt.'&nbsp;&nbsp;au&nbsp;&nbsp;'.$dateMvt.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:2px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" rowspan="3" style="width:92px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>Chaiffeur&nbsp;:</nobr></td>
                    <td class="cs58C16240" colspan="3" rowspan="3" style="width:258px;height:14px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$chauffeur.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs86F8EF7F" style="width:92px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TAUX&nbsp;:</nobr></td>
                    <td class="csAB3AA82A" style="width:119px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$taux.'&nbsp;FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="cs922335F6" colspan="13" style="width:723px;height:15px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SUIVI&nbsp;PRODUITS</nobr></td>
                    <td class="cs5CD81C98" colspan="4" style="width:218px;height:15px;line-height:13px;text-align:center;vertical-align:top;"><nobr>SUIVI&nbsp;EMBALLAGES</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:212px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" style="width:68px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIES</nobr></td>
                    <td class="cs8F6FECFF" style="width:69px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RETOURS</nobr></td>
                    <td class="cs63A2338B" colspan="2" style="width:60px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>CASSE</nobr></td>
                    <td class="cs42A10089" colspan="2" style="width:73px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>VENTES</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:92px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                    <td class="cs6F7E55AC" colspan="3" style="width:147px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                    <td class="csC73F4F41" style="width:91px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RET&nbsp;THEO</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:72px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RET&nbsp;PHY</nobr></td>
                    <td class="cs6F7E55AC" style="width:57px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DIF</nobr></td>
                </tr>
                ';
                                                                                        
                                  $output .= $this->showDetailFicheStockEntete($id); 
                                                                                        
                                  $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csCA245929" colspan="2" style="width:212px;height:17px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs6F7E55AC" style="width:68px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeSorties.'</nobr></td>
                    <td class="cs5FFBCC93" style="width:69px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeRetours.'</nobr></td>
                    <td class="cs74C60957" colspan="2" style="width:60px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeCasse.'</nobr></td>
                    <td class="csE8F05E7D" colspan="2" style="width:73px;height:17px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>'.$sommeVente.'</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:92px;height:17px;"></td>
                    <td class="csE3533A66" colspan="3" style="width:147px;height:17px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$sommePT.'&nbsp;FC</nobr></td>
                    <td class="csC73F4F41" style="width:91px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeVente.'</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:72px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeEmballage.'</nobr></td>
                    <td class="cs6F7E55AC" style="width:57px;height:17px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeDiffEmballage.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csBBE8595E" colspan="6" style="width:408px;height:17px;line-height:15px;text-align:center;vertical-align:top;"><nobr>BANQUE</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td class="csCA245929" colspan="2" style="width:212px;height:15px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;BANQUE&nbsp;FC</nobr></td>
                    <td class="cs42A10089" colspan="4" style="width:199px;height:15px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalBanque.'&nbsp;FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:18px;"></td>
                    <td></td>
                    <td class="csCA245929" colspan="2" style="width:212px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>DIFFERENCE</nobr></td>
                    <td class="cs42A10089" colspan="4" style="width:199px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$sommeDiffBanque.'FC</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
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






function showDetailFicheStockEntete($id)
{
    $data1 = DB::table('tcar_produit')        
    ->select("tcar_produit.id","tcar_produit.designation as designation",
    'pu','devise','taux','unite','author')   
    ->orderBy("tcar_produit.id", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSorties=0;        
        $totalRetours=0;
        $totalCasse=0;
        $totalVente=0;        
        $totalEmballage=0;
        $totalDiffEmballage=0;
        $totalPU=0;
        $totalPT=0;   
        //
        $data2 = DB::table('tcar_detail_entree')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_entree.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_entree.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteEntree),0),0) as totalEntree'))
        ->where([               
            ['tcar_entete_mouvement.id','=', $id],
            ['tcar_produit.id','=', $row1->id]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalSorties=$row2->totalEntree;                           
        }

        $data3 = DB::table('tcar_detail_solde')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_solde.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_solde.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteSolde),0),0) as totalSolde'))
        ->where([               
            ['tcar_entete_mouvement.id','=', $id],
            ['tcar_produit.id','=', $row1->id]
        ])
        ->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalRetours=$row3->totalSolde;                           
        } 
        
        $data4 = DB::table('tcar_detail_casse')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select(DB::raw('IFNULL(ROUND(SUM(qteCasse),0),0) as totalCasse'))
        ->where([               
            ['tcar_entete_mouvement.id','=', $id],
            ['tcar_produit.id','=', $row1->id]
        ])
        ->get(); 
        
        foreach ($data4 as $row4) 
        {                                
           $totalCasse=$row4->totalCasse;                           
        } 
       

        $data5 =   DB::select(
            'select (IFNULL(ROUND(:quanteSortie,0),0) - IFNULL(ROUND(:quanteRetour,0),0)) as Vente from tcar_produit  
             where (tcar_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteSortie' => $totalSorties,'quanteRetour'=>$totalRetours]
        );         
         foreach ($data5 as $row5) 
         {                                
            $totalVente=$row5->Vente;                           
         }


         $data6 = DB::table('tcar_emballage')
         ->join('tcar_produit','tcar_produit.id','=','tcar_emballage.refProduit')
         ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_emballage.refEnteteMvt')
         ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
         ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
         ->select(DB::raw('IFNULL(ROUND(SUM(qteEmballage),0),0) as totalEmballage'))
         ->where([               
            ['tcar_entete_mouvement.id','=', $id],
             ['tcar_produit.id','=', $row1->id]
         ])
         ->get(); 
         
         foreach ($data6 as $row6) 
         {                                
            $totalEmballage=$row6->totalEmballage;                           
         }


         $data7 =   DB::select(
            'select (IFNULL(ROUND(:quanteVente,0),0) - IFNULL(ROUND(:quanteEmballage,0),0)) as diffrence from tcar_produit  
             where (tcar_produit.id = :idPro)',
             ['idPro' => $row1->id,'quanteVente' => $totalVente,'quanteEmballage'=>$totalEmballage]
        );         
         foreach ($data7 as $row7) 
         {                                
            $totalDiffEmballage=$row7->diffrence;                           
         }

        $data8 =   DB::select(
            'select ((IFNULL(ROUND(:quantiteVente,0),0)) * tcar_produit.pu) as PT from tcar_produit  
             where tcar_produit.id = :idPro',
             ['quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data8 as $row8) 
        { 
           $totalPT=$row8->PT;                         
        }

        $data9 = DB::select(
            'select ((IFNULL(ROUND(:PTVente,0),0))/(IFNULL(ROUND(:quantiteVente,0),0))) as PU from tcar_produit  
             where tcar_produit.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$totalVente,'idPro' => $row1->id]
        );         
        foreach ($data9 as $row9) 
        { 
           $totalPU=$row9->PU;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:18px;"></td>
                <td></td>
                <td class="csCA245929" colspan="2" style="width:212px;height:16px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row1->designation.'</nobr></td>
                <td class="csE3533A66" style="width:68px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalSorties.'</nobr></td>
                <td class="cs19BA95F9" style="width:69px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalRetours.'</nobr></td>
                <td class="csE0133C2C" colspan="2" style="width:60px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalCasse.'</nobr></td>
                <td class="csF5E0124A" colspan="2" style="width:73px;height:16px;line-height:9px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'</nobr></td>
                <td class="csEDFC256" colspan="2" style="width:92px;height:16px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$totalPU.'&nbsp;FC</nobr></td>
                <td class="csE8F05E7D" colspan="3" style="width:147px;height:16px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$totalPT.'&nbsp;FC</nobr></td>
                <td class="csA24373A" style="width:91px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalVente.'</nobr></td>
                <td class="csA24373A" colspan="2" style="width:72px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalEmballage.'</nobr></td>
                <td class="csE3533A66" style="width:57px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalDiffEmballage.'</nobr></td>
            </tr>
        ';
 
    }

    return $output;

}











//==================== RAPPORT DETAIL FACTURE SELON LE DEPARTEMENT =======================================

public function fetch_rapport_paiement_mouvement_date_vehicule(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refVehicule')&& $request->get('refProvenance')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refVehicule = $request->get('refVehicule');
        $refProvenance = $request->get('refProvenance');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementMouvement_Vehicule($date1, $date2,$refVehicule,$refProvenance);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}



function printRapportPaiementMouvement_Vehicule($date1, $date2,$refVehicule,$refProvenance)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tcar_paiement')
         ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
         ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
         ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
 
         ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
 
         ->select(DB::raw('ROUND(SUM(montant_paie),0) as TotalPaie'))
         ->where([
            ['date_paie','>=', $date1],
            ['date_paie','<=', $date2],
            ['refVehicule','=', $refVehicule],
            ['refProvenance','=', $refProvenance]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;                           
         }

         $nom_vehicule='';
         $nom_producteur='';

         $data3=DB::table('tcar_paiement')
         ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
         ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
         ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
 
         ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 
 
         ->select('tcar_paiement.id','refEnteteMvt','montant_paie','date_paie',
         'tcar_paiement.devise','tcar_paiement.taux','tcar_paiement.author',
         'tcar_paiement.created_at','refVehicule','refProvenance','dateMvt','numBS',
         'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
         'adresse_prod','contact_prod','mail_prod','autres_details','Chauffeur','modepaie',
         'libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
         'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte',
         'numero_ssouscompte','nom_souscompte','numero_souscompte',
         'tfin_souscompte.refCompte as refCompteBanque','nom_compte',
         'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
         'numero_classe','nom_typeposition',"nom_typecompte",'Info_devise')
         ->where([
            ['date_paie','>=', $date1],
            ['date_paie','<=', $date2],
            ['refVehicule','=', $refVehicule],
            ['refProvenance','=', $refProvenance]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_vehicule=$row->nom_vehicule;
            $nom_producteur=$row->nom_producteur;                 
        }



           

        $output='
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_RapportPaiementVehicule</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs72009732 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                    <td style="height:0px;width:121px;"></td>
                    <td style="height:0px;width:42px;"></td>
                    <td style="height:0px;width:82px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:55px;"></td>
                    <td style="height:0px;width:136px;"></td>
                    <td style="height:0px;width:101px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:113px;"></td>
                    <td style="height:0px;width:56px;"></td>
                    <td style="height:0px;width:2px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="7" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
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
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="3" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
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
                    <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
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
                    <td class="cs72009732" colspan="13" style="width:930px;height:32px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;RECETTES&nbsp;SUR&nbsp;LES&nbsp;MOUVEMENT&nbsp;DES&nbsp;VEHICULES</nobr></td>
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
                    <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$nom_vehicule.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$nom_producteur.'</nobr></td>
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
                    <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                    <td class="cs3DB3E5A1" colspan="2" style="width:162px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>VEHICULE&nbsp;-&nbsp;SOCIETE</nobr></td>
                    <td class="cs3DB3E5A1" colspan="2" style="width:92px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;DEPOT</nobr></td>
                    <td class="cs3DB3E5A1" colspan="2" style="width:190px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>BANQUE&nbsp;-&nbsp;BORDEREAU</nobr></td>
                    <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>INFO&nbsp;SUR&nbsp;DEVISE</nobr></td>
                    <td class="cs3DB3E5A1" colspan="3" style="width:128px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;CD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;ID</nobr></td>
                    <td class="cs3DB3E5A1" style="width:112px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT(FC)</nobr></td>
                    <td class="cs691A15EF" colspan="2" style="width:58px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                </tr>
                ';
                    
                                $output .= $this->showPaiementMouvement_Vehicule($date1, $date2,$refVehicule,$refProvenance); 
                    
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
                    <td class="cs49AA1D99" colspan="4" style="width:228px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;(FC)&nbsp;:</nobr></td>
                    <td class="csEAC52FCD" colspan="3" style="width:171px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'&nbsp;FC</nobr></td>
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
                    <td class="cs12FE94AA" colspan="2" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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

function showPaiementMouvement_Vehicule($date1, $date2,$refVehicule,$refProvenance)
{
        $data = DB::table('tcar_paiement')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_paiement.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')

        ->join('tconf_banque' , 'tconf_banque.id','=','tcar_paiement.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition') 

        ->select('tcar_paiement.id','refEnteteMvt','montant_paie','date_paie',
        'tcar_paiement.devise','tcar_paiement.taux','tcar_paiement.author',
        'tcar_paiement.created_at','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details','Chauffeur','modepaie',
        'libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte',
        'numero_ssouscompte','nom_souscompte','numero_souscompte',
        'tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte",'Info_devise')
        ->selectRaw('((montant_paie)/tcar_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tcar_paiement.id) as codeRecu')
        ->where([
            ['date_paie','>=', $date1],
            ['date_paie','<=', $date2],
            ['refVehicule','=', $refVehicule],
            ['refProvenance','=', $refProvenance]
        ])
        ->orderBy("tcar_paiement.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->date_paie.'</nobr></td>
                    <td class="cs3B0DD49A" colspan="2" style="width:162px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_vehicule.'&nbsp;-&nbsp;'.$row->nom_producteur.'</nobr></td>
                    <td class="cs3B0DD49A" colspan="2" style="width:92px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeRecu.'</nobr></td>
                    <td class="cs3B0DD49A" colspan="2" style="width:190px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->nom_banque.'&nbsp;-&nbsp;&nbsp;'.$row->nom_producteur.'</nobr></td>
                    <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->Info_devise.'</nobr></td>
                    <td class="cs3B0DD49A" colspan="3" style="width:128px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->numCD.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$row->refEnteteMvt.'</nobr></td>
                    <td class="cs3B0DD49A" style="width:112px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_paie.'FC</nobr></td>
                    <td class="cs803D2C52" colspan="2" style="width:58px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$row->montant_paie.'FC</nobr></td>
                </tr>
            ';   
        }

    return $output;

}















}
