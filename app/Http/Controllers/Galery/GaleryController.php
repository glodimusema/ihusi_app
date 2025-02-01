<?php

namespace App\Http\Controllers\Galery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galery\{Galery};
use App\Traits\GlobalMethod;
use DB;

class GaleryController extends Controller
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
          $data = DB::table("galeries")
        ->select("galeries.id", "galeries.photo","galeries.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('galeries.photo', 'like', '%'.$query.'%')
            ->orderBy("galeries.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("galeries.id", "desc");
        return $this->apiData($data->paginate(4));
    }

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/galery'), $imageName);
            Galery::create([
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{
            return $this->msgJson('Désolé!!!');
        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/galery'), $imageName);
           
            Galery::where('id',$formData->id)->update([
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

             return $this->msgJson('Désolé!!!');

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
        $data = Galery::where('id', $id)->get();
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
        $data = Galery::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
