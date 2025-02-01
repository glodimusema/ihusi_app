<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Team\{Team};
use App\Traits\{GlobalMethod,Slug};
use DB;

class TeamController extends Controller
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
        $data = DB::table("teams")
        ->select("teams.id", "teams.nom","teams.titre","teams.biographie","teams.photo","teams.etat",
            "teams.facebook","teams.twitter","teams.linkedin","teams.telephone","teams.email",
         "teams.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('teams.titre', 'like', '%'.$query.'%')
            ->orWhere('teams.nom', 'like', '%'.$query.'%')
            ->orWhere('teams.email', 'like', '%'.$query.'%')
            ->orWhere('teams.biographie', 'like', '%'.$query.'%')
            ->orderBy("teams.nom", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("teams.id", "desc");
        return $this->apiData($data->paginate(3));
    }

    
    function validationTeam($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Team::where('id',$id)->update([
                    'etat'         =>  0
                ]);
                return $this->msgJson('La donnée a été desactivée avec succès');

            } else {
                // activation
                Team::where('id',$id)->update([
                    'etat'         =>  1
                ]);
                return $this->msgJson('La donnée a été activée avec succès');
            }
            
        }
    }


   

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/team'), $imageName);
            Team::create([
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'titre'         =>  $formData->titre,
                'biographie'    =>  $formData->biographie,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,
                'telephone'     =>  $formData->telephone,
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Team::create([
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'titre'         =>  $formData->titre,
                'biographie'    =>  $formData->biographie,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,
                'telephone'     =>  $formData->telephone,
                'photo'         =>  "logo.png"
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

            $request->image->move(public_path('/team'), $imageName);
           
            Team::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'titre'         =>  $formData->titre,
                'biographie'    =>  $formData->biographie,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,
                'telephone'     =>  $formData->telephone,
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            Team::where('id',$formData->id)->update([
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'titre'         =>  $formData->titre,
                'biographie'    =>  $formData->biographie,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,
                'telephone'     =>  $formData->telephone
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
        $data = DB::table("teams")
        ->select("teams.id", "teams.nom","teams.titre","teams.biographie","teams.photo","teams.etat",
            "teams.facebook","teams.twitter","teams.linkedin","teams.telephone","teams.email",
         "teams.created_at")->where('teams.id', $id)->get();

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
        $data = Team::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
