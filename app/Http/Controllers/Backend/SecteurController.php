<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Secteur};
use App\Traits\{GlobalMethod,Slug};
use DB;

class SecteurController extends Controller
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
        //
        $data = DB::table("secteurs")
        ->select("secteurs.id", "secteurs.nomSecteur", "secteurs.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('secteurs.nomSecteur', 'like', '%'.$query.'%')
            ->orWhere('secteurs.id', 'like', '%'.$query.'%')
            ->orderBy("secteurs.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("secteurs.id", "desc");
        return $this->apiData($data->paginate(4));
    }


    function fetch_secteur_2()
    {
         $data = DB::table("secteurs")
        ->select("secteurs.id", "secteurs.nomSecteur", "secteurs.created_at")
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
            $data = Secteur::where("id", $request->id)->update([
                'nomSecteur' =>  $request->nomSecteur
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Secteur::create([

                'nomSecteur' =>  $request->nomSecteur
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
        $data = Secteur::where('id', $id)->get();
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
        $data = Secteur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
