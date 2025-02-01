<?php

namespace App\Http\Controllers\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Video\{Video};
use App\Traits\GlobalMethod;
use DB;

class VideoController extends Controller
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
        $data = DB::table("videos")
        ->select("videos.id", "videos.titre","videos.url","videos.description", "videos.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('videos.titre', 'like', '%'.$query.'%')
            ->orWhere('videos.description', 'like', '%'.$query.'%')
            ->orderBy("videos.id", "desc");

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
            $data = Video::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = Video::create([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

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
        $data = Video::where('id', $id)->get();
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
        $data = Video::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
