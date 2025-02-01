<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_presences_agent;
use App\Models\Personnel\tperso_presences_temp;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use Shuchkin\SimpleXLSX;
use App\User;
use App\Traits\{GlobalMethod,Slug};
use Carbon\Carbon;
use DB;

class SimpleExcelController extends Controller
{
    //
    use GlobalMethod;

    // Exporter les données
    public function export (Request $request) {

    	// 1. Validation des informations du formulaire
    	// $this->validate($request, [ 
    	// 	'name' => 'bail|required|string',
    	// 	'extension' => 'bail|required|string|in:xlsx,csv'
    	// ]);

    	// 2. Le nom du fichier avec l'extension : .xlsx ou .csv
    	// $file_name = $request->name.".".$request->extension;
        $file_name = "FichierUser.xlsx";

    	// 3. On récupère données de la table "clients"
    	$clients = User::select("*")->get();

		// return response()->json([
		// 	'data'  => $clients,
		// ]);

    	// 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
    	$writer = SimpleExcelWriter::streamDownload($file_name);

 		// 5. On insère toutes les lignes au fichier Excel $file_name
    	$writer->addRows($clients->toArray());

        // 6. Lancer le téléchargement du fichier
        $writer->toBrowser();

    }



	function import(Request $request)
    {
		$formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('/fichier'), $imageName);
		$date_file=null;


        if ($xlsx = SimpleXLSX::parse(public_path("fichier/{$imageName}"))) {
            foreach ($xlsx->rows() as $rowProperties) {

				$affectation_id = 0;

				$data3 =  DB::table('tperso_affectation_agent')
				->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
				->select('tperso_affectation_agent.id')
				->where([
				   ['tagent.matricule_agent','=', $rowProperties[0]]
				])    
				->get(); 		
				foreach ($data3 as $row) 
				{                               
					$affectation_id=$row->id;                          
				}

				$h1= $rowProperties[3].' '.$rowProperties[5];
				$h2= $rowProperties[3].' '.$rowProperties[6];
				$d1=$rowProperties[3];
				$date_file= $rowProperties[3];

				$data = tperso_presences_temp::create([
					'affectation_id'    =>  $affectation_id,
					'date_presence'    =>  $d1,
					'date_entree'    =>  $h1,
					'date_sortie'    =>  $h2,
					'author'       =>  'Admin',
				]);
            }				
				$affectations_id = 0;
				$date_presence = null;
				$date_entree = null;
				$date_sortie = null;
				//STR_TO_DATE(event_date, '%Y-%m-%d %H:%i:%s')
				$data4 =  DB::table('tperso_presences_temp')
				->select("tperso_presences_temp.id",'date_presence', 'affectation_id', 'date_entree','date_sortie','retard','justifications')
				->selectRaw("STR_TO_DATE(tperso_presences_temp.date_presence, '%Y-%m-%d') as jour_presence")
				->selectRaw("STR_TO_DATE(date_entree,'%Y-%m-%d %H:%i:%s') as heure_entree") 
				->selectRaw("STR_TO_DATE(date_sortie,'%Y-%m-%d %H:%i:%s') as heure_sortie") 
				->where([
					['tperso_presences_temp.affectation_id','!=', 0]
				 ])
				->get(); 		
				foreach ($data4 as $row) 
				{                               
					$affectations_id=$row->affectation_id;  
					$date_presence=$row->jour_presence;  
					$date_entree=$row->heure_entree;  
					$date_sortie=$row->heure_sortie;

					$datetest='';
					$data3 = DB::table('tperso_presences_agent')
					->select('tperso_presences_agent.date_presence')
					->where('tperso_presences_agent.date_presence','=', $date_presence)
					->take(1)
					->orderBy('id', 'desc')         
					->get();    
					foreach ($data3 as $row) 
					{                           
						$datetest=$row->date_presence;          
					}
		
					if($datetest == $date_presence)
					{
						// return response()->json([
						// 	'data'  =>  "Les presences pour cette date sont déjà importées !!!",
						// ]);            
					}
					else
					{
						$data5 = tperso_presences_agent::create([
							'affectation_id'    =>  $affectations_id,
							'date_presence'    =>  $date_presence,
							'date_entree'    =>  $date_entree,
							'date_sortie'    =>  $date_sortie,
							'author'       =>  'Admin',
						]);
					}
					
				}
				$data6 = tperso_presences_temp::where('id','>=',0)->delete();
	
				return $this->msgJson('Fichier importé avec succès');

			


        }
		else
		{
			return $this->msgJson('Selectionnez le fichier svp !!!!');
		}

		// return $this->msgJson('Selectionnez le fichier svp !!!!');

    }








    


}
