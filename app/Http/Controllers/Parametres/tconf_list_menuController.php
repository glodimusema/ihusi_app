<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_list_menu};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tconf_list_menuController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //'id','name_menu','numero_menu'
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tconf_list_menu')
            ->select("tconf_list_menu.id","tconf_list_menu.name_menu","numero_menu","tconf_list_menu.created_at")
            ->where('name_menu', 'like', '%'.$query.'%')            
            ->orderBy("numero_menu", "asc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tconf_list_menu')
            ->select("tconf_list_menu.id","tconf_list_menu.name_menu","numero_menu","tconf_list_menu.created_at")
            ->orderBy("numero_menu", "asc")->paginate(10);
            
            return response($data, 200);
        }
    }


    function fetch_tconf_list_menu_2()
    {
        $data = DB::table('tconf_list_menu')
        ->select("tconf_list_menu.id","tconf_list_menu.name_menu","numero_menu","tconf_list_menu.created_at")
        ->orderBy("numero_menu", "asc")->get();
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
            // update 
            $data = tconf_list_menu::where("id", $request->id)->update([
                'name_menu' =>  $request->name_menu,
                'numero_menu' =>  $request->numero_menu
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_list_menu::create([
                'name_menu' =>  $request->name_menu,
                'numero_menu' =>  $request->numero_menu
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
        $data = tconf_list_menu::where('id', $id)->get();
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
        $data = tgcategorieexament::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
