<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_historique_information};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tconf_historique_informationController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {


        $data = DB::table('tconf_historique_information')
        ->select("tconf_historique_information.id","user_id","user_name","type_operation",
        "detail_operation","date_entree","detail_information","user_created",
        "tables","champs","valeurs",'created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('user_name', 'like', '%'.$query.'%')
            ->orWhere('type_operation', 'like', '%'.$query.'%')
            ->orWhere('detail_operation', 'like', '%'.$query.'%')

            ->orderBy("tconf_historique_information.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        // 

    }


    function fetch_tconf_historique_information_2()
    {
        $data = DB::table('tconf_historique_information')
        ->select("tconf_historique_information.id","user_id","user_name","type_operation",
        "detail_operation","date_entree","detail_information","user_created",
        "tables","champs","valeurs",'created_at')
        ->orderBy("id", "desc")
        ->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);

    }

    function fetch_historique_information_deleted()
    {
        $data = tconf_historique_information::withTrashed()->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);

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
            // user_name,type_operation,detail_operation,date_entree,detail_information,user_created,tables,champs,valeurs 
            $data = tconf_historique_information::where("id", $request->id)->update([
                'user_id' =>  $request->user_id,
                'user_name' =>  $request->user_name,
                'type_operation' =>  $request->type_operation,
                'detail_operation' =>  $request->detail_operation,
                'date_entree' =>  $request->date_entree,
                'detail_information' =>  $request->detail_information,
                'user_created' =>  $request->user_created,
                'tables' =>  $request->tables,
                'champs' =>  $request->champs,
                'valeurs' =>  $request->valeurs
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_historique_information::create([
                'user_id' =>  $request->user_id,
                'user_name' =>  $request->user_name,
                'type_operation' =>  $request->type_operation,
                'detail_operation' =>  $request->detail_operation,
                'date_entree' =>  $request->date_entree,
                'detail_information' =>  $request->detail_information,
                'user_created' =>  $request->user_created,
                'tables' =>  $request->tables,
                'champs' =>  $request->champs,
                'valeurs' =>  $request->valeurs
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
        $data = tconf_historique_information::where('id', $id)->get();
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
        $data = tconf_historique_information::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function restore($id)
    {
        tconf_historique_information::withTrashed()->find($id)->restore();
  
        return $this->msgJson('Suppression avec succès!!!');
    } 

    public function restoreAll()
    {
        Post::onlyTrashed()->restore();
  
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }



    public function desactiver_data(Request $request)
    {
        $tables = $request->tables;
        $user_name = $request->user_name;
        $user_id = $request->user_id;
        $valeurs = $request->valeurs;  //id
        $user_created = $request->user_created;
        $date_entree = $request->date_entree;
        $detail_information=$request->detail_information;

        $statuts='OUI';

        // $data2 = DB::update(
        //     'update '.$tables.' set deleted = :statuts,author_deleted=:user_name where id = :id',
        //     ['statuts' => $statuts,'user_name' => $user_name,'id' => $valeurs]
        // );

        $data2 = DB::delete('delete from '.$tables.' where id = :id',['id' => $valeurs]);

        $data = tconf_historique_information::create([
                'user_id' =>  $user_id,
                'user_name' =>  $user_name,
                'type_operation' =>  'Suppression',
                'detail_operation' =>  'Suppresion dans la table '.$tables.' par '.$user_name.'',
                'date_entree' =>  $date_entree,
                'detail_information' => $detail_information,
                'user_created' =>  $user_created,
                'tables' =>  $tables,
                'champs' =>  'id',
                'valeurs' =>  $valeurs
        ]);
        
       return $this->msgJson('Suppression avec succès!!!');
    }



    public function activer_data(Request $request)
    {
        $tables = $request->tables;
        $user_name = $request->user_name;
        $user_id = $request->user_id;
        $valeurs = $request->valeurs;  //id
        $user_created = $request->user_created;
        $date_entree = $request->date_entree;        
        $statuts='NON';

        $data2 = DB::update(
            'update '.$tables.' set deleted = :statuts,author_deleted=:user_name where id = :id',
            ['statuts' => $statuts,'user_name' => $user_name,'id' => $valeurs]
        );

       $data = tconf_historique_information::where([['champs', $valeurs],['tables',$tables]])->delete(); 
       return $this->msgJson('Suppression avec succès!!!');
    }



    // 'user_id' =>  $request->user_id,
    // 'user_name' =>  $request->user_name,
    // 'type_operation' =>  $request->type_operation,
    // 'detail_operation' =>  $request->detail_operation,
    // 'date_entree' =>  $request->date_entree,
    // 'detail_information' =>  $request->detail_information,
    // 'user_created' =>  $request->user_created,
    // 'tables' =>  $request->tables,
    // 'champs' =>  $request->champs,
    // 'valeurs' =>  $request->valeurs

}
