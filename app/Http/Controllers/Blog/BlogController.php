<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog\{Blog};
use App\Models\Category\{CategoryArticle};
use App\Traits\{GlobalMethod,Slug};
use DB;

class BlogController extends Controller
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
        $data = DB::table("blogs")
        ->join('category_articles','category_articles.id','=','blogs.id_cat')
        ->join('users','users.id','=','blogs.user_id')
        ->select("blogs.id", "blogs.titre","blogs.description","blogs.photo","blogs.etat",
            "category_articles.nom","blogs.id_cat",'blogs.user_id',

            'users.avatar','users.name','users.email','users.sexe',

         "blogs.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('blogs.titre', 'like', '%'.$query.'%')
            ->orWhere('blogs.description', 'like', '%'.$query.'%')
            ->orWhere('category_articles.nom', 'like', '%'.$query.'%')
            ->orWhere('users.name', 'like', '%'.$query.'%')
            ->orderBy("blogs.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data ->orderBy("blogs.id", "desc");
        return $this->apiData($data->paginate(4));
    }

    function checkEtat_blog($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Blog::where('id',$id)->update([
                    'etat'         =>  0
                ]);
                return $this->msgJson('La donnée a été desactivée avec succès');

            } else {
                // activation
                Blog::where('id',$id)->update([
                    'etat'         =>  1
                ]);
                return $this->msgJson('La donnée a été activée avec succès');
            }
            
        }
    }


    function editPhoto(Request $request)
    {
      if (!is_null($request->image)) 
      {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        // $request->image->move(storage_path('app/public/article/'), $imageName);
        $request->image->move(public_path('/article'), $imageName);

        Site::where('id',$formData->agentId)->update(['logo' => $imageName]);
        return $this->msgJson('Fichier ajouté avec succès');

      }
       
    }

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/article'), $imageName);

            $stringToSlug=substr($formData->titre,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            Blog::create([
                'titre'         =>  $formData->titre,
                'id_cat'        =>  $formData->id_cat,
                'slug'          =>  $slug,
                'description'   =>  $formData->description,
                'user_id'       =>  $formData->user_id,
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->titre,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            Blog::create([
                'titre'         =>  $formData->titre,
                'id_cat'        =>  $formData->id_cat,
                'slug'          =>  $slug,
                'description'   =>  $formData->description,
                'user_id'       =>  $formData->user_id,
                'photo'         =>  "vuetify.png"
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

            $request->image->move(public_path('/article'), $imageName);
            $stringToSlug=substr($formData->titre,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            Blog::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'id_cat'        =>  $formData->id_cat,
                'slug'          =>  $slug,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->titre,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            Blog::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'id_cat'        =>  $formData->id_cat,
                'slug'          =>  $slug,
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
        $blog = DB::table("blogs")
        ->join('category_articles','category_articles.id','=','blogs.id_cat')
        ->join('users','users.id','=','blogs.user_id')
        ->select("blogs.id", "blogs.titre","blogs.description","blogs.photo","blogs.etat",
            "category_articles.nom","blogs.id_cat",'blogs.user_id',

            'users.avatar','users.name','users.email','users.sexe',

         "blogs.created_at")->where('blogs.id', $id)->get();
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'titre'         =>  $row->titre,
                'id_cat'        =>  $row->id_cat,
                'description'   =>  html_entity_decode($row->description),
                'photo'         =>  $row->photo,
                'name'          =>  $row->name,
                'email'         =>  $row->email,
                'sexe'          =>  $row->sexe,
                'avatar'        =>  $row->avatar
            ));
        }
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
        $data = Blog::where("id", $id)->delete();

        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
