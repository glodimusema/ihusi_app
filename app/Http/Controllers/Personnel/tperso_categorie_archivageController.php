<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_categorie_archivage};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_categorie_archivageController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_categorie_archivage')
            ->select("tperso_categorie_archivage.id","tperso_categorie_archivage.name_categorie","description_categorie",
            "tperso_categorie_archivage.created_at","author")
            ->where('name_categorie', 'like', '%'.$query.'%')
            ->orWhere('description_categorie', 'like', '%'.$query.'%')
            ->orderBy("tperso_categorie_archivage.id", "desc")
            ->paginate(10);

           return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_categorie_archivage')
            ->select("tperso_categorie_archivage.id","tperso_categorie_archivage.name_categorie","description_categorie",
            "tperso_categorie_archivage.created_at","author")
            ->orderBy("tperso_categorie_archivage.id", "desc")->paginate(10);
            
           return response($data, 200);
        }
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_categorie_archivage')
        ->select("tperso_categorie_archivage.id","tperso_categorie_archivage.name_categorie","description_categorie",
        "tperso_categorie_archivage.created_at","author")
        ->orderBy("id", "desc")->get();
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
        
        if ($request->id !='') 
        { 
            $data = tperso_categorie_archivage::where("id", $request->id)->update([
                'name_categorie' =>  $request->name_categorie,
                'description_categorie' =>  $request->description_categorie,
                'author' =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_categorie_archivage::create([
                'name_categorie' =>$request->name_categorie,
                'description_categorie' =>  $request->description_categorie,
                'author' =>  $request->author
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
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
        $data = tperso_categorie_archivage::where('id', $id)->get();
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
        $data = tperso_categorie_archivage::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
