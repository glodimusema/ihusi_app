<?php

namespace App\Http\Controllers\Patients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use App\Models\Patients\{vcarte};

use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\User;
use App\Message;

class CartePdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


//===============================================================================================================================================================================================
//===============================================================================================================================================================================================
//================ CARTE POUR ABONNE ==================================================================================================================================================

public function generateQrcode($text) {

    
    $qrc = QrCode::size(100)->generate($text);
    $qrcode='<img src="data:image/svg+xml;base64,'.base64_encode($qrc).'" 
    width="104" height="89">';
    // width="84" height="69">';
    return $qrcode;
}

function pdf_carte_medicale(Request $request)
    {
//
        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoCarteSoin($id);
            $pdf = \App::make('dompdf.wrapper');
            // echo($html);

            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();
            
        }
        else{
        }       
        
    }

    function getInfoCarteSoin($id)
    {
                //Info Malade
                $code='';
                $noms='';
                $genre='';
                $datenaissance='';
                $lieunaissance='';
                $contact='';
                $contact2='';
                $profession='';
                
                
                $data = vcarte::select(['id','refUser','dateExpiration','numeroCarte','codeSecret','noms_profil',
                'adresse_profil','telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil','photo_profil'])
                ->where('id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {

                    $code=$row->numeroCarte;
                    $noms=$row->noms_profil;
                    $genre=$row->sexe_profil;
                    $datenaissance=$row->datenaissance_profil;
                    $lieunaissance='';
                    $contact=$row->telephone_profil;
                    $contact2=$row->telephone_profil;
                    $profession=$row->adresse_profil;                   
                
                }

                $qrcode = $this->generateQrcode($code);

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


                $typeconte='Content-Type';
                $formatss='text/html; charset=utf-8';

        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>card</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs1A523CEC {color:#000000;background-color:#B22222;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs508FEFDC {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .cs8A6A6DF2 {color:#696969;background-color:#FFFFFF;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-right:2px;}
                        .csE434E911 {color:#F5F5F5;background-color:#B22222;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs85987767 {color:#FFFFFF;background-color:#B22222;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:9px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:360px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:98px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:114px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:55px;"></td>
                        <td></td>
                        <td class="cs508FEFDC" style="width:9px;height:55px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:65px;height:55px;"></td>
                        <td class="cs508FEFDC" colspan="5" style="width:146px;height:55px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:146px;height:55px;">
                        <img alt="" src="'.$pic2.'" style="width:146px;height:55px;" /></div>
                        </td>
                        <td class="cs508FEFDC" colspan="2" style="width:68px;height:55px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td class="cs508FEFDC" style="width:9px;height:4px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:65px;height:4px;"></td>
                        <td class="cs508FEFDC" style="width:5px;height:4px;"></td>
                        <td class="cs508FEFDC" style="width:17px;height:4px;"></td>
                        <td class="cs508FEFDC" style="width:9px;height:4px;"></td>
                        <td class="cs508FEFDC" style="width:98px;height:4px;"></td>
                        <td class="cs508FEFDC" style="width:17px;height:4px;"></td>
                        <td class="cs508FEFDC" colspan="2" style="width:68px;height:4px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:10px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:70px;height:10px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:10px;"></td>
                        <td class="cs1A523CEC" style="width:9px;height:10px;"></td>
                        <td class="cs1A523CEC" style="width:98px;height:10px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:85px;height:10px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:18px;"></td>
                        <td class="cs1A523CEC" colspan="3" rowspan="4" style="width:70px;height:55px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:70px;height:55px;">'.$qrcode.'</div>
                        </td>
                        <td class="cs1A523CEC" style="width:17px;height:18px;"></td>
                        <td class="csE434E911" colspan="2" style="width:105px;height:18px;line-height:16px;text-align:left;vertical-align:middle;"><nobr>ID:&nbsp;HM-'.$code.'</nobr></td>
                        <td class="cs1A523CEC" colspan="3" style="width:85px;height:18px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:19px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:19px;"></td>
                        <td class="cs1A523CEC" style="width:9px;height:19px;"></td>
                        <td class="cs1A523CEC" style="width:98px;height:19px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:85px;height:19px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:9px;"></td>
                        <td class="cs508FEFDC" style="width:9px;height:9px;"></td>
                        <td class="cs508FEFDC" colspan="4" style="width:183px;height:9px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:9px;"></td>
                        <td class="cs508FEFDC" rowspan="2" style="width:9px;height:22px;"></td>
                        <td class="cs8A6A6DF2" colspan="4" rowspan="2" style="width:181px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>Vos&nbsp;informations&nbsp;m&#233;dicales&nbsp;en&nbsp;un&nbsp;clic</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:13px;"></td>
                        <td class="cs85987767" colspan="3" rowspan="2" style="width:66px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Scannez&nbsp;mon</nobr><br/><nobr>QR-Code</nobr></td>
                        <td class="cs1A523CEC" style="width:17px;height:13px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:9px;"></td>
                        <td class="cs508FEFDC" rowspan="2" style="width:9px;height:10px;"></td>
                        <td class="cs508FEFDC" colspan="4" rowspan="2" style="width:183px;height:10px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:1px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:70px;height:1px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:1px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs1A523CEC" style="width:9px;height:9px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:70px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:17px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:9px;height:9px;"></td>
                        <td class="cs1A523CEC" style="width:98px;height:9px;"></td>
                        <td class="cs1A523CEC" colspan="3" style="width:85px;height:9px;"></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td class="cs508FEFDC" colspan="2" style="width:46px;height:34px;"></td>
                        <td class="cs508FEFDC" colspan="7" style="width:187px;height:34px;"></td>
                        <td class="cs508FEFDC" style="width:55px;height:34px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:85px;"></td>
                        <td></td>
                        <td class="cs508FEFDC" colspan="2" style="width:46px;height:85px;"></td>
                        <td class="cs508FEFDC" colspan="7" style="width:187px;height:85px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:187px;height:85px;">
                            <img alt="" src="'.$pic2.'" style="width:187px;height:85px;" /></div>
                        </td>
                        <td class="cs508FEFDC" style="width:55px;height:85px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:37px;"></td>
                        <td></td>
                        <td class="cs508FEFDC" colspan="2" style="width:46px;height:37px;"></td>
                        <td class="cs508FEFDC" colspan="7" style="width:187px;height:37px;"></td>
                        <td class="cs508FEFDC" style="width:55px;height:37px;"></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>';

                return $output;

    }



    


  
    
  


    


    


}
