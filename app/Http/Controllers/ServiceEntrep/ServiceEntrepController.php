<?php

namespace App\Http\Controllers\ServiceEntrep;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ServiceEntrep\{ServiceEntrep};
use App\Traits\{GlobalMethod,Slug};
use DB;

class ServiceEntrepController extends Controller
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
        $data = DB::table("service_entreps")
        ->select("service_entreps.id", "service_entreps.nom","service_entreps.titre","service_entreps.photo","service_entreps.description","service_entreps.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('service_entreps.nom', 'like', '%'.$query.'%')
            ->orWhere('service_entreps.description', 'like', '%'.$query.'%')
            ->orWhere('service_entreps.titre', 'like', '%'.$query.'%')
            ->orderBy("service_entreps.nom", "asc");

            return $this->apiData($data->paginate(3));
           

        }

        $data->orderBy("service_entreps.id", "desc");
        return $this->apiData($data->paginate(3));
    }


    function fetch_All_services(Request $request)
    {
        $data = DB::table("service_entreps")
        ->select("service_entreps.id", "service_entreps.nom","service_entreps.titre","service_entreps.photo","service_entreps.description","service_entreps.created_at")->get();
        return response()->json(['data'    =>  $data]);

    }


    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            ServiceEntrep::create([
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            ServiceEntrep::create([
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
           
            ServiceEntrep::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            ServiceEntrep::where('id',$formData->id)->update([
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
        $blog = DB::table("service_entreps")
        ->select("service_entreps.id", "service_entreps.nom","service_entreps.titre","service_entreps.photo","service_entreps.description", "service_entreps.created_at")->where('service_entreps.id', $id)->get();

        
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'nom'           =>  $row->nom,
                'titre'         =>  $row->titre,
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
        $data = ServiceEntrep::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
