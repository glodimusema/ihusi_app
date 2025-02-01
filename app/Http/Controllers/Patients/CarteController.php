<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patients\{tcarte};
use App\Traits\{GlobalMethod,Slug};
use DB;
class CarteController extends Controller
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
        $data = DB::table("tcarte")       
        ->select('tcarte.id','refUser','dateExpiration','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil','photo_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->selectRaw('CONCAT("D",YEAR(created_at),"",MONTH(created_at),"00",tcarte.id) as numeroCarte');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_profil', 'like', '%'.$query.'%')          
            ->orderBy("noms_profil", "asc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("tcarte.created_at", "desc");
        return $this->apiData($data->paginate(3));
    }


    public function showCarte_Compte(Request $request,$mail_profil)
    {
        $data =  DB::table("tcarte")       
        ->select('tcarte.id','refUser','dateExpiration','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil',
        'photo_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->selectRaw('CONCAT("D",YEAR(created_at),"",MONTH(created_at),"00",tcarte.id) as numeroCarte')
        ->Where('tcarte.mail_profil',$mail_profil);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_profil', 'like', '%'.$query.'%')          
            ->orderBy("noms_profil", "asc");

            return $this->apiData($data->paginate(5));
           

        }       
        $data->orderBy("tcarte.created_at", "desc");
        return $this->apiData($data->paginate(5));
    }


    function insertData(Request $request)
    {
//sexe_profil
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
            tcarte::create([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'numeroCarte'     =>  "000000",
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'mail_profil'     =>  $formData->mail_profil,
                'photo_profil'         =>  $imageName,
            ]);

            return $this->msgJson('Information ajoutée avec succès');
//mail_profil
        }
        else{

            $formData = json_decode($_POST['data']);
            tcarte::create([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'numeroCarte'     =>  "00000",
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'mail_profil'     =>  $formData->mail_profil,
                'photo_profil'         =>  "avatar.png"
            ]);
            return $this->msgJson('Information ajoutée avec succès');
//mail_profil
        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
           
            tcarte::where('id',$formData->id)->update([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'mail_profil'     =>  $formData->mail_profil,
                'photo_profil'         =>  $imageName,        

            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            tcarte::where('id',$formData->id)->update([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'mail_profil'     =>  $formData->mail_profil,
                'photo_profil'         =>  "avatar.png"
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }   




    function updateData2(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);
           
            tcarte::where('id',$formData->id)->update([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'photo_profil'         =>  $imageName,        

            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            tcarte::where('id',$formData->id)->update([
                'refUser'     =>  1,
                'dateExpiration'     =>  $formData->dateExpiration,
                'codeSecret'     =>  $formData->codeSecret,
                'noms_profil'     =>  $formData->noms_profil,
                'adresse_profil'     =>  $formData->adresse_profil,
                'telephone_profil'     =>  $formData->telephone_profil,
                'datenaissance_profil'     =>  $formData->datenaissance_profil,
                'groupesanguin'     =>  $formData->groupesanguin,
                'sexe_profil'     =>  $formData->sexe_profil,
                'photo_profil'         =>  "avatar.png"
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }   


    public function searchMaladeTeste(Request $request)
    {       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tcarte")       
            ->select('tcarte.id','refUser','dateExpiration','codeSecret','noms_profil','adresse_profil',
            'telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil',
            'photo_profil','created_at','updated_at')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
            ->selectRaw('CONCAT("D",YEAR(created_at),"",MONTH(created_at),"00",tcarte.id) as numeroCarte')
            ->where('noms_profil', 'like', '%'.$query.'%')
            ->orderBy("tcarte.id", "desc")->take(100)->get();

            return response()->json([
                'data'  => $data,
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
        $data = DB::table("tcarte")       
        ->select('tcarte.id','refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil','sexe_profil',
        'mail_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->selectRaw('CONCAT("D",YEAR(created_at),"",MONTH(created_at),"00",tcarte.id) as numeroCarte')
        ->where('tcarte.id', $id)
        ->get();

        return response()->json(['data'    =>  $data]);
    }

    public function carte_by_user($refUser)
    {
        //
        $data = DB::table("tcarte")       
        ->select('tcarte.id','refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil','photo_profil',
        'created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->selectRaw('CONCAT("D",YEAR(created_at),"",MONTH(created_at),"00",tcarte.id) as numeroCarte')
        ->where('tcarte.refUser', $refUser)
        ->get();

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
        $data = tcarte::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

    
}
