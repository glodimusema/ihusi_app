<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ventes\{tvente_tables};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// tvente_tables
// nom_table
// code_table
// active

class tvente_tablesController extends Controller
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
        //id,nom_table,author

        $data = DB::table("tvente_tables")
        ->select("tvente_tables.id", "tvente_tables.nom_table","code_table","active", "tvente_tables.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_tables.nom_table', 'like', '%'.$query.'%')
            ->orderBy("tvente_tables.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_tables_2()
    {
         $data = DB::table("tvente_tables")
         ->select("tvente_tables.id", "tvente_tables.nom_table","code_table","active", "tvente_tables.created_at")
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
            $data = tvente_tables::where("id", $request->id)->update([
                'nom_table' =>  $request->nom_table,
                'code_table' =>  $request->code_table,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_tables::create([
                'nom_table' =>  $request->nom_table,
                'code_table' =>  $request->code_table,
                'active' =>  $request->active
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
        $data = tvente_tables::where('id', $id)->get();
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
        $data = tvente_tables::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
