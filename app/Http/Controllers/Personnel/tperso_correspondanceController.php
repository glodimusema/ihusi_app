<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_correspondance;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_correspondanceController extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    //'id','user_id','objet','messages','statut','author'
//tperso_correspondance

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
//
    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            //id,institution_id,personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author
            $query = $this->Gquery($request);
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')
            ->where([
                ['users.name', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_correspondance.id", "desc")          
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')
            ->orderBy("tperso_correspondance.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function all_jour(Request $request)
    { 

        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')
            ->where([
                ['users.name', 'like', '%'.$query.'%'],
                ['tperso_correspondance.created_at','>=',$formattedDate]
            ])                    
            ->orderBy("tperso_correspondance.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')            
            ->Where('tperso_correspondance.created_at','>=',$formattedDate)    
            ->orderBy("tperso_correspondance.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }


    public function fetch_detail_entete(Request $request,$user_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')
            ->where([
                ['users.name', 'like', '%'.$query.'%'],
                ['user_id',$user_id]
            ])                    
            ->orderBy("tperso_correspondance.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_correspondance')
            ->join('users','users.id','=','tperso_correspondance.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
            'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
            'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at')            
            ->Where('user_id',$user_id)    
            ->orderBy("tperso_correspondance.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    

    
   

    function fetch_single($id)
    {

        $data = DB::table('tperso_correspondance')
        ->join('users','users.id','=','tperso_correspondance.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->select("tperso_correspondance.id",'user_id','objet','messages','tperso_correspondance.statut',
        'tperso_correspondance.author','users.avatar','users.name','users.email','users.id_role',
        'roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active','tperso_correspondance.created_at') 
        ->where('tperso_correspondance.id', $id)
        ->get();

        return response($data, 200);
    }


    function insert_data(Request $request)
    {
        $data = tperso_correspondance::create([
            'user_id'       =>  $request->user_id,
            'objet'    =>  $request->objet,
            'messages'    =>  $request->messages,
            'statut'    =>  'Attente',
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
         $data = tperso_correspondance::where('id', $id)->update([
            'user_id'       =>  $request->user_id,
            'objet'    =>  $request->objet,
            'messages'    =>  $request->messages,
            'statut'    =>  $request->statut,
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_correspondance::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
