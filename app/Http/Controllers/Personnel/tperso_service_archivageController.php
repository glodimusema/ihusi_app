<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_service_archivage;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_service_archivageController extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            //id,name_service,description_service,categorie_id,division_id,author
            $query = $this->Gquery($request);
            $data = DB::table('tperso_service_archivage')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
            "tperso_service_archivage.author")   
            ->where([
                ['name_service', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_service_archivage.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_service_archivage')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
            "tperso_service_archivage.author")    
            ->orderBy("tperso_service_archivage.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$division_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_service_archivage')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
            "tperso_service_archivage.author") 
            ->where([
                ['name_service', 'like', '%'.$query.'%'],
                ['division_id',$division_id]
            ])                    
            ->orderBy("tperso_service_archivage.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_service_archivage')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
            "tperso_service_archivage.author")               
            ->Where('division_id',$division_id)    
            ->orderBy("tperso_service_archivage.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }   
    
    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_service_archivage')
        ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
        ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
        ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
        "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
        "tperso_service_archivage.author")
        ->orderBy("id", "desc")->get();
        return response()->json([
            'data'  => $data,
        ]);

    }



    function fetch_single($id)
    {
        $data = DB::table('tperso_service_archivage')
        ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
        ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
        ->select("tperso_service_archivage.id","name_service","description_service","categorie_id","division_id",
        "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division",
        "tperso_service_archivage.author")  
        ->where('tperso_service_archivage.id', $id)
        ->get();

        return response($data, 200);
    }





////id,name_service,description_service,categorie_id,division_id,author
    function insert_data(Request $request)
    {
        $data = tperso_service_archivage::create([
            'name_service'       =>  $request->name_service,
            'description_service'    =>  $request->description_service,
            'categorie_id'    =>  $request->categorie_id,
            'division_id'    =>  $request->division_id,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_service_archivage::where('id', $id)->update([
            'name_service'       =>  $request->name_service,
            'description_service'    =>  $request->description_service,
            'categorie_id'    =>  $request->categorie_id,
            'division_id'    =>  $request->division_id,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_service_archivage::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
