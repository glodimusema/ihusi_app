<?php

namespace App\Http\Controllers\Logistique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Logistique\{tlog_service};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tlog_serviceController extends Controller
{
    use GlobalMethod, Slug;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //id,designation,author

        $data = DB::table("tlog_service")
        ->select("tlog_service.id", "tlog_service.designation", 
        "tlog_service.created_at", "tlog_service.author");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tlog_service.designation', 'like', '%'.$query.'%')
            ->orderBy("tlog_service.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tlog_service_2()
    {
         $data = DB::table("tlog_service")
        ->select("tlog_service.id", "tlog_service.designation", 
        "tlog_service.created_at", "tlog_service.author")
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
            $data = tlog_service::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tlog_service::create([

                'designation' =>  $request->designation,
                'author' =>  $request->author
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
        $data = tlog_service::where('id', $id)->get();
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
        $data = tlog_service::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
