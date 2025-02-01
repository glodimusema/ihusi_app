<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tfonctionmedecin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tfonctionmedecinController extends Controller
{
    use GlobalMethod;
    use Slug;

    function Gquery($query)
    {
      return str_replace(" ", "%", $query->get('query'));
      // return $query->get('query');
    }

    public function index(Request $query)
    {


        $data = DB::table('tfonctionmedecin')
        ->select("tfonctionmedecin.id","tfonctionmedecin.designation","tfonctionmedecin.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tfonctionmedecin.designation', 'like', '%'.$query.'%')
            ->orderBy("tfonctionmedecin.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));

    }


    function fetch_tfonctionmedecin_2()
    {
        $data = DB::table('tfonctionmedecin')
        ->select("tfonctionmedecin.id","tfonctionmedecin.designation","tfonctionmedecin.created_at")
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
            $data = tfonctionmedecin::where("id", $query->id)->update([
                'designation' =>  $query->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfonctionmedecin::create([
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
        $data = tfonctionmedecin::where('id', $id)->get();
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
        $data = tfonctionmedecin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
