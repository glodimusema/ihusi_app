<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category\{CategoryArticle};
use App\Traits\{GlobalMethod, Slug};
use DB;

class CategoryArticleController extends Controller
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
         $data = DB::table("category_articles")
        ->select("category_articles.id", "category_articles.nom","category_articles.slug", "category_articles.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('category_articles.nom', 'like', '%'.$query.'%')
            ->orWhere('category_articles.id', 'like', '%'.$query.'%')
            ->orderBy("category_articles.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        return $this->apiData($data->paginate(4));
    }

    function fetchCategoryArticle(Request $request)
    {
        //
         $data = DB::table("category_articles")
        ->select("category_articles.id", "category_articles.nom","category_articles.slug", "category_articles.created_at")->get();

        return response()->json(['data'  =>  $data]);
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
        if ($request->id !='') 
        {
            # code...
            // update 
            $stringToSlug=substr($request->nom,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            $data = CategoryArticle::where("id", $request->id)->update([
                'nom'       =>  $request->nom,
                'slug'      =>  $slug
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $stringToSlug=substr($request->nom,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            $data = CategoryArticle::create([
                'nom'       =>  $request->nom,
                'slug'      =>  $slug
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

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
        $data = CategoryArticle::where('id', $id)->get();
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
        $data = CategoryArticle::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
