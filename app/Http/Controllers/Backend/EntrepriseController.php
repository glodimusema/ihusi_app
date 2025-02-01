<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\{User};
use App\Models\Backend\{Entreprise,Pitch,BusnessPlan,Photo_entreprise,VideoEntreprise,LinkCanvas,Swot,LinkCanvasDeux,SwotDeux};
use App\Traits\{GlobalMethod,Slug};

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminEmail;
use Auth;
use DB;
use Validator;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;
    public function index(Request $request)
    {
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',
            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('users.name', 'like', '%'.$query.'%')
            ->orWhere('entreprises.telephoneEntreprise', 'like', '%'.$query.'%')

            ->orWhere('entreprises.nomEntreprise', 'like', '%'.$query.'%')
            ->orWhere('entreprises.rccm', 'like', '%'.$query.'%')
            ->orWhere('forme_juridiques.nomForme', 'like', '%'.$query.'%')
            ->orWhere('secteurs.nomSecteur', 'like', '%'.$query.'%')

            ->orderBy("entreprises.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }


     function checkEtat_entreprise($id, $etat)
    {
        if ($id !=''  && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Entreprise::where('id',$id)->update([
                    'etat'         =>  0
                ]);
                return $this->msgJson('Entreprise desactivée avec succès');

            } else {
                // activation
                Entreprise::where('id',$id)->update([
                    'etat'         =>  1
                ]);
                return $this->msgJson('Entreprise activée avec succès');
            }
            
        }
    }

    //filtrage 
    public function fetch_entreprise_tug($ceo, Request $request)
    {
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where([
                ['provinces.nomProvince', 'like', '%'.$query.'%'],
                ['entreprises.ceo', $ceo]
            ])
            
            ->orderBy("entreprises.id", "desc");

            return $this->apiData($data->paginate(5));
           

        }
        $data->where('entreprises.ceo', $ceo)->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }


    /*
    * filtrage des requetes pour les entreprises
    * ==========================================
    *
    */

    function getEntreprisePays($idPays, Request $request){
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.idPays', $idPays)
        ->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }

    function getEntreprisePprovince($idProvince, Request $request){
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.idProvince', $idProvince)
        ->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }

    function getEntrepriseSecteur($idsecteur, Request $request){
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.idsecteur', $idsecteur)
        ->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }
    function getEntrepriseForme($idforme, Request $request){
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.idforme', $idforme)
        ->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }
    function getEntrepriseEdition($edition, Request $request){
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.edition', $edition)
        ->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }
    
    /*
    * fin filtrage des requetes pour les entreprises
    * ==========================================
    *
    */

    public function showCeoEntreprise(Request $request)
    {
        //
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at');
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('provinces.nomProvince', 'like', '%'.$query.'%')
            ->orWhere('pays.nomPays', 'like', '%'.$query.'%')
            ->orWhere('users.name', 'like', '%'.$query.'%')
            ->orWhere('entreprises.telephoneEntreprise', 'like', '%'.$query.'%')

            ->orWhere('entreprises.nomEntreprise', 'like', '%'.$query.'%')
            ->orWhere('entreprises.rccm', 'like', '%'.$query.'%')
            ->orWhere('forme_juridiques.nomForme', 'like', '%'.$query.'%')
            ->orWhere('secteurs.nomSecteur', 'like', '%'.$query.'%')

            ->orderBy("entreprises.id", "desc");

            return $this->apiData($data->paginate(6));
           

        }
        $data->orderBy("entreprises.id", "desc");
        return $this->apiData($data->paginate(6));
    }

    

    function getMenuFiltrage()
    {
        $list = [];

         array_push($list, array(
            'listePays'                 =>    $this->getDataFitrage("entreprises", "idPays"),
            'listeProvince'             =>    $this->getDataFitrage("entreprises", "idProvince"),
            'listeSecteur'              =>    $this->getDataFitrage("entreprises", "idsecteur"),
            'listeFormeJuridique'       =>    $this->getDataFitrage("entreprises", "idforme"),
            'listeEdition'              =>    $this->getDataFitrage("entreprises", "edition"),
                
        ));

        return response()->json(['data' => $list]);
        
    }

    function getDataFitrage($table, $column)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->groupBy($table.'.'.$column)
        ->get();
        $list = [];
        foreach ($data as $row) {
            array_push($list, array(
                'idProvince'    =>      $row->idProvince,
                'nomProvince'   =>      $row->nomProvince,
                'edition'       =>      $row->edition,
                'ceo'           =>      $row->ceo,
                'idPays'        =>      $row->idPays,
                'nomPays'       =>      $row->nomPays,
                'idsecteur'     =>      $row->idsecteur,
                'nomSecteur'    =>      $row->nomSecteur,
                'idforme'       =>      $row->idforme,
                'nomForme'      =>      $row->nomForme,
                'nbrEntreprise' =>      $this->showCountTableWhere('entreprises',$column, $row->$column),

            ));

        }
        return $list;

    }


    function fetch_entreprise_2()
    {
         $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise',
            'entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise',
            'entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition',
            'entreprises.facebook','entreprises.linkedin','entreprises.twitter',
            'entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche',
            'entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->get();
        
        return response()->json(['data' => $data]);

    }

    //ajout pitch
    function AddPich(Request $request)
    {
      return DB::transaction(function() use($request){

        if (!is_null($request->image)) 
          {


            $formData = json_decode($_POST['data']);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/documents'), $imageName);
            Pitch::create([
                'id_entreprise'     => $formData->agentId,
                'pitch'             => $imageName
            ]);
           
            return json_encode([
                'data'        =>'Photo ajouté avec succès',
                'imageName'   =>$imageName
            ]);

         }

      });
    }

    //ajout pitch
    function AddBusnessPlan(Request $request)
    {
      return DB::transaction(function() use($request){

        if (!is_null($request->image)) 
        {

            // $error = Validator::make($request->all(), [
            //   'image' =>  'required|image|mimes:pptx,zip|max:2048'
            // ]);

            // if($error->fails())
            // {
            //     return response()->json(['data' => "La taille du fichier doit être supérieure ou égale à  2Mo !!!"]);
            // }

            $formData = json_decode($_POST['data']);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/documents'), $imageName);
            BusnessPlan::create([
                'id_entreprise'     => $formData->agentId,
                'busness_plan'             => $imageName
            ]);
           
            return json_encode([
                'data'        =>'Photo ajouté avec succès',
                'imageName'   =>$imageName
            ]);

         }

      });
    }

    function getPhotoEntreprise($slug, Request $request)
    {
        //
        $data = DB::table("photo_entreprises")
        ->join('entreprises','entreprises.id','=','photo_entreprises.id_entreprise')
        ->select("photo_entreprises.id","photo_entreprises.id as id_photo", "photo_entreprises.photo",
         "photo_entreprises.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where([
                ['photo_entreprises.id_entreprise', 'like', '%'.$query.'%'],
                ['entreprises.slug', $slug],
            ])
            ->orderBy("photo_entreprises.id", "desc");

            return $this->apiData($data->paginate(6));
           

        }
        $data->where('entreprises.slug', $slug)->orderBy("photo_entreprises.id", "desc");
        return $this->apiData($data->paginate(6));
    }

    //ajout des photos
    function AddPhotoEntreprise(Request $request)
    {
      return DB::transaction(function() use($request){

        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/documents/images'), $imageName);
            Photo_entreprise::create([
                'id_entreprise'     => $formData->agentId,
                'photo'             => $imageName
            ]);
           
            return json_encode([
                'data'        =>'Photo ajouté avec succès',
                'imageName'   =>$imageName
            ]);

         }

      });
    }

    function destroyPhotoEntreprise($id)
    {
        //
        $data = Photo_entreprise::where('id', $id)->delete();
        return $this->msgJson("Suppression de l'image avec succès!!!");
    }

    /*
    * scripts pour les videos
    * =======================
    *
    */
    //gets les videos
    function getVideoEntreprise($slug, Request $request)
    {
        //
        $data = DB::table("video_entreprises")
        ->join('entreprises','entreprises.id','=','video_entreprises.ceo')
        ->select("video_entreprises.id","video_entreprises.id as id_entreprise", "video_entreprises.titre","video_entreprises.url","video_entreprises.description",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "video_entreprises.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where([
                ['video_entreprises.titre', 'like', '%'.$query.'%'],
                ['entreprises.slug', $slug],
            ])
            ->orderBy("video_entreprises.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->where('entreprises.slug', $slug)->orderBy("video_entreprises.id", "desc");
        return $this->apiData($data->paginate(4));
    }

    function storeVideoEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = VideoEntreprise::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = VideoEntreprise::create([
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

        }
    }

    function editVideoEntreprise($id)
    {
        //
        $data = VideoEntreprise::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroyVideoEntreprise($id)
    {
        //suppression avec succès
        $data = VideoEntreprise::where('id', $id)->delete();
        return $this->msgJson("Suppression des données avec succès!!!");

    }

    //fin script videos

    //script pour le canvas
    function getCanvasEntreprise($slug, Request $request)
    {
        //
        $list = [];
        if ($slug !='') {
            // code...
            array_push($list, array(
                'listCanvasUser'            =>  $this->canvasUser($slug),
                'listCanvasUserCorrection'  =>  $this->canvasCorrectionUser($slug),
                
            ));
            return response()->json([
                'data'      =>  $list,
            ]);
        }
        else{
            return response()->json([
                'data'      =>  array(""),
            ]);
        }
    }

    function canvasUser($slug)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("link_canvases")
        ->join('entreprises','entreprises.id','=','link_canvases.ceo')
        ->select("link_canvases.id","link_canvases.id as id_entreprise", "link_canvases.titre","link_canvases.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "link_canvases.created_at")
        ->where('entreprises.slug', $slug)
        ->orderBy("link_canvases.id", "desc")
        ->groupBy("link_canvases.titre")
        ->get();
        $listCanvasUser = [];
        foreach ($data as $row) {
            // code...
            array_push($listCanvasUser, array(
                'titre'         =>  $row->titre,
                'ListRowCanvas'    =>  $this->getMessageCanvas($slug, $row->titre),
            ));
        }
        return $listCanvasUser;
    }

    function getMessageCanvas($slug, $titre)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("link_canvases")
        ->join('entreprises','entreprises.id','=','link_canvases.ceo')
        ->select("link_canvases.id","link_canvases.id as id_entreprise", "link_canvases.titre","link_canvases.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "link_canvases.created_at")
        ->where([
            ['entreprises.slug', $slug],
            ['link_canvases.titre', $titre],
        ])
        ->orderBy("link_canvases.id", "desc")
        ->get();
        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id'            =>  $row->id,
                'ceo'           =>  $row->ceo,
                'titre'         =>  $row->titre,
                'message'       =>  $row->message,
                'created_at'    =>  $row->created_at,
            ));
        }
        return $list;

    }

    //correction des données canvas
     function canvasCorrectionUser($slug)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("link_canvas_deuxes")
        ->join('entreprises','entreprises.id','=','link_canvas_deuxes.ceo')
        ->select("link_canvas_deuxes.id","link_canvas_deuxes.id as id_entreprise", "link_canvas_deuxes.titre","link_canvas_deuxes.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "link_canvas_deuxes.created_at")
        ->where('entreprises.slug', $slug)
        ->orderBy("link_canvas_deuxes.id", "desc")
        ->groupBy("link_canvas_deuxes.titre")
        ->get();
        $listCanvasUser = [];
        foreach ($data as $row) {
            // code...
            array_push($listCanvasUser, array(
                'titre'         =>  $row->titre,
                'ListRowCanvas'    =>  $this->getMessageCorrectionCanvas($slug, $row->titre),
            ));
        }
        return $listCanvasUser;
    }

    function getMessageCorrectionCanvas($slug, $titre)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("link_canvas_deuxes")
        ->join('entreprises','entreprises.id','=','link_canvas_deuxes.ceo')
        ->join('users','users.id','=','link_canvas_deuxes.id_coach')
        ->select("link_canvas_deuxes.id","link_canvas_deuxes.id as id_entreprise", "link_canvas_deuxes.titre","link_canvas_deuxes.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
            "users.name","users.email","users.avatar",
         "link_canvas_deuxes.created_at")
        ->where([
            ['entreprises.slug', $slug],
            ['link_canvas_deuxes.titre', $titre],
        ])
        ->orderBy("link_canvas_deuxes.id", "desc")
        ->get();
        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id'            =>  $row->id,
                'ceo'           =>  $row->ceo,
                'titre'         =>  $row->titre,
                'message'       =>  $row->message,

                'name'          =>  $row->name,
                'email'         =>  $row->email,
                'avatar'        =>  $row->avatar,
                'created_at'    =>  $row->created_at,
            ));
        }
        return $list;

    }
    //fin correction

    function storeCanvasEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = LinkCanvas::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification des données avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = LinkCanvas::create([
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Insertion des données avec succès!!!"]);
         
        }
    }

    function editCanvasEntreprise($id)
    {
        //
        $data = LinkCanvas::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroyCanvasEntreprise($id)
    {
        //suppression avec succès
        $data = LinkCanvas::where('id', $id)->delete();
        return $this->msgJson("Suppression des données avec succès!!!");

    }

    //pour canvas correction
    function storeCanvasCorrectionEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = LinkCanvasDeux::where("id", $request->id)->update([
                'id_coach'      =>  $request->id_coach,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification des données pour la correction avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = LinkCanvasDeux::create([
                'id_coach'      =>  $request->id_coach,
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Insertion des données pour la correction avec succès!!!"]);
         
        }
    }

    function editCanvasCorrectionEntreprise($id)
    {
        //
        $data = LinkCanvasDeux::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroyCanvasCorrectionEntreprise($id)
    {
        //suppression avec succès
        $data = LinkCanvasDeux::where('id', $id)->delete();
        return $this->msgJson("Suppression des données pour la correction avec succès!!!");

    }
    //fin canvas correction
    // fin script canvas

    /*
    * swot model
    * ===============
    */
    function storeSwotEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = Swot::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification des données avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = Swot::create([
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Insertion des données avec succès!!!"]);
         
        }
    }

    function editSwotEntreprise($id)
    {
        //
        $data = Swot::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroySwotEntreprise($id)
    {
        //suppression avec succès
        $data = Swot::where('id', $id)->delete();
        return $this->msgJson("Suppression des données avec succès!!!");

    }

    //pour canvas correction
    function storeSwotCorrectionEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = SwotDeux::where("id", $request->id)->update([
                'id_coach'      =>  $request->id_coach,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification des données pour la correction avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = SwotDeux::create([
                'id_coach'      =>  $request->id_coach,
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'message'       =>  $request->message
            ]);
            return response()->json(['data'  =>  "Insertion des données pour la correction avec succès!!!"]);
         
        }
    }

    function editSwotCorrectionEntreprise($id)
    {
        //
        $data = SwotDeux::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroySwotCorrectionEntreprise($id)
    {
        //suppression avec succès
        $data = SwotDeux::where('id', $id)->delete();
        return $this->msgJson("Suppression des données pour la correction avec succès!!!");

    }
    //fin canvas correction

    //affichange des données
    function getSwotEntreprise($slug, Request $request)
    {
        //
        $list = [];
        if ($slug !='') {
            // code...
            array_push($list, array(
                'listCanvasUser'            =>  $this->swotUser($slug),
                'listCanvasUserCorrection'  =>  $this->swotCorrectionUser($slug),
                
            ));
            return response()->json([
                'data'      =>  $list,
            ]);
        }
        else{
            return response()->json([
                'data'      =>  array(""),
            ]);
        }
    }

    function swotUser($slug)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("swots")
        ->join('entreprises','entreprises.id','=','swots.ceo')
        ->select("swots.id","swots.id as id_entreprise", "swots.titre","swots.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "swots.created_at")
        ->where('entreprises.slug', $slug)
        ->orderBy("swots.id", "desc")
        ->groupBy("swots.titre")
        ->get();
        $listCanvasUser = [];
        foreach ($data as $row) {
            // code...
            array_push($listCanvasUser, array(
                'titre'         =>  $row->titre,
                'ListRowCanvas'    =>  $this->getMessageSwot($slug, $row->titre),
            ));
        }
        return $listCanvasUser;
    }

    function getMessageSwot($slug, $titre)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("swots")
        ->join('entreprises','entreprises.id','=','swots.ceo')
        ->select("swots.id","swots.id as id_entreprise", "swots.titre","swots.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "swots.created_at")
        ->where([
            ['entreprises.slug', $slug],
            ['swots.titre', $titre],
        ])
        ->orderBy("swots.id", "desc")
        ->get();
        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id'            =>  $row->id,
                'ceo'           =>  $row->ceo,
                'titre'         =>  $row->titre,
                'message'       =>  $row->message,
                'created_at'    =>  $row->created_at,
            ));
        }
        return $list;

    }

    //correction des données canvas
     function swotCorrectionUser($slug)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("swot_deuxes")
        ->join('entreprises','entreprises.id','=','swot_deuxes.ceo')
        ->select("swot_deuxes.id","swot_deuxes.id as id_entreprise", "swot_deuxes.titre","swot_deuxes.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
         "swot_deuxes.created_at")
        ->where('entreprises.slug', $slug)
        ->orderBy("swot_deuxes.id", "desc")
        ->groupBy("swot_deuxes.titre")
        ->get();
        $listCanvasUser = [];
        foreach ($data as $row) {
            // code...
            array_push($listCanvasUser, array(
                'titre'         =>  $row->titre,
                'ListRowCanvas'    =>  $this->getMessageCorrectionSwot($slug, $row->titre),
            ));
        }
        return $listCanvasUser;
    }

    function getMessageCorrectionSwot($slug, $titre)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("swot_deuxes")
        ->join('entreprises','entreprises.id','=','swot_deuxes.ceo')
        ->join('users','users.id','=','swot_deuxes.id_coach')
        ->select("swot_deuxes.id","swot_deuxes.id as id_entreprise", "swot_deuxes.titre","swot_deuxes.message",
            "entreprises.ceo","entreprises.nomEntreprise","entreprises.logo","entreprises.emailEntreprise",
            "users.name","users.email","users.avatar",
         "swot_deuxes.created_at")
        ->where([
            ['entreprises.slug', $slug],
            ['swot_deuxes.titre', $titre],
        ])
        ->orderBy("swot_deuxes.id", "desc")
        ->get();
        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id'            =>  $row->id,
                'ceo'           =>  $row->ceo,
                'titre'         =>  $row->titre,
                'message'       =>  $row->message,

                'name'          =>  $row->name,
                'email'         =>  $row->email,
                'avatar'        =>  $row->avatar,
                'created_at'    =>  $row->created_at,
            ));
        }
        return $list;

    }
    //fin correction
    //fin affichage des donnees

    /*
    * fin swot model
    * ===============
    */




    

    

    //voir les information des la video
    function getEntrepriseDetails($slug)
    {
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse','users.sexe',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('slug',$slug)->first();

        return response()->json([
            'projectDetail'   => $data
        ]);

    }

    //voir le document
    function getEntrepriseDetailsDocument($slug)
    {
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse','users.sexe',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('slug',$slug)
        ->take(1)->get();
        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'Pitch_list'    =>  $this->getEntreprisePitch($row->id),
                'Document_list' =>  $this->getEntrepriseDocument($row->id),
            ));
        }

        return response()->json([
            'data'   => $list
        ]);

    }
    function getEntreprisePitch($id_entreprise)
    {
        $data = DB::table('pitches')
        
        ->select('pitches.id as id','pitches.pitch as pitch', 'pitches.created_at')
        ->where('pitches.id_entreprise',$id_entreprise)
        ->take(1)->get();

        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id_pitch'      =>  $row->id,
                'pitch'         =>  $row->pitch,
                'created_at'    =>  $row->created_at,
            ));
        }

        return $list;

    }

    function getEntrepriseDocument($id_entreprise)
    {
        $data = DB::table('busness_plans')
        
        ->select('busness_plans.id as id','busness_plans.busness_plan as busness_plan', 'busness_plans.created_at')
        ->where('busness_plans.id_entreprise',$id_entreprise)
        ->take(1)->get();

        $list = [];
        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'id_busness_plan'      =>  $row->id,
                'busness_plan'         =>  $row->busness_plan,
                'created_at'           =>  $row->created_at,
            ));
        }

        return $list;

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
        $slug ='';
        $formData = json_decode($_POST['data']);

        $stringToSlug=substr($formData->nomEntreprise,0,16).'-'.$this->generateOpt(8);
        $slug =$this->makeSlug($stringToSlug);

        if ($formData->id !='') 
        {
            # code...
            // update 

            if (!is_null($request->image)) 
            {
                
                $imageName = time().'.'.$request->image->getClientOriginalExtension();

                $request->image->move(public_path('/images'), $imageName);
                $formData = json_decode($_POST['data']);

                $data = Entreprise::where("id", $formData->id)->update([
                    'ceo'                   =>  $formData->ceo,
                    'nomEntreprise'         =>  $formData->nomEntreprise,
                    'descriptionEntreprise' =>  $formData->descriptionEntreprise,
                    'rccm'                  =>  $formData->rccm,
                    'emailEntreprise'       =>  $formData->emailEntreprise,
                    'adresseEntreprise'     =>  $formData->adresseEntreprise,
                    'telephoneEntreprise'   =>  $formData->telephoneEntreprise,
                    'solutionEntreprise'    =>  $formData->solutionEntreprise,
                    'idsecteur'             =>  $formData->idsecteur,
                    'idforme'               =>  $formData->idforme,
                    'idPays'                =>  $formData->idPays,
                    'idProvince'            =>  $formData->idProvince,
                    'edition'               =>  $formData->edition,

                    'facebook'              =>  $formData->facebook,
                    'linkedin'              =>  $formData->linkedin,
                    'twitter'               =>  $formData->twitter,
                    'siteweb'               =>  $formData->siteweb,
                    'invPersonnel'          =>  $formData->invPersonnel,

                    'invHub'                =>  $formData->invHub,
                    'invRecherche'          =>  $formData->invRecherche,
                    'chiffreAffaire'        =>  $formData->chiffreAffaire,
                    'nbremploye'            =>  $formData->nbremploye,
                    'slug'                  =>  $slug,
                    'logo'                  =>  $imageName
                    
                ]);
                return $this->msgJson('Modification avec succès!!!');

            }
            else{

                $formData = json_decode($_POST['data']);
                $data = Entreprise::where("id", $formData->id)->update([
                    'ceo'                   =>  $formData->ceo,
                    'nomEntreprise'         =>  $formData->nomEntreprise,
                    'descriptionEntreprise' =>  $formData->descriptionEntreprise,
                    'rccm'                  =>  $formData->rccm,
                    'emailEntreprise'       =>  $formData->emailEntreprise,
                    'adresseEntreprise'     =>  $formData->adresseEntreprise,
                    'telephoneEntreprise'   =>  $formData->telephoneEntreprise,
                    'solutionEntreprise'    =>  $formData->solutionEntreprise,
                    'idsecteur'             =>  $formData->idsecteur,
                    'idforme'               =>  $formData->idforme,
                    'idPays'                =>  $formData->idPays,
                    'idProvince'            =>  $formData->idProvince,
                    'edition'               =>  $formData->edition,

                    'facebook'              =>  $formData->facebook,
                    'linkedin'              =>  $formData->linkedin,
                    'twitter'               =>  $formData->twitter,
                    'siteweb'               =>  $formData->siteweb,
                    'invPersonnel'          =>  $formData->invPersonnel,

                    'invHub'                =>  $formData->invHub,
                    'invRecherche'          =>  $formData->invRecherche,
                    'chiffreAffaire'        =>  $formData->chiffreAffaire,
                    'nbremploye'            =>  $formData->nbremploye,
                    'slug'                  =>  $slug
                    
                ]);
                return $this->msgJson('Modification avec succès!!!');

            }


            

        }
        else
        {
            // insertion 

            if (!is_null($request->image)) 
            {
                $imageName = time().'.'.$request->image->getClientOriginalExtension();

                $request->image->move(public_path('/images'), $imageName);
                $formData = json_decode($_POST['data']);

                $data = Entreprise::create([
                    'ceo'                   =>  $formData->ceo,
                    'nomEntreprise'         =>  $formData->nomEntreprise,
                    'descriptionEntreprise' =>  $formData->descriptionEntreprise,
                    'rccm'                  =>  $formData->rccm,
                    'emailEntreprise'       =>  $formData->emailEntreprise,
                    'adresseEntreprise'     =>  $formData->adresseEntreprise,
                    'telephoneEntreprise'   =>  $formData->telephoneEntreprise,
                    'solutionEntreprise'    =>  $formData->solutionEntreprise,
                    'idsecteur'             =>  $formData->idsecteur,
                    'idforme'               =>  $formData->idforme,
                    'idPays'                =>  $formData->idPays,
                    'idProvince'            =>  $formData->idProvince,
                    'edition'               =>  $formData->edition,

                    'facebook'              =>  $formData->facebook,
                    'linkedin'              =>  $formData->linkedin,
                    'twitter'               =>  $formData->twitter,
                    'siteweb'               =>  $formData->siteweb,
                    'invPersonnel'          =>  $formData->invPersonnel,

                    'invHub'                =>  $formData->invHub,
                    'invRecherche'          =>  $formData->invRecherche,
                    'chiffreAffaire'        =>  $formData->chiffreAffaire,
                    'nbremploye'            =>  $formData->nbremploye,
                    'slug'                  =>  $slug,
                    'logo'                  =>  $imageName
                    
                ]);
                if (!empty($data)) {
                    // code...
                    $userInfo = $this->getAdminInfo($formData->ceo);
                    $this->sendEmailToAdmin($formData->nomEntreprise,$userInfo);
                }
                return $this->msgJson('Information ajoutée avec succès!!!');

            }
            else{

                $formData = json_decode($_POST['data']);
                $data = Entreprise::create([
                    'ceo'                   =>  $formData->ceo,
                    'nomEntreprise'         =>  $formData->nomEntreprise,
                    'descriptionEntreprise' =>  $formData->descriptionEntreprise,
                    'rccm'                  =>  $formData->rccm,
                    'emailEntreprise'       =>  $formData->emailEntreprise,
                    'adresseEntreprise'     =>  $formData->adresseEntreprise,
                    'telephoneEntreprise'   =>  $formData->telephoneEntreprise,
                    'solutionEntreprise'    =>  $formData->solutionEntreprise,
                    'idsecteur'             =>  $formData->idsecteur,
                    'idforme'               =>  $formData->idforme,
                    'idPays'                =>  $formData->idPays,
                    'idProvince'            =>  $formData->idProvince,
                    'edition'               =>  $formData->edition,

                    'facebook'              =>  $formData->facebook,
                    'linkedin'              =>  $formData->linkedin,
                    'twitter'               =>  $formData->twitter,
                    'siteweb'               =>  $formData->siteweb,
                    'invPersonnel'          =>  $formData->invPersonnel,

                    'invHub'                =>  $formData->invHub,
                    'invRecherche'          =>  $formData->invRecherche,
                    'chiffreAffaire'        =>  $formData->chiffreAffaire,
                    'nbremploye'            =>  $formData->nbremploye,
                    'slug'                  =>  $slug,
                    'logo'                  =>  'logo.png'
                    
                ]);
                if (!empty($data)) {
                    // code...
                    $userInfo = $this->getAdminInfo($formData->ceo);
                    $this->sendEmailToAdmin($formData->nomEntreprise,$userInfo);
                }
                return $this->msgJson('Information ajoutée avec succès');

            }

           
        }

    }

    //envoie de mail aux administrateurs
    function sendEmailToAdmin($project_name,$userInfo)
    {
       if ($userInfo->user_type == "SousManagerxq12") 
        {
           //send email
         $data=array(
            'project_name'=>$project_name,
            'name'        =>$userInfo->name,
            'email'       =>$userInfo->email,
          );

           $users=$this->getAdminEmail();
           foreach ($users as $row){
               //amdin email
             Mail::to($row->email)->send(new AdminEmail($data));
           }
          
        } 
    }


    function getAdminEmail()
    {
        $users = User::where('id_role',1)->select('email')->get();
        return $users;
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
        $data = DB::table('entreprises')
        ->join('secteurs','secteurs.id','=','entreprises.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprises.idforme')

        ->join('pays','pays.id','=','entreprises.idPays')
        ->join('provinces','provinces.id','=','entreprises.idProvince')
        ->join('users','users.id','=','entreprises.ceo')
        
        ->select('entreprises.id as id','entreprises.id as idEntreprise',

            //

            'entreprises.ceo','entreprises.nomEntreprise','entreprises.descriptionEntreprise','entreprises.emailEntreprise','entreprises.adresseEntreprise',
            'entreprises.telephoneEntreprise','entreprises.solutionEntreprise','entreprises.idsecteur','entreprises.idforme','entreprises.etat',
            'entreprises.idPays','entreprises.idProvince','entreprises.edition','entreprises.facebook','entreprises.linkedin','entreprises.twitter','entreprises.siteweb','entreprises.rccm',
            'entreprises.invPersonnel','entreprises.invHub','entreprises.invRecherche','entreprises.chiffreAffaire','entreprises.nbremploye','entreprises.slug','entreprises.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprises.created_at')
        ->where('entreprises.id', $id)
        ->get();
        return response()->json(['data' => $data]);
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
        $data = Entreprise::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
