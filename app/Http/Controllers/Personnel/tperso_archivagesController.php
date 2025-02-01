<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_archivages;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_archivagesController extends Controller
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
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_archivages')
            ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
            "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
            ->where([
                ['name_archive', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_archivages.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_archivages')
            ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
            "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
            ->orderBy("tperso_archivages.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function all_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
                ->where([
                    ['name_archive', 'like', '%'.$query.'%'],
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                ])               
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")  
                ->where([
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                ]) 
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function all_service_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2') && $request->get('service_id'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $service_id = $request->get('service_id');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
                ->where([
                    ['name_archive', 'like', '%'.$query.'%'],
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.service_id','=', $service_id],
                ])               
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")  
                ->where([
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.service_id','=', $service_id],
                ]) 
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function all_categorie_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2') && $request->get('categorie_id'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $categorie_id = $request->get('categorie_id');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
                ->where([
                    ['name_archive', 'like', '%'.$query.'%'],
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.categorie_id','=', $categorie_id],
                ])               
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")  
                ->where([
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.categorie_id','=', $categorie_id],
                ]) 
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function all_categorie_service_filter(Request $request)
    { 
        if ($request->get('date1') && $request->get('date2') && $request->get('categorie_id') && $request->get('service_id'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $categorie_id = $request->get('categorie_id');
            $service_id = $request->get('service_id');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
                ->where([
                    ['name_archive', 'like', '%'.$query.'%'],
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.categorie_id','=', $categorie_id],
                    ['tperso_archivages.service_id','=', $service_id],
                ])               
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_archivages')
                ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
                ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
                ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
                ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
                "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
                "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")  
                ->where([
                    ['tperso_archivages.created_at','>=', $date1],
                    ['tperso_archivages.created_at','<=', $date2],
                    ['tperso_archivages.categorie_id','=', $categorie_id],
                    ['tperso_archivages.service_id','=', $service_id],
                ]) 
                ->orderBy("tperso_archivages.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }
        else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }

    //


    public function fetch_detail_entete(Request $request,$service_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_archivages')
            ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
            "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division") 
            ->where([
                ['name_archive', 'like', '%'.$query.'%'],
                ['service_id',$service_id]
            ])                    
            ->orderBy("tperso_archivages.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_archivages')
            ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
            ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
            ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
            ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
            "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
            "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")                  
            ->Where('service_id',$service_id)    
            ->orderBy("tperso_archivages.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data = DB::table('tperso_archivages')
        ->join('tperso_service_archivage','tperso_service_archivage.id','=','tperso_archivages.service_id')
        ->join('tperso_categorie_archivage','tperso_categorie_archivage.id','=','tperso_service_archivage.categorie_id')
        ->join('tperso_division','tperso_division.id','=','tperso_service_archivage.division_id')
        ->select("tperso_archivages.id","name_archive","description_archive","fichier_archive","service_id",
        "tperso_archivages.author","tperso_archivages.created_at","name_service","description_service","categorie_id","division_id",
        "tperso_categorie_archivage.name_categorie","description_categorie","name_division","description_division")   
        ->where('tperso_archivages.id', $id)
        ->get();

        return response($data, 200);
    }

    //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author

    function insert_data(Request $request)
    {    
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 
   
            $data= tperso_archivages::create([
               'name_archive'=>$formData->name_archive,
               'description_archive'=>$formData->description_archive,               
               'fichier_archive'=>$imageName,
               'service_id'=>$formData->service_id, 
               'author'=>$formData->author          
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tperso_archivages::create([
            'name_archive'=>$formData->name_archive,
            'description_archive'=>$formData->description_archive,               
            'fichier_archive'=>'avatar.png',
            'service_id'=>$formData->service_id, 
            'author'=>$formData->author          
           ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }
   
    }


    function update_data(Request $request, $id)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tperso_archivages::where('id',$formData->id)->update([
                'name_archive'=>$formData->name_archive,
                'description_archive'=>$formData->description_archive,               
                'fichier_archive'=>$imageName,
                'service_id'=>$formData->service_id, 
                'author'=>$formData->author      
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tperso_archivages::where('id',$formData->id)->update([
                'name_archive'=>$formData->name_archive,
                'description_archive'=>$formData->description_archive,               
                'fichier_archive'=>"avatar.png",
                'service_id'=>$formData->service_id, 
                'author'=>$formData->author          
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
   
    }


    function delete_data($id)
    {
        $data = tperso_archivages::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
