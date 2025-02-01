<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patients\{trdv_malade};
use App\Traits\{GlobalMethod,Slug};
use DB;
class RvdMaladeController extends Controller
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
        $data = DB::table("trdv_malade")
        ->join('vcarte','vcarte.numeroCarte','=','trdv_malade.numeroCarte')
        ->select('trdv_malade.id','trdv_malade.numeroCarte','trdv_malade.refUser','dateRDV','noms',
        'contact','lieu','motif','statut','trdv_malade.author','sexe_profil','mail_profil',
        'dateExpiration','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_profil', 'like', '%'.$query.'%')
            ->orWhere('trdv_malade.numeroCarte', 'like', '%'.$query.'%')
            ->orderBy("trdv_malade.dateRDV", "desc");

            return $this->apiData($data->paginate(3));
           

        }
        $data->orderBy("trdv_malade.dateRDV", "desc");
        return $this->apiData($data->paginate(3));
    }

    public function showRDV_Carte(Request $request,$numeroCarte)
    {
        $data =  DB::table("trdv_malade")
        ->join('vcarte','vcarte.numeroCarte','=','trdv_malade.numeroCarte')
        ->select('trdv_malade.id','trdv_malade.numeroCarte','trdv_malade.refUser','dateRDV','noms',
        'contact','lieu','motif','statut','trdv_malade.author',
        'dateExpiration','codeSecret','noms_profil','adresse_profil','sexe_profil','mail_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->Where('trdv_malade.numeroCarte',$numeroCarte);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_profil', 'like', '%'.$query.'%')          
            ->orderBy("noms_profil", "asc");

            return $this->apiData($data->paginate(5));
           

        }       
        $data->orderBy("trdv_malade.created_at", "desc");
        return $this->apiData($data->paginate(5));
    }

   

   //id','numeroCarte','refUser','dateRDV','noms','contact','lieu','motif','statut','author'

    function insertData(Request $request)
    {

        $data = trdv_malade::create([
            'numeroCarte'      =>  $request->numeroCarte,
            'refUser'     =>  1,
            'dateRDV' =>  $request->dateRDV,
            'noms'   =>  $request->noms,
            'contact'   =>  $request->contact,
            'lieu'   =>  $request->lieu,
            'motif'   =>  $request->motif,
            'statut'   =>  $request->statut,
            'author'   =>  $request->author
        ]);

        return $this->msgJson('Information ajoutée avec succès');

    }

    function updateData(Request $request)
    {

        $data = trdv_malade::where("id", $request->id)->update([
            'numeroCarte'      =>  $request->numeroCarte,
            'refUser'     =>  1,
            'dateRDV' =>  $request->dateRDV,
            'noms'   =>  $request->noms,
            'contact'   =>  $request->contact,
            'lieu'   =>  $request->lieu,
            'motif'   =>  $request->motif,
            'statut'   =>  $request->statut,
            'author'   =>  $request->author
        ]);
        return response()->json(['data'  =>  "Modification avec succès!!!"]);

    }
    //id,numeroCarte,dateRDV
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data =  DB::table("trdv_malade")
        ->join('vcarte','vcarte.numeroCarte','=','trdv_malade.numeroCarte')
        ->select('trdv_malade.id','trdv_malade.numeroCarte','trdv_malade.refUser',
        'dateRDV','noms','contact','lieu','motif','statut','trdv_malade.author',
        'dateExpiration','codeSecret','noms_profil','adresse_profil','sexe_profil','mail_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil')
        ->where('trdv_malade.id', $id)
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
        $data = trdv_malade::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

    
}
