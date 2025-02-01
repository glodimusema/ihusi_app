<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Patients\{tdata_rapportmedical};
use App\Traits\{GlobalMethod,Slug};
use DB;
class tdata_rapportmedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 

        $data = DB::table('tdata_rapportmedical')
        ->join('vcarte','vcarte.numeroCarte','=','tdata_rapportmedical.refPatient')
        ->select("tdata_rapportmedical.id",'refPatient','plainte_med','historique_med','antecedent_med',
        'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med','sexe_profil','mail_profil',
        'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author',"Hopital",
        'refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_profil', 'like', '%'.$query.'%')          
            ->orderBy("noms_profil", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tdata_rapportmedical.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_rapportmedical_cons(Request $request,$refPatient)
    { 

        $data = DB::table('tdata_rapportmedical')
        ->join('vcarte','vcarte.numeroCarte','=','tdata_rapportmedical.refPatient')
        //MALADE
        ->select("tdata_rapportmedical.id",'refPatient','plainte_med','historique_med','antecedent_med',
        'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med','sexe_profil','mail_profil',
        'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author',"Hopital",
        'refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->Where('refPatient',$refPatient);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_profil', 'like', '%'.$query.'%')          
            ->orderBy("noms_profil", "asc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tdata_rapportmedical.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_single_rapportmedical($id)
    {

        $data = DB::table('tdata_rapportmedical')
        ->join('vcarte','vcarte.numeroCarte','=','tdata_rapportmedical.refPatient')
        //MALADE
        ->select("tdata_rapportmedical.id",'refPatient','plainte_med','historique_med','antecedent_med',
        'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med','sexe_profil','mail_profil',
        'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author',"Hopital",
        'refUser','dateExpiration','numeroCarte','codeSecret','noms_profil','adresse_profil',
        'telephone_profil','datenaissance_profil','groupesanguin','photo_profil','created_at','updated_at')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_profil, CURDATE()) as age_profil')
        ->where('tdata_rapportmedical.id', $id)
        ->get();

        return response()->json(['data'    =>  $data]);
    }


    function insert_rapportmedical(Request $request)
    {       
        $data = tdata_rapportmedical::create([
            'refPatient'       =>  $request->refPatient,
            'plainte_med'    =>  $request->plainte_med,
            'historique_med'    =>  $request->historique_med,
            'antecedent_med'    =>  $request->antecedent_med,
            'examenphysique_med'    =>  $request->examenphysique_med,
            'diagnostic_med'    =>  $request->diagnostic_med,
            'examenparaclinique_med'    =>  $request->examenparaclinique_med,
            'traitement_med'    =>  $request->traitement_med,
            'evolution_med'    =>  $request->evolution_med,
            'libelle_med'    =>  $request->libelle_med,
            'date_med'    =>  $request->date_med,
            'medecin_med'    =>  $request->medecin_med,
            'specialite_med'    => $request->specialite_med,
            'cnom_med'    =>  $request->cnom_med,                                       
            'author'       =>  $request->author,
            'Hopital'       =>  $request->Hopital
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_rapportmedical(Request $request, $id)
    {
        $data = tdata_rapportmedical::where('id', $id)->update([
            'refPatient'       =>  $request->refPatient,
            'plainte_med'    =>  $request->plainte_med,
            'historique_med'    =>  $request->historique_med,
            'antecedent_med'    =>  $request->antecedent_med,
            'examenphysique_med'    =>  $request->examenphysique_med,
            'diagnostic_med'    =>  $request->diagnostic_med,
            'examenparaclinique_med'    =>  $request->examenparaclinique_med,
            'traitement_med'    =>  $request->traitement_med,
            'evolution_med'    =>  $request->evolution_med,
            'libelle_med'    =>  $request->libelle_med,
            'date_med'    =>  $request->date_med,
            'medecin_med'    =>  $request->medecin_med,
            'specialite_med'    => $request->specialite_med,
            'cnom_med'    =>  $request->cnom_med,                                         
            'author'       =>  $request->author,
            'Hopital'       =>  $request->Hopital
        ]);
        return $this->msgJson('Modification  avec succès!!!');        
    }

    function delete_rapportmedical($id)
    {
        $data = tdata_rapportmedical::where('id',$id)->delete();
        return $this->msgJson('suppression avec succès');
    }

    
}
