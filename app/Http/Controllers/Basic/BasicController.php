<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Basic\{Basic};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use App\Traits\GlobalMethod;
use DB;
use URL;
use Auth;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table('basics')
        ->select('id', 'apropos', 'travail', 'don','structure');
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('apropos', 'like', '%'.$query.'%')
            ->orWhere('travail', 'like', '%'.$query.'%')
            ->orderBy("id", "asc");

            return $this->apiData($data->paginate(4));
           

        }
        return $this->apiData($data->paginate(4));
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
            $data = Basic::where("id", $request->id)->update([
                'apropos'             =>  $request->apropos,
                'travail'             =>  $request->travail,
                'don'                 =>  $request->don,
                'structure'           =>  $request->structure
                
            ]);

            return response()->json([
                'data'  =>  "Modification information avec succès!!!"
            ]);

            // $this->msgJson("Modification information avec succès!!!");

        }
        else
        {
            // insertion 
            $data = Basic::create([
                'apropos'             =>  $request->apropos,
                'travail'             =>  $request->travail,
                'don'                 =>  $request->don,
                'structure'           =>  $request->structure
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!"
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
        $blog = Basic::where('id', $id)->get();
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'apropos'       =>  html_entity_decode($row->apropos),
                'travail'       =>  html_entity_decode($row->travail),
                'don'           =>  html_entity_decode($row->don),
                'structure'     =>  html_entity_decode($row->structure)
            ));
        }
        return response()->json(['data'  =>  $data]);
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
        $data = Basic::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
