<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Team\{Team};
use App\Traits\{GlobalMethod,Slug};
use DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\ContactInfo\{ContactInfo};


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;
    public function index()
    {
        //
        //
        $titre = "Accueil vous soit doux!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(1)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);

        

        return view('site.index', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services
        ]);

    }

    public function services()
    {
        //
        //
        $titre = "Nos services!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);

        

        return view('site.services', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services
        ]);

    }

     public function service($id)
    {
        //

        $titre = "Détail servive ".$this->getTitreService($id);
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->where('id',$id)->take(1)->get();

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);

        

        return view('site.services_2', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services
        ]);

    }

    public function blogs()
    {
        //
        //
        $titre = "Nos articles!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);

        

        return view('site.blogs', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services
        ]);

    }

    public function blog($slug)
    {

        //
        $titre = $this->getTitreBlog($slug);

        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(1)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where([
            ["etat", 1],
            ['slug', $slug]
        ])->take(1)->get();

        

        return view('site.blogSigle', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services
        ]);

    }

    function getTitreBlog($slug)
    {
        $info='';
        $blogs = DB::table('blogs')->where([
            ["etat", 1],
            ['slug', $slug]
        ])->take(1)->get();

        foreach ($blogs as $key) {
            // code...
            $info = $key->titre;
        }

        return $info;

    }

    function getTitreService($id)
    {
        $info='';
        $blogs = DB::table('service_entreps')->where([
            ['id', $id]
        ])->take(1)->get();

        foreach ($blogs as $key) {
            // code...
            $info = $key->titre;
        }

        return $info;

    }


    public function videos()
    {
        //
        //
        $titre = "Nos vidéos!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        

        return view('site.videos', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos
        ]);

    }

    public function about()
    {
        //
        //
        $titre = "A propos de nous!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        $basics = DB::table('basics')->take(1)->get();
        

        return view('site.about', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos,
            'basics'        =>  $basics,
        ]);

    }

     public function travail()
    {
        //
        //
        $titre = "Ce que nous faisons!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        $basics = DB::table('basics')->take(1)->get();
        

        return view('site.travail', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos,
            'basics'        =>  $basics,
        ]);

    }

     public function structure()
    {
        //
        //
        $titre = "Notre structure de gestion!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        $basics = DB::table('basics')->take(1)->get();
        

        return view('site.structure', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos,
            'basics'        =>  $basics,
        ]);

    }

     public function don()
    {

        //
        $titre = "Nous faire un don!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        $basics = DB::table('basics')->take(1)->get();
        

        return view('site.don', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos,
            'basics'        =>  $basics,
        ]);

    }

      public function partenariat()
    {

        //
        $titre = "Faisons un partenariat!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        $basics = DB::table('basics')->take(1)->get();
        

        return view('site.partenariat', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos,
            'basics'        =>  $basics,
        ]);

    }

    public function contact()
    {
        //
        //
        $titre = "Contactez-nous pour l'information!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        

        return view('site.contact', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos
        ]);

    }

    public function sendMessage(Request $request)
    {

        $validates = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|min:3',
            'telephone' => 'required|min:3',
            'subject' => 'required|min:3',
            'message' => 'required|min:3'
        ]);

        if ($validates->fails()) {
            Session::flash('error', 'Tous les champs sont obligatoires.');
            return redirect()->back()->with('error', 'Tous les champs sont obligatoires.');
        }

        // insertion 
        $data = ContactInfo::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'telephone' =>  $request->telephone,
            'subject'   =>  $request->subject,
            'message'   =>  $request->message
        ]);
        Session::flash('success', 'Nous vous répondrons dans un instant!!!');
        return redirect()->back()->with('success', 'Nous vous répondrons dans un instant!!!');  
        

    }

    public function galeryphoto()
    {
        //
        //
        $titre = "Galerie photo!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->orderBy('id','desc')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        

        return view('site.galeryphoto', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos
        ]);

    }


    public function teamMember()
    {
        //
        //
        $titre = "Equipe compétente!";
        $siteInfo = DB::table('sites')->take(1)->get();
        $valeurs = DB::table('valeurs')->orderBy('id','desc')->take(10)->get();
        $partenaires = DB::table('partenaires')->take(100)->get();
        $galeries = DB::table('galeries')->orderBy('id','desc')->paginate(6);
        $teams = DB::table('teams')->where("etat", 1)->paginate(8);
        $carousels = DB::table('carousels')->inRandomOrder()->take(3)->get();

        $valeurs = DB::table('valeurs')->inRandomOrder()->take(4)->get();

        $services = DB::table('service_entreps')->paginate(6);

        $blogs = DB::table('blogs')->where("etat", 1)->orderBy('id','desc')->paginate(3);
        $videos = DB::table('videos')->paginate(3);
        

        return view('site.groupe', [
            'title'         =>  $titre,
            'siteInfo'      =>  $siteInfo,
            'valeurs'       =>  $valeurs,
            'partenaires'   =>  $partenaires,
            'galeries'      =>  $galeries,
            'teams'         =>  $teams,
            'valeurs'       =>  $valeurs,
            'carousels'     =>  $carousels,
            'blogs'         =>  $blogs,
            'services'      =>  $services,
            'videos'        =>  $videos
        ]);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }
}
