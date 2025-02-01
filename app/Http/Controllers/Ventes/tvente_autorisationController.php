<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_autorisation};
use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_autorisationController extends Controller
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
        $data = DB::table('tvente_autorisation')
        ->join('tvente_module','tvente_module.id','=','tvente_autorisation.module_id')  
        ->join('roles','roles.id','=','tvente_autorisation.role_id')        
        ->select("tvente_autorisation.id",'role_id','module_id','niveau','author','refUser',
         "tvente_module.nom_module","tvente_autorisation.created_at",'tvente_module.active','roles.nom');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_autorisation.nom_module', 'like', '%'.$query.'%')
            ->orderBy("tvente_autorisation.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_autorisation_2()
    {
         $data = DB::table('tvente_autorisation')
         ->join('tvente_module','tvente_module.id','=','tvente_autorisation.module_id')  
         ->join('roles','roles.id','=','tvente_autorisation.role_id')        
         ->select("tvente_autorisation.id",'role_id','module_id','niveau','author','refUser',
        "tvente_module.nom_module",'tvente_module.active','roles.nom',"tvente_autorisation.created_at")
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
            // update  'id','role_id','module_id','niveau','author','refUser'
            $data = tvente_autorisation::where("id", $request->id)->update([
                'role_id'       =>  $request->role_id,
                'module_id'    =>  $request->module_id,
                'niveau'    =>  $request->niveau,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_autorisation::create([
                'role_id'       =>  $request->role_id,
                'module_id'    =>  $request->module_id,
                'niveau'    =>  $request->niveau,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser,
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
        $data = tvente_autorisation::where('id', $id)->get();
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
        $data = tvente_autorisation::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
