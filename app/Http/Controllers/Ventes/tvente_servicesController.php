<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_services};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// tvente_services
// nom_service
// active


class tvente_servicesController extends Controller
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
        //'id','code','nom_service','compte_fss_bl','active'

        $data = DB::table("tvente_services")
        ->select("tvente_services.id","tvente_services.nom_service","tvente_services.created_at","status",
        'tvente_services.active');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_services.nom_service', 'like', '%'.$query.'%')
            ->orderBy("tvente_services.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_services_2()
    {
         $data = DB::table("tvente_services")
         ->select("tvente_services.id", "tvente_services.nom_service","tvente_services.created_at","status",
         'tvente_services.active')
        ->get();
        
        return response()->json(['data' => $data]);

    }    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // tvente_services
// nom_service
// active

    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update  status
            $data = tvente_services::where("id", $request->id)->update([
                'nom_service' =>  $request->nom_service,
                'status' =>  $request->status
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_services::create([
                'nom_service' =>  $request->nom_service,
                'status' =>  $request->status,
                'active' =>  $request->active
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
        $data = tvente_services::where('id', $id)->get();
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
        $data = tvente_services::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
