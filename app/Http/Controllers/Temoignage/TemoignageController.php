<?php

namespace App\Http\Controllers\Temoignage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Team\{Team, Temoignage};
use App\Traits\{GlobalMethod,Slug};
use DB;

class TemoignageController extends Controller
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
        $data = DB::table("temoignages")
        ->select("temoignages.id", "temoignages.nom","temoignages.fonction","temoignages.photo","temoignages.message","temoignages.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('temoignages.nom', 'like', '%'.$query.'%')
            ->orWhere('temoignages.message', 'like', '%'.$query.'%')
            ->orWhere('temoignages.fonction', 'like', '%'.$query.'%')
            ->orderBy("temoignages.nom", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("temoignages.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/team'), $imageName);
            Temoignage::create([
                'nom'           =>  $formData->nom,
                'fonction'      =>  $formData->fonction,
                'message'       =>  $formData->message,
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Temoignage::create([
                'nom'           =>  $formData->nom,
                'fonction'      =>  $formData->fonction,
                'message'       =>  $formData->message,
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

            $request->image->move(public_path('/team'), $imageName);
           
            Temoignage::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'fonction'      =>  $formData->fonction,
                'message'       =>  $formData->message,
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            Temoignage::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'fonction'      =>  $formData->fonction,
                'message'       =>  $formData->message
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
        $data = DB::table("temoignages")
        ->select("temoignages.id", "temoignages.nom","temoignages.fonction","temoignages.photo","temoignages.message", "temoignages.created_at")->where('temoignages.id', $id)->get();

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
        $data = Temoignage::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
