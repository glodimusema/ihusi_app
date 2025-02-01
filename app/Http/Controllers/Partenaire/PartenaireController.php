<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partenaire\{Partenaire};
use App\Traits\GlobalMethod;
use DB;

class PartenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        //
          $data = DB::table("partenaires")
        ->select("partenaires.id", "partenaires.nom","partenaires.url","partenaires.photo", "partenaires.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('partenaires.nom', 'like', '%'.$query.'%')
            ->orWhere('partenaires.url', 'like', '%'.$query.'%')
            ->orderBy("partenaires.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        return $this->apiData($data->paginate(4));
        
    }

    

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/partenaire'), $imageName);
            Partenaire::create([
                'nom'           =>  $formData->nom,
                'url'           =>  $formData->url,
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Partenaire::create([
                'nom'           =>  $formData->nom,
                'url'           =>  $formData->url,
                'photo'         =>  "vuetify.png"
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

            $request->image->move(public_path('/partenaire'), $imageName);
           
            Partenaire::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'url'           =>  htmlspecialchars($formData->url),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);

            Partenaire::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'url'           =>  htmlspecialchars($formData->url)
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = Partenaire::where('id', $id)->get();
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
        $data = Partenaire::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
