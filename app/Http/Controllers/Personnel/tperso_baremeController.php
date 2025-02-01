<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_bareme};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_baremeController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        // 'id','taux_bareme','usd_bareme','tranche1_bareme','tranche2_bareme'
        // tperso_bareme

        $data = DB::table('tperso_bareme')
        ->select("tperso_bareme.id",'taux_bareme','usd_bareme','tranche1_bareme','tranche2_bareme',
        "tperso_bareme.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tperso_bareme.taux_bareme', 'like', '%'.$query.'%')
            ->orderBy("tperso_bareme.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dopdown_2()
    {
        $data = DB::table('tperso_bareme')
        ->select("tperso_bareme.id",'taux_bareme','usd_bareme','tranche1_bareme','tranche2_bareme',
        "tperso_bareme.created_at")
        ->orderBy("taux_bareme", "asc")->get();
        return response()->json([
            'data'  => $data
        ]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    public function store(Request $query)
    {
        
        if ($query->id !='') 
        {
            //'id','taux_bareme','usd_bareme','tranche1_bareme','tranche2_bareme'
            $data = tperso_bareme::where("id", $query->id)->update([
                'taux_bareme' =>  $query->taux_bareme,
                'usd_bareme' =>  $query->usd_bareme,
                'tranche1_bareme' =>  $query->tranche1_bareme,
                'tranche2_bareme' =>  $query->tranche2_bareme
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_bareme::create([
                'taux_bareme' =>  $query->taux_bareme,
                'usd_bareme' =>  $query->usd_bareme,
                'tranche1_bareme' =>  $query->tranche1_bareme,
                'tranche2_bareme' =>  $query->tranche2_bareme
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
        $data = tperso_bareme::where('id', $id)->get();
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
        $data = tperso_bareme::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
