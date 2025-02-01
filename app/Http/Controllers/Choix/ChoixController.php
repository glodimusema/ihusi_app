<?php

namespace App\Http\Controllers\Choix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Choix\{Choix};
use App\Traits\{GlobalMethod,Slug};
use DB;

class ChoixController extends Controller
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
        $data = DB::table("choixes")
        ->select("choixes.id", "choixes.titre","choixes.photo","choixes.description","choixes.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('choixes.titre', 'like', '%'.$query.'%')
            ->orWhere('choixes.description', 'like', '%'.$query.'%')
            ->orderBy("choixes.titre", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("choixes.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            Choix::create([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Choix::create([
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
           
            Choix::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            Choix::where('id',$formData->id)->update([
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
        $data = DB::table("choixes")
        ->select("choixes.id", "choixes.titre","choixes.photo","choixes.description", "choixes.created_at")->where('choixes.id', $id)->get();

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
        $data = Choix::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

    
}
