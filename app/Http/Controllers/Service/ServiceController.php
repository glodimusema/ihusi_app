<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service\{Service};
use App\Traits\GlobalMethod;
use DB;

class ServiceController extends Controller
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
         $data = DB::table("services")
        ->select("services.id", "services.titre","services.description","services.icone", "services.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('services.titre', 'like', '%'.$query.'%')
            ->orWhere('services.description', 'like', '%'.$query.'%')
            ->orderBy("services.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        return $this->apiData($data->paginate(4));
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
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = Service::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'icone'         =>  $request->icone
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = Service::create([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'icone'         =>  $request->icone
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

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
        $data = Service::where('id', $id)->get();
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
        $data = Service::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
