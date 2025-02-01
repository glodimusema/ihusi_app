<?php

namespace App\Http\Controllers\SouServiceEntrep;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SouServiceEntrep\{SouServiceEntrep};
use App\Traits\{GlobalMethod,Slug};
use DB;

class SouServiceEntrepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        $data = DB::table("sou_service_entreps")
        ->join('service_entreps','service_entreps.id','=','sou_service_entreps.id_service')
        ->select("sou_service_entreps.id", "sou_service_entreps.nom","sou_service_entreps.titre","sou_service_entreps.photo","sou_service_entreps.description",
            "sou_service_entreps.id_service","sou_service_entreps.prix","service_entreps.nom as service",
        "sou_service_entreps.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('sou_service_entreps.nom', 'like', '%'.$query.'%')
            ->orWhere('sou_service_entreps.description', 'like', '%'.$query.'%')
            ->orWhere('sou_service_entreps.titre', 'like', '%'.$query.'%')
            ->orWhere('sou_service_entreps.prix', 'like', '%'.$query.'%')
            ->orderBy("sou_service_entreps.nom", "asc");

            return $this->apiData($data->paginate(3));
           

        }

        $data->orderBy("sou_service_entreps.id", "desc");
        return $this->apiData($data->paginate(3));
    }


    function fetch_All_Sous_Services(Request $request)
    {
         $data = DB::table("sou_service_entreps")
        ->join('service_entreps','service_entreps.id','=','sou_service_entreps.id_service')
        ->select("sou_service_entreps.id", "sou_service_entreps.nom","sou_service_entreps.titre","sou_service_entreps.photo","sou_service_entreps.description",
            "sou_service_entreps.id_service","sou_service_entreps.prix","service_entreps.nom as service",
        "sou_service_entreps.created_at")->get();
        return response()->json(['data'    =>  $data]);

    }


    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            SouServiceEntrep::create([
                'id_service'    =>  $formData->id_service,
                'prix'          =>  $formData->prix,
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            SouServiceEntrep::create([
                'id_service'    =>  $formData->id_service,
                'prix'          =>  $formData->prix,
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  "avatar.png"
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
           
            SouServiceEntrep::where('id',$formData->id)->update([
                'id_service'    =>  $formData->id_service,
                'prix'          =>  $formData->prix,
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            SouServiceEntrep::where('id',$formData->id)->update([
                'id_service'    =>  $formData->id_service,
                'prix'          =>  $formData->prix,
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description)
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blog = DB::table("sou_service_entreps")
        ->join('service_entreps','service_entreps.id','=','sou_service_entreps.id_service')
        ->select("sou_service_entreps.id", "sou_service_entreps.nom","sou_service_entreps.titre","sou_service_entreps.photo","sou_service_entreps.description", 
            "sou_service_entreps.id_service","sou_service_entreps.prix","service_entreps.nom as service",
            "sou_service_entreps.created_at")->where('sou_service_entreps.id', $id)->get();

        
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'nom'           =>  $row->nom,
                'titre'         =>  $row->titre,
                'id_service'    =>  $row->id_service,
                'prix'          =>  $row->prix,
                'description'   =>  html_entity_decode($row->description),
                'photo'         =>  $row->photo
            ));
        }
        return response()->json(['data'  =>  $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = SouServiceEntrep::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
