<?php 
namespace App\Traits;
use App\{User};
use DB;
use Carbon\Carbon;

trait GlobalMethod{

	//global query
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
    }

    function f_date($date)
    {
      $date = new Date($date);
      return substr($date->format('d/m/Y'), 0,10);
    }

    function CreatedAt($date)
    {
       $created_at = nl2br(substr(date(DATE_RFC822, strtotime($date)), 0, 23));
       return $created_at; 
    }

    function GetCodeMax($table,$field_module,$value_module)
    {
      $count = 1;
      $code = 0;
      $data1 =  DB::table($table)       
      ->select("".$table.".maxid")
      ->where(''.$table.'.'.$field_module.'', '=', $value_module) 
      ->get();       
      foreach ($data1 as $row) 
      {  
          $code=$row->maxid;                  
      }
      
      $data2 = DB::update(
        'update '.$table.' set maxid = maxid + :count where '.$field_module.' = :modules',
        ['count' => $count,'modules' => $value_module]
      );
       return $code; 
    }

    function GetCodeData($table,$field_module,$value_module)
    {
      $count = 1;
      $code = 0;
      $data1 =  DB::table($table)       
      ->select("".$table.".maxid")
      ->where(''.$table.'.'.$field_module.'', '=', $value_module) 
      ->get();       
      foreach ($data1 as $row) 
      {  
          $code=$row->maxid;                  
      }
      
      $data2 = DB::update(
        'update '.$table.' set maxid = maxid + :count where '.$field_module.' = :modules',
        ['count' => $count,'modules' => $value_module]
      );
       return $code; 
    }

    function GetMaxId($table, $filed_id, $id)
    {
      $count = 1;
      $code = 0;

      $data2 = DB::update(
        'update '.$table.' set nombre_print = nombre_print + :count where '.$filed_id.' = :id',
        ['count' => $count,'id' => $id]
      );

      $data1 =  DB::table($table)       
      ->select("".$table.".nombre_print")
      ->where(''.$table.'.'.$filed_id.'', '=', $id) 
      ->get();       
      foreach ($data1 as $row) 
      {  
          $code=$row->nombre_print;                  
      }     
     
       return $code; 
    }

    function GetCode2($table)
    {
        $demandes = DB::table($table)->get();
        $count = $demandes->count();
        $newId = floatval($count) + 1;
        return $newId;

    }




    function apiData($data)
    {
      return response($data, 200);
    }


    function msgJson($message)
    {
        return response()->json(['data' => $message]);
    }

    function msgError($message)
    {
      return response()->json(['error'  => $message]);
    }


    function generateOpt($n)
  	{
  	    $generator="1234567890AZERTYUIOPQSDFGHJKLMWXCVBN";
  	    $result="";
  	    for ($i=0; $i <$n ; $i++)
  	    {
  	      $result.=substr($generator, (rand()%(strlen($generator))),1);
  	    }
  	    return $result;
  	}

    /*
    ========================
    // mes scripts ajouts
    *=======================
    *
    *
    */
    // nombre de notification
    function showCountNotification($column, $value, $table)
    {
        $demandes = DB::table($table)->where([
            [$column, '=', $value],
        ])->get();

        $count = $demandes->count();
        return $count;

    }


    function showCountNotificationWhere($column, $value, $table,$column2, $value2)
    {
        $demandes = DB::table($table)->where([
            [$column, '=', $value],
            [$column2, '=', $value2],
        ])->get();

        $count = $demandes->count();
        return $count;

    }
    // voir les nombre sur les tables 
    function showCountTableWhere($table,$column, $valeur)
    {
      $data = DB::table($table)->where($column,'=', $valeur)->count();
      return $data;
    }

    // voir les nombre sur les tables 
    function showCountConratActif()
    {
      $current = Carbon::now();      
      $data = DB::table('tperso_affectation_agent')->where([
            ['dateFin', '>=', $current],
            ['conge', '=', 'NON']
       ])->count();
      return $data;
    }

    function showCountConratFini()
    {
      $current = Carbon::now();      
      $data = DB::table('tperso_affectation_agent')->where([
            ['dateFin', '<', $current],
            ['conge', '=', 'NON']
       ])->count();
      return $data;
    }

    function showCountConratEnconge()
    {
      $current = Carbon::now();      
      $data = DB::table('tperso_affectation_agent')->where([
            ['dateFin', '>=', $current],
            ['conge', '=', 'OUI']
       ])->count();
      return $data;
    }

    //difentent de column null
     function showCountTableWhereNull($table,$column, $valeur,$column2, $valeur2)
    {
      $data = DB::table($table)->where([
        [$column,'=', $valeur],
        [$column2,'!=', $valeur2]
      ])->count();
      return $data;
    }

    function showCountTableWhere2($table,$column, $valeur,$column2, $valeur2)
    {
      $data = DB::table($table)->where([
        [$column,'=', $valeur],
        [$column2,'=', $valeur2]
      ])->count();
      return $data;
    }

    // voir les nombre sur les tables 
    function showCountTable($table)
    {
      $data = DB::table($table)->count();
      return $data;
    }

    // utulisateur en action connecté 
    function UsersActionConnected($id_user)
    {
        $contributions = DB::table("users")
        ->join('roles','users.id_role','=','roles.id')        
        ->select('users.id','users.name','users.email','users.id_role','roles.role_name as role', 'users.created_at')
        ->where('users.id', '=', $id_user)->get();
        $data = [];
        foreach ($contributions as $row) {
            # code...
            array_push($data, array(
                'name'          =>  $row->name,
                'privilege'     =>  $row->role,
            ));

        }
        return $data;
    }

    function mesEmprunt($id_user, $table)
    {
        $credits = DB::table($table)->where('id_user', '=', $id_user)->get();
        $data = [];
        foreach ($credits as $row) {
            # code...
            array_push($data, array(
                'jour'          =>  $row->datejour,
                'montant'       =>  $row->montant,
                'created_at'    =>  $row->created_at,
                'connected'     =>  $this->UsersActionConnected($row->connected)                
            ));
        }
        return $data;
    }

    // voir la somme de contributions ou de remboursement par utilisateur
    function showSumMontantUser($table,$column, $valeur, $money)
    {
        $somme = DB::table($table)->where($column, '=', $valeur)->sum($table.'.'.$money);
        return $somme;
    }

    function showSumMontantTable($table, $money)
    {
        $somme = DB::table($table)->sum($table.'.'.$money);
        return $somme;
    }

    function showNumberDataTableUser($table, $column, $valeur)
    {
       $tests = DB::table($table)->where([
            [$column,     '=', $valeur]

        ])->get();
        $count = $tests->count();

        return  $count;
    }

    function showNumberDataTable($table)
    {
       $tests = DB::table($table)->get();
       $count = $tests->count();

      return  $count;
    }

    function showCount($id, $table)
    {
        $demandes = DB::table($table)->where([
            ['id', '=', $id],
            ['etat', '=', 1]
        ])->get();

        $count = $demandes->count();
        return $count;

    }

    function getAdminInfo($id)
    {
      $user=User::where('id',$id)->select('email','name','id_role')->first();
      if (!is_null($user)) {
        return $user;
      }
    }

    function getNomSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->nom;
        }
        return strtoupper($info);
    }

    function getTokenSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->token;
        }
        return strtoupper($info);
    }

    function getNumDevSite()
    {
        $data = DB::table('sites')
        ->select('id', 'nom', 'description', 'email','adresse','tel1','tel2','tel3','token', 'about','mission','objectif','politique','condition','logo','facebook','linkedin','twitter','youtube')->take(1)->get();
        $info='';
        foreach ($data as $row) {
            // code...
            $info = $row->tel3;
        }
        return strtoupper($info);
    }

    function displayImg($schema, $file)
    {
      //  $chemins="";

        $logo=base_path('public/'.$schema.'/'.$file);
        $f=file_get_contents($logo);
        $pic='data:image/png;base64,'.base64_encode($f);
        return $pic;
    }
  
    function displayImgDynamique($avatar)
    {
        $logo=base_path('public/storage/'.$avatar);
        $f=file_get_contents($logo);
        $pic='data:image/png;base64,'.base64_encode($f);
        return $pic;
    }  


    function chiffreEnLettre($a)
    {
        $convert = explode('.',$a);
        if (isset($convert[1]) && $convert[1]!=''){
        return $this->chiffreEnLettre($convert[0]).' Virgule '.'  '.$this->chiffreEnLettre($convert[1]).' Centimes' ;
        }
        if ($a<0) return 'moins '.$this->chiffreEnLettre(-$a);
        if ($a<17){
        switch ($a){
        case 0: return 'Zero';
        case 1: return 'Un';
        case 2: return 'Deux';
        case 3: return 'Trois';
        case 4: return 'Quatre';
        case 5: return 'Cinq';
        case 6: return 'Six';
        case 7: return 'Sept';
        case 8: return 'Huit';
        case 9: return 'Neuf';
        case 10: return 'Dix';
        case 11: return 'Onze';
        case 12: return 'Douze';
        case 13: return 'Treize';
        case 14: return 'Quatorze';
        case 15: return 'Quinze';
        case 16: return 'Seize';

        case 17: return 'Dix-sept';
        case 18: return 'Dix-huit';
        case 19: return 'Dix-neuf';

        }
        } else if ($a<20){
        return 'dix-'.$this->chiffreEnLettre($a-10);
        } else if ($a<100){
        if ($a%10==0){
        switch ($a){
        case 20: return 'Vingt';
        case 30: return 'Trente';
        case 40: return 'Quarante';
        case 50: return 'Cinquante';
        case 60: return 'Soixante';
        case 70: return 'Soixante-dix';
        case 80: return 'Quatre-vingt';
        case 90: return 'Quatre-vingt-dix';
        }
        } elseif (substr($a, -1)==1){
        if( ((int)($a/10)*10)<70 ){
        return $this->chiffreEnLettre((int)($a/10)*10).'-et-un';
        } elseif ($a==71) {
        return 'Soixante-et-onze';
        } elseif ($a==81) {
        return 'Quatre-vingt-un';
        } elseif ($a==91) {
        return 'Quatre-vingt-onze';
        }
        } elseif ($a<70){
        return $this->chiffreEnLettre($a-$a%10).'-'.$this->chiffreEnLettre($a%10);
        } elseif ($a<80){
        return $this->chiffreEnLettre(60).'-'.$this->chiffreEnLettre($a%20);
        } else{
        return $this->chiffreEnLettre(80).'-'.$this->chiffreEnLettre($a%20);
        }
        } else if ($a==100){
        return 'Cent';
        } else if ($a<200){
        return $this->chiffreEnLettre(100).' '.$this->chiffreEnLettre($a%100);
        } else if ($a<1000){
        return $this->chiffreEnLettre((int)($a/100)).' '.$this->chiffreEnLettre(100).' '.$this->chiffreEnLettre($a%100);
        } else if ($a==1000){
        return 'Mille';
        } else if ($a<2000){
        return $this->chiffreEnLettre(1000).' '.$this->chiffreEnLettre($a%1000).' ';
        } else if ($a<1000000){
        return $this->chiffreEnLettre((int)($a/1000)).' '.$this->chiffreEnLettre(1000).' '.$this->chiffreEnLettre($a%1000);
        }
        else if ($a==1000000){
        return 'Millions';
        }
        else if ($a<2000000){
        return $this->chiffreEnLettre(1000000).' '.$this->chiffreEnLettre($a%1000000).' ';
        }
        else if ($a<1000000000){
        return $this->chiffreEnLettre((int)($a/1000000)).' '.$this->chiffreEnLettre(1000000).' '.$this->chiffreEnLettre($a%1000000);
        }
    }




    function calculerCoutMoyen($articleIdStk, $date1, $date2) 
    {
        // Exécuter la requête pour obtenir le stock final et la valeur totale
        $result = DB::table('tvente_mouvement_stock')
            ->select(
                DB::raw('SUM(CASE WHEN type_mouvement = "Entree" THEN qteMvt * qteBase ELSE 0 END) as stock_final'),
                DB::raw('SUM(CASE WHEN type_mouvement = "Entree" THEN qteMvt * qteBase * (puMvt / qteBase) ELSE 0 END) as valeur_totale')
            )
            ->where([
                // ['tvente_mouvement_stock.dateMvt','>=', $date1],
                ['tvente_mouvement_stock.dateMvt','<=', $date2],
                ['tvente_mouvement_stock.idStockService','=', $articleIdStk],
                ['tvente_mouvement_stock.type_mouvement','=', 'Entree'],
            ])       
            ->first();

        // Initialiser les variables
        $coutMoyen = 0;
        $stockFinal = $result->stock_final ?? 0;
        $valeurTotale = $result->valeur_totale ?? 0;

        // Calculer le coût moyen si le stock final est supérieur à 0
        if ($stockFinal > 0) {
            $coutMoyen = round(floatval($valeurTotale) / floatval($stockFinal), 3);
            // $coutMoyen = $valeurTotale;
        }

        return $coutMoyen;
    }

    function calculerCoutGazMoyen($articleIdStk, $date1, $date2) 
    {
        // Exécuter la requête pour obtenir le stock final et la valeur totale
        $result = DB::table('tgaz_mouvement_stock_service_lot')
            ->select(
                DB::raw('SUM(CASE WHEN type_mouvement = "Entree" THEN qteMvt ELSE 0 END) as stock_final'),
                DB::raw('SUM(CASE WHEN type_mouvement = "Entree" THEN (qteMvt * puMvt) ELSE 0 END) as valeur_totale')
            )
            ->where([
                ['tgaz_mouvement_stock_service_lot.dateMvt','<=', $date2],
                ['tgaz_mouvement_stock_service_lot.idStockService','=', $articleIdStk],
                ['tgaz_mouvement_stock_service_lot.type_mouvement','=', 'Entree'],
            ])       
            ->first();

        // Initialiser les variables
        $coutMoyen = 0;
        $stockFinal = $result->stock_final ?? 0;
        $valeurTotale = $result->valeur_totale ?? 0;

        // Calculer le coût moyen si le stock final est supérieur à 0
        if ($stockFinal > 0) {
            $coutMoyen = round(floatval($valeurTotale) / floatval($stockFinal), 3);
            // $coutMoyen = $valeurTotale;
        }

        return $coutMoyen;
    }





}




?>