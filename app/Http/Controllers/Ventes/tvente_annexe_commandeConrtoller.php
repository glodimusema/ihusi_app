<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_annexe_commande;  
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_annexe_commandeConrtoller extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.

            $query = $this->Gquery($request);
            $data = DB::table('tvente_annexe_commande')
            ->select("tvente_annexe_commande.id",'noms_annexe','refCommande','annexe','author')
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tvente_annexe_commande.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tvente_annexe_commande')
            ->select("tvente_annexe_commande.id",'noms_annexe','refCommande','annexe','author')           
            ->orderBy("tvente_annexe_commande.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_annexe_commande(Request $request,$refCommande)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tvente_annexe_commande')
            ->select("tvente_annexe_commande.id",'noms_annexe','refCommande','annexe','author')               
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%'],
                ['refCommande',$refCommande]
            ])                    
            ->orderBy("tvente_annexe_commande.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tvente_annexe_commande')
            ->select("tvente_annexe_commande.id",'noms_annexe','refCommande','annexe','author')                
            ->Where('refCommande',$refCommande)    
            ->orderBy("tvente_annexe_commande.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    



    function fetch_single($id)
    {

        $data = DB::table('tvente_annexe_commande')
        ->select("tvente_annexe_commande.id",'noms_annexe','refCommande','annexe','author')   
        ->where('tvente_annexe_commande.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }



    function insert_data(Request $request)
    {
        //id,noms_annexe,refCommande,sexe,date_naissance,etat_civile,degre_parente,annexe,author
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 

  
            $data= tvente_annexe_commande::create([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refCommande'       =>  $formData->refCommande,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author        
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tvente_annexe_commande::create([
            'noms_annexe'       =>  $formData->noms_annexe,
            'refCommande'       =>  $formData->refCommande,
            'annexe'    =>  'avatar.png',
            'author'  =>  $formData->author        
           ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }

    }


    function update_data(Request $request, $id)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tvente_annexe_commande::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refCommande'       =>  $formData->refCommande,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author      
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tvente_annexe_commande::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'refCommande'       =>  $formData->refCommande,
                'author'  =>  $formData->author
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
       }


    function delete_data($id)
    {
        $data = tvente_annexe_commande::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
