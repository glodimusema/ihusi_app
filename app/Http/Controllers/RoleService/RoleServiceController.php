<?php

namespace App\Http\Controllers\RoleService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RoleService\{RoleService};
use App\Traits\{GlobalMethod,Slug};
use DB;

class RoleServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        $data = DB::table("role_services")
        ->select("role_services.id", "role_services.titre","role_services.photo","role_services.description","role_services.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('role_services.titre', 'like', '%'.$query.'%')
            ->orWhere('role_services.description', 'like', '%'.$query.'%')
            ->orderBy("role_services.titre", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("role_services.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    
   

   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            RoleService::create([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            RoleService::create([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  "avatar.png"
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
           
            RoleService::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            RoleService::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description)
            ]);
            return $this->msgJson('Modifcation avec succès');

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
        $data = DB::table("role_services")
        ->select("role_services.id", "role_services.titre","role_services.photo","role_services.description", "role_services.created_at")->where('role_services.id', $id)->get();

        return response()->json(['data'    =>  $data]);
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
        $data = RoleService::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
