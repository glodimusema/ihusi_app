<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Territoire};
use App\Traits\{GlobalMethod,Slug};
use DB;


class TerritoireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        $data = DB::table("territoires")
        ->select("territoires.id", "territoires.nomTerritoire", "territoires.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('territoires.nomTerritoire', 'like', '%'.$query.'%')
            ->orWhere('territoires.id', 'like', '%'.$query.'%')
            ->orderBy("territoires.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("territoires.id", "desc");
        return $this->apiData($data->paginate(4));
    }


    function fetch_territoire_2()
    {
         $data = DB::table("territoires")
        ->select("territoires.id", "territoires.nomTerritoire", "territoires.created_at")
        ->get();
        
        return response()->json(['data' => $data]);

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
            $data = Territoire::where("id", $request->id)->update([
                'nomTerritoire' =>  $request->nomTerritoire
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Territoire::create([

                'nomTerritoire' =>  $request->nomTerritoire
            ]);

            return $this->msgJson('Insertion avec succès!!!');
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
        $data = Territoire::where('id', $id)->get();
        return response()->json(['data' => $data]);
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
        $data = Territoire::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
