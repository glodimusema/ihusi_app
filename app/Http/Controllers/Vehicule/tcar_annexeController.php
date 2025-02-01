<?php

namespace App\Http\Controllers\Vehicule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicule\tcar_annexe;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Response;

class tcar_annexeController extends Controller
{


    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

   // 'id','refEnteteMvt','pdfMouvement','desicriptionPDF','author'

    public function all(Request $request)
    {        
        $data = DB::table('tcar_annexe')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_annexe.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')      
        ->select("tcar_annexe.id",'refEnteteMvt',"pdfMouvement","desicriptionPDF",
        "tcar_annexe.created_at","tcar_annexe.updated_at","tcar_annexe.author",'refVehicule',
        'refProvenance','dateMvt','numBS','numCD','numSR','nom_vehicule','marque','couleur',
        'numPlaque','nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_vehicule', 'like', '%'.$query.'%')          
            ->orderBy("nom_vehicule", "asc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tcar_annexe.created_at", "desc");
        return $this->apiData($data->paginate(10)); 

    }


    public function fetch_annexe_mouvement(Request $request,$refEnteteMvt)
    { 
        $data = DB::table('tcar_annexe')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_annexe.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')      
        ->select("tcar_annexe.id",'refEnteteMvt',"pdfMouvement","desicriptionPDF",
        "tcar_annexe.created_at","tcar_annexe.updated_at","tcar_annexe.author",'refVehicule',
        'refProvenance','dateMvt','numBS','numCD','numSR','nom_vehicule','marque','couleur',
        'numPlaque','nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->Where('refEnteteMvt',$refEnteteMvt);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_vehicule', 'like', '%'.$query.'%')          
            ->orderBy("nom_vehicule", "asc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tcar_annexe.created_at", "desc");
        return $this->apiData($data->paginate(10));

    }    

    function fetch_single_annexe_mouvement($id)
    {

        $data = DB::table('tcar_annexe')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_annexe.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')      
        ->select("tcar_annexe.id",'refEnteteMvt',"pdfMouvement","desicriptionPDF",
        "tcar_annexe.created_at","tcar_annexe.updated_at","tcar_annexe.author",'refVehicule',
        'refProvenance','dateMvt','numBS','numCD','numSR','nom_vehicule','marque','couleur',
        'numPlaque','nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->where('tcar_annexe.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

   // 'id','refEnteteMvt','pdfMouvement','desicriptionPDF','author'
function insertData(Request $request)
 {
    
     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tcar_annexe::create([
            'refEnteteMvt'=>$formData->refEnteteMvt,
            'pdfMouvement'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author          
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tcar_annexe::create([
            'refEnteteMvt'=>$formData->refEnteteMvt,
            'pdfMouvement'=>'avatar.png',
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author        
        ]);
         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

     }

 }

 function updateData(Request $request)
 {

     if (!is_null($request->image)) 
     {
         $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName);
      
        $data= tcar_annexe::where('id',$formData->id)->update([
            'refEnteteMvt'=>$formData->refEnteteMvt,
            'pdfMouvement'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author    
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tcar_annexe::where('id',$formData->id)->update([
            'refEnteteMvt'=>$formData->refEnteteMvt,
            'pdfMouvement'=>'avatar.png',
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author       
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 

     }

 }

 public function downloadfile($filenamess)
 {
     $filepath = public_path('fichier/'.$filenamess.'');
     return response()->file($filepath);
 }


    function delete_annexe($id)
    {
        $data = tcar_annexe::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "SUppression avec succès!!",
        ]);

        
    }
//

   





}
