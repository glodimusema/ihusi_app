<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel\{tagent};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tagentController extends Controller
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


    public function index(Request $request)
    {       

        if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);

            $data = DB::table('tagent')            
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent","nummaison_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
            'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at","cartes","envie")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where('noms_agent', 'like', '%'.$query.'%')               
            ->orWhere('Categorie_agent', 'like', '%'.$query.'%')
            ->orWhere('nomAvenue', 'like', '%'.$query.'%')
            ->orWhere('nomQuartier', 'like', '%'.$query.'%')
            ->orWhere('nomCommune', 'like', '%'.$query.'%')
            ->orWhere('nomProvince', 'like', '%'.$query.'%')
            ->orderBy("tagent.noms_agent", "asc")
            ->paginate(80);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tagent')            
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent","nummaison_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
            'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at","cartes","envie")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->orderBy("tagent.noms_agent", "asc")
            ->paginate(80);

             return response($data, 200);
            }

        }
    
    public function Profiletagent($id, Request $request)
    {
        //
        $data = DB::table('tagent')            
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent","nummaison_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->where([
            ['tagent.id', $id]
        ])->get();

        return response()->json(['data'  =>  $data]);
        
    }


    function fetch_list_agent()
    {
        $data = DB::table('tagent')            
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent","nummaison_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->orderBy("noms_agent", "asc")
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

            $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            //nummaison_agent
            tagent::create([
                'matricule_agent'  =>  $formData->matricule_agent,
                'noms_agent'    =>  $formData->noms_agent,
                'sexe_agent'         =>  $formData->sexe_agent,                
                'datenaissance_agent'      =>  $formData->datenaissance_agent,                
                'lieunaissnce_agent'  =>  $formData->lieunaissnce_agent, 
                'provinceOrigine_agent'  =>  $formData->provinceOrigine_agent,
                'etatcivil_agent'  =>  $formData->etatcivil_agent,
                'refAvenue_agent'  =>  $formData->refAvenue_agent,
                'nummaison_agent'  =>  $formData->nummaison_agent,
                'contact_agent'  =>  $formData->contact_agent,
                'mail_agent'  =>  $formData->mail_agent,
                'grade_agent'  =>  $formData->grade_agent,
                'fonction_agent'  =>  $formData->fonction_agent,
                'specialite_agent'  =>  $formData->specialite_agent, 
                'Categorie_agent'  =>  $formData->Categorie_agent, 
                'niveauEtude_agent'  =>  $formData->niveauEtude_agent, 
                'anneeFinEtude_agent'  =>  $formData->anneeFinEtude_agent, 
                'Ecole_agent'  =>  $formData->Ecole_agent,
                'conjoint_agent'  =>  $formData->conjoint_agent,
                'nomPere_agent'  =>  $formData->nomPere_agent,
                'nomMere_agent'  =>  $formData->nomMere_agent,
                'Nationalite_agent'  =>  $formData->Nationalite_agent,
                'Collectivite_agent'  =>  $formData->Collectivite_agent,
                'Territoire_agent'  =>  $formData->Territoire_agent,
                'EmployeurAnt_agent'  =>  $formData->EmployeurAnt_agent,
                'PersRef_agent'  =>  $formData->PersRef_agent, 
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author
                       
            ]);
            //envie
//,'conjoint_agent','nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
//'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent'
            return $this->msgJson('Information ajoutée avec succès');
//sexe_malade,dateNaissance_malade,etatcivil_malade,numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,contactPersRef_malade,organisation_malade,numeroCarte_malade,dateExpiration_malade
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            tagent::create([
                'matricule_agent'  =>  $formData->matricule_agent,
                'noms_agent'    =>  $formData->noms_agent,
                'sexe_agent'         =>  $formData->sexe_agent,                
                'datenaissance_agent'      =>  $formData->datenaissance_agent,                
                'lieunaissnce_agent'  =>  $formData->lieunaissnce_agent, 
                'provinceOrigine_agent'  =>  $formData->provinceOrigine_agent,
                'etatcivil_agent'  =>  $formData->etatcivil_agent,
                'refAvenue_agent'  =>  $formData->refAvenue_agent,
                'nummaison_agent'  =>  $formData->nummaison_agent,
                'contact_agent'  =>  $formData->contact_agent,
                'mail_agent'  =>  $formData->mail_agent,
                'grade_agent'  =>  $formData->grade_agent,
                'fonction_agent'  =>  $formData->fonction_agent,
                'specialite_agent'  =>  $formData->specialite_agent, 
                'Categorie_agent'  =>  $formData->Categorie_agent, 
                'niveauEtude_agent'  =>  $formData->niveauEtude_agent, 
                'anneeFinEtude_agent'  =>  $formData->anneeFinEtude_agent, 
                'Ecole_agent'  =>  $formData->Ecole_agent,   
                'conjoint_agent'  =>  $formData->conjoint_agent,
                'nomPere_agent'  =>  $formData->nomPere_agent,
                'nomMere_agent'  =>  $formData->nomMere_agent,
                'Nationalite_agent'  =>  $formData->Nationalite_agent,
                'Collectivite_agent'  =>  $formData->Collectivite_agent,
                'Territoire_agent'  =>  $formData->Territoire_agent,
                'EmployeurAnt_agent'  =>  $formData->EmployeurAnt_agent,
                'PersRef_agent'  =>  $formData->PersRef_agent,            
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'cartes'          =>  'NON',
                'envie'          =>  'OUI',
                'author'         =>  $formData->author,
 
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

            $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tagent::where('id',$formData->id)->update([
                'matricule_agent'  =>  $formData->matricule_agent,
                'noms_agent'    =>  $formData->noms_agent,
                'sexe_agent'         =>  $formData->sexe_agent,                
                'datenaissance_agent'      =>  $formData->datenaissance_agent,                
                'lieunaissnce_agent'  =>  $formData->lieunaissnce_agent, 
                'provinceOrigine_agent'  =>  $formData->provinceOrigine_agent,
                'etatcivil_agent'  =>  $formData->etatcivil_agent,
                'refAvenue_agent'  =>  $formData->refAvenue_agent,
                'nummaison_agent'  =>  $formData->nummaison_agent,
                'contact_agent'  =>  $formData->contact_agent,
                'mail_agent'  =>  $formData->mail_agent,
                'grade_agent'  =>  $formData->grade_agent,
                'fonction_agent'  =>  $formData->fonction_agent,
                'specialite_agent'  =>  $formData->specialite_agent, 
                'Categorie_agent'  =>  $formData->Categorie_agent, 
                'niveauEtude_agent'  =>  $formData->niveauEtude_agent, 
                'anneeFinEtude_agent'  =>  $formData->anneeFinEtude_agent, 
                'Ecole_agent'  =>  $formData->Ecole_agent,   
                'conjoint_agent'  =>  $formData->conjoint_agent,
                'nomPere_agent'  =>  $formData->nomPere_agent,
                'nomMere_agent'  =>  $formData->nomMere_agent,
                'Nationalite_agent'  =>  $formData->Nationalite_agent,
                'Collectivite_agent'  =>  $formData->Collectivite_agent,
                'Territoire_agent'  =>  $formData->Territoire_agent,
                'EmployeurAnt_agent'  =>  $formData->EmployeurAnt_agent,
                'PersRef_agent'  =>  $formData->PersRef_agent,            
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'cartes'          =>  $formData->cartes,
                'envie'          =>  $formData->envie,
                'author'         =>  $formData->author
            ]);
            return $this->msgJson('Modifcation avec succès');
//'envie'          =>  'OUI',
        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->noms_agent.''.$formData->noms_agent,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tagent::where('id',$formData->id)->update([
                'matricule_agent'  =>  $formData->matricule_agent,
                'noms_agent'    =>  $formData->noms_agent,
                'sexe_agent'         =>  $formData->sexe_agent,                
                'datenaissance_agent'      =>  $formData->datenaissance_agent,                
                'lieunaissnce_agent'  =>  $formData->lieunaissnce_agent, 
                'provinceOrigine_agent'  =>  $formData->provinceOrigine_agent,
                'etatcivil_agent'  =>  $formData->etatcivil_agent,
                'refAvenue_agent'  =>  $formData->refAvenue_agent,
                'nummaison_agent'  =>  $formData->nummaison_agent,
                'contact_agent'  =>  $formData->contact_agent,
                'mail_agent'  =>  $formData->mail_agent,
                'grade_agent'  =>  $formData->grade_agent,
                'fonction_agent'  =>  $formData->fonction_agent,
                'specialite_agent'  =>  $formData->specialite_agent, 
                'Categorie_agent'  =>  $formData->Categorie_agent, 
                'niveauEtude_agent'  =>  $formData->niveauEtude_agent, 
                'anneeFinEtude_agent'  =>  $formData->anneeFinEtude_agent, 
                'Ecole_agent'  =>  $formData->Ecole_agent,     
                'conjoint_agent'  =>  $formData->conjoint_agent,
                'nomPere_agent'  =>  $formData->nomPere_agent,
                'nomMere_agent'  =>  $formData->nomMere_agent,
                'Nationalite_agent'  =>  $formData->Nationalite_agent,
                'Collectivite_agent'  =>  $formData->Collectivite_agent,
                'Territoire_agent'  =>  $formData->Territoire_agent,
                'EmployeurAnt_agent'  =>  $formData->EmployeurAnt_agent,
                'PersRef_agent'  =>  $formData->PersRef_agent,          
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'cartes'          =>  $formData->cartes,
                'envie'          =>  $formData->envie,
                'author'         =>  $formData->author
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }

    function fetch_list_categorie()
    {
        $data = DB::table('tcategoriemedecin')->select("tcategoriemedecin.id","tcategoriemedecin.designation")->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_fonction()
    {
        $data = DB::table('tfonctionmedecin')->select("tfonctionmedecin.id","tfonctionmedecin.designation")->get();
        return response()->json([
            'data'  => $data,
        ]);
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
        $data = DB::table('tagent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tagent.id","matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent","nummaison_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent',
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent',"photo","slug",
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tagent.author","tagent.created_at","tagent.updated_at","cartes","envie")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->where('tagent.id', $id)->get();

        
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
        $data = tagent::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tagent::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreDatatagent($id, $connected)
    {
        //
        $data = tagent::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }





}
