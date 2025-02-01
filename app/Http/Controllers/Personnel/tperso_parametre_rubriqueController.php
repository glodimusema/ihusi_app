<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_parametre_rubrique;
use DB;


class tperso_parametre_rubriqueController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
                

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tperso_parametre_rubrique')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->select("tperso_parametre_rubrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","author",
            "tperso_parametre_rubrique.created_at","refCategorieAgent","refCatRubrique","refRubrique")
            ->where('name_rubrique', 'like', '%'.$query.'%')
            ->orWhere('name_categorie_agent', 'like', '%'.$query.'%')
            ->orderBy("tperso_parametre_rubrique.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{

            $data = DB::table('tperso_parametre_rubrique')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->select("tperso_parametre_rubrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","author",
            "tperso_parametre_rubrique.created_at","refCategorieAgent","refCatRubrique","refRubrique")
            ->orderBy("tperso_parametre_rubrique.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tperso_parametre_rubrique')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->select("tperso_parametre_rubrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","author",
            "tperso_parametre_rubrique.created_at","refCategorieAgent","refCatRubrique","refRubrique")
        ->where('tperso_parametre_rubrique.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


    function fetch_parametre_categorie_agent($refCategorieAgent)
    {
        $data = DB::table('tperso_parametre_rubrique')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
        ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
        ->select("tperso_parametre_rubrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
        "montant","author","tperso_parametre_rubrique.created_at","refCategorieAgent","refCatRubrique","refRubrique")        
        ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')
        ->where('tperso_parametre_rubrique.refCategorieAgent', $refCategorieAgent)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

 //id,refCategorieAgent,refRubrique,montant,author
    function insert_data(Request $request)
    {

        $data = tperso_parametre_rubrique::create([
            'refCategorieAgent'       =>  $request->refCategorieAgent,
            'refRubrique'    =>  $request->refRubrique,                             
            'montant'    =>  $request->montant,                            
            'author'    =>  $request->author,                          
            
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_parametre_rubrique::where('id', $id)->update([
            'refCategorieAgent'       =>  $request->refCategorieAgent,
            'refRubrique'    =>  $request->refRubrique,                             
            'montant'    =>  $request->montant,                            
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
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
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
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
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tperso_parametre_rubrique::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
