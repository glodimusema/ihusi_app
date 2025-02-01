<?php

namespace App\Http\Controllers\Valeur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Valeur\{Valeur};
use App\Traits\{GlobalMethod,Slug};
use DB;


class ValeurController extends Controller
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
        $data = DB::table("valeurs")
        ->select("valeurs.id", "valeurs.nom","valeurs.titre","valeurs.photo","valeurs.description","valeurs.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('valeurs.nom', 'like', '%'.$query.'%')
            ->orWhere('valeurs.description', 'like', '%'.$query.'%')
            ->orWhere('valeurs.titre', 'like', '%'.$query.'%')
            ->orderBy("valeurs.nom", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("valeurs.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            Valeur::create([
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Valeur::create([
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
           
            Valeur::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            Valeur::where('id',$formData->id)->update([
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
        $data = DB::table("valeurs")
        ->select("valeurs.id", "valeurs.nom","valeurs.titre","valeurs.photo","valeurs.description", "valeurs.created_at")->where('valeurs.id', $id)->get();

        return response()->json(['data'    =>  $data]);
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
        $data = Valeur::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

}
