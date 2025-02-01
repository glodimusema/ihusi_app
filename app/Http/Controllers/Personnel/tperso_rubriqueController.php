<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_rubrique;
use DB;


class tperso_rubriqueController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
          //      

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);



            $data = DB::table('tperso_rubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select("tperso_rubrique.id","name_rubrique","name_categorie_rubrique",
            "tperso_rubrique.created_at","refCatRubrique","refSscompte",              
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
            ->where('name_categorie_rubrique', 'like', '%'.$query.'%')
            ->orWhere('name_rubrique', 'like', '%'.$query.'%')
            ->orderBy("tperso_rubrique.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{

            $data = DB::table('tperso_rubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select("tperso_rubrique.id","name_rubrique","name_categorie_rubrique",
            "tperso_rubrique.created_at","refCatRubrique","refSscompte" ,              
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
            ->orderBy("tperso_rubrique.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tperso_rubrique')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select("tperso_rubrique.id","name_rubrique","name_categorie_rubrique",
        "tperso_rubrique.created_at","refCatRubrique","refSscompte",          
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
        ->where('tperso_rubrique.id', $id)
        ->get();

        return response()->json(['data' => $data]);
    }

    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_rubrique')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=','tperso_rubrique.refCatRubrique')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select("tperso_rubrique.id","name_rubrique","name_categorie_rubrique",
        "tperso_rubrique.created_at","refCatRubrique","refSscompte",          
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte")
        ->orderBy("id", "asc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }

 
    function insert_data(Request $request)
    {
       //id,refCatRubrique,name_rubrique,refSscompte

        $data = tperso_rubrique::create([
            'refCatRubrique'       =>  $request->refCatRubrique,
            'refSscompte'       =>  $request->refSscompte,
            'name_rubrique'    =>  $request->name_rubrique                           
            
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }



    function update_data(Request $request, $id)
    {
        $data = tperso_rubrique::where('id', $id)->update([
            'refCatRubrique'       =>  $request->refCatRubrique,
            'refSscompte'       =>  $request->refSscompte,
            'name_rubrique'    =>  $request->name_rubrique
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
     $data = tperso_rubrique::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
