<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\{tperso_partenaire};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_partenaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
    //id,nom_org, adresse_org, contact_org, rccm_org, idnat_org, author, photo tperso_partenaire

    public function index(Request $request)
    {       

        if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);

            $data = DB::table('tperso_partenaire')  
            ->select("tperso_partenaire.id","nom_org", "adresse_org","mail_org","contact_org","mail_org","rccm_org", 
            "idnat_org","photo","tperso_partenaire.author","tperso_partenaire.created_at",
            "tperso_partenaire.updated_at")
            ->where('nom_org', 'like', '%'.$query.'%')
            ->orderBy("tperso_partenaire.nom_org", "asc")
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_partenaire')  
            ->select("tperso_partenaire.id","nom_org", "adresse_org","mail_org", "contact_org", "rccm_org", 
            "idnat_org","photo","tperso_partenaire.author","tperso_partenaire.created_at",
            "tperso_partenaire.updated_at")
            ->orderBy("tperso_partenaire.nom_org", "asc")
            ->paginate(10);

             return response($data, 200);
            }

        }
    
    function fetch_data()
    {
        $data = DB::table('tperso_partenaire')  
        ->select("tperso_partenaire.id","nom_org", "adresse_org","mail_org", "contact_org", "rccm_org", 
        "idnat_org","photo","tperso_partenaire.author","tperso_partenaire.created_at",
        "tperso_partenaire.updated_at")
        ->orderBy("nom_org", "asc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

    }




    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            //id,nom_org, adresse_org, contact_org,mail_org", rccm_org, idnat_org, author, photo tperso_partenaire

            tperso_partenaire::create([
                'nom_org'    =>  $formData->nom_org,
                'adresse_org'         =>  $formData->adresse_org,                
                'contact_org'      =>  $formData->contact_org,                
                'mail_org'  =>  $formData->mail_org, 
                'rccm_org'  =>  $formData->rccm_org, 
                'idnat_org'  =>  $formData->idnat_org,
                'photo'         =>  $imageName,
                'author'         =>  $formData->author
                       
            ]);

            return $this->msgJson('Information ajoutée avec succès');
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->nom_org.''.$formData->nom_org,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            tperso_partenaire::create([
                'nom_org'    =>  $formData->nom_org,
                'adresse_org'         =>  $formData->adresse_org,                
                'contact_org'      =>  $formData->contact_org,                
                'mail_org'  =>  $formData->mail_org,
                'rccm_org'  =>  $formData->rccm_org, 
                'idnat_org'  =>  $formData->idnat_org,
                'photo'         =>  'avatar.png',
                'author'         =>  $formData->author
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

            $stringToSlug=substr($formData->nom_org.''.$formData->nom_org,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tperso_partenaire::where('id',$formData->id)->update([
                'nom_org'    =>  $formData->nom_org,
                'adresse_org'         =>  $formData->adresse_org,                
                'contact_org'      =>  $formData->contact_org,                
                'mail_org'  =>  $formData->mail_org, 
                'rccm_org'  =>  $formData->rccm_org,
                'idnat_org'  =>  $formData->idnat_org,
                'photo'         =>  $imageName,
                'author'         =>  $formData->author            
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->nom_org.''.$formData->nom_org,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tperso_partenaire::where('id',$formData->id)->update([
                'nom_org'    =>  $formData->nom_org,
                'adresse_org'         =>  $formData->adresse_org,                
                'contact_org'      =>  $formData->contact_org,                
                'mail_org'  =>  $formData->mail_org, 
                'rccm_org'  =>  $formData->rccm_org,
                'idnat_org'  =>  $formData->idnat_org,
                'photo'         =>  'avatar.png',
                'author'         =>  $formData->author
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
        $data = DB::table('tperso_partenaire')  
        ->select("tperso_partenaire.id","nom_org","adresse_org","contact_org","mail_org","rccm_org", 
        "idnat_org","photo","tperso_partenaire.author","tperso_partenaire.created_at","tperso_partenaire.updated_at")
        ->where('tperso_partenaire.id', $id)
        ->get();        
        return response()->json(['data'  =>  $data]);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $connected)
    {
        //
        $data = tperso_partenaire::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tperso_partenaire::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


}
