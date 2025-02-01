<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tcategoriemedecin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tcategoriemedecinController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {

        $data = DB::table('tcategoriemedecin')
        ->select("tcategoriemedecin.id","tcategoriemedecin.designation","tcategoriemedecin.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tcategoriemedecin.designation', 'like', '%'.$query.'%')
            ->orderBy("tcategoriemedecin.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));

    }


    function fetch_tcategoriemedecin_2()
    {
        $data = DB::table('tcategoriemedecin')
        ->select("tcategoriemedecin.id","tcategoriemedecin.designation","tcategoriemedecin.created_at")
        ->orderBy("designation", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
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
        //
        if ($query->id !='') 
        {
            # code...
            // update 
            $data = tcategoriemedecin::where("id", $query->id)->update([
                'designation' =>  $query->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcategoriemedecin::create([

                'designation' =>  $query->designation
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
        $data = tcategoriemedecin::where('id', $id)->get();
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
        $data = tcategoriemedecin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
