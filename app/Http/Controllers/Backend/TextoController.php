<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Backend\{Texto};
use App\Traits\{GlobalMethod,Slug};
use DB;

class TextoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        $data = DB::table("textos")
        ->select("textos.id", "textos.phone","textos.message","textos.etat", "textos.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('textos.phone', 'like', '%'.$query.'%')
            ->orWhere('textos.message', 'like', '%'.$query.'%')
            ->orderBy("textos.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }
        $data->orderBy("textos.id", "desc");
        return $this->apiData($data->paginate(4));
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
            $data = Texto::where("id", $request->id)->update([
                'phone'     =>  $request->phone,
                'message'   =>  $request->message,
                'etat'      =>  0,
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $phones = $request->phone;
            foreach ($phones as $tel) {
                // code...
                $num_dev    = $this->getNumDevSite();
                $token_sms  = $this->getTokenSite();

                $message = $request->message;
                // echo("tél:".$tel." message:".$message." num_dev:".$num_dev."  token:".$token_sms);

                $etat = $this->envoieSMS($tel, $message, $num_dev, $token_sms);

                if ($etat == true) {
                    # code...
                    $data = Texto::create([
                        'phone'     =>  $tel,
                        'message'   =>  $request->message,
                        'etat'      =>  1,
                    ]);

                    return $this->msgJson("📞 ".$tel." envoyé avec succès 🆗");

                }
                else{

                    $data = Texto::create([
                        'phone'     =>  $tel,
                        'message'   =>  $request->message,
                        'etat'      =>  0,
                    ]);

                    return $this->msgJson('Echec lors de l\'envoie!!!');
                }
                



            }
           

            
        }
    }

    function envoieSMS($tel, $message, $num_dev,$token)
    {
        $etat = false;
        try {
            //form's fields name:
            $value = '{
                "outboundSMSMessageRequest":{
                    "address": "tel:' . $tel . '", 
                    "senderAddress":"tel:'.$num_dev.'", 
                    "outboundSMSTextMessage":{ 
                        "message": "' .$message. '" 
                    } 
                }
            }';
            //API url:
            $url = 'https://api.orange.com/smsmessaging/v1/outbound/tel:'.$num_dev.'/requests';
           
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/json\r\n" .
                        "Authorization:Bearer ".$token."\r\n",
                    'method'  => 'POST',
                    'content' => $value
                )
            );
            //engine:
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $etat = false;
            if ($result === FALSE) { /* Handle error */
                $etat = false;
            } else {
                $etat = true;

            }

            // echo "resultat est: ".$result;

           return $etat;

            
        } catch (Exception $e) {
            echo "impossible de faire l'envoie des sms: ".$e->getMessage();
        }



        
        
    }








    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function checkEtat_texto($id,$phone, $etat)
    {
        if ($id !='' && $phone !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Texto::where('id',$id)->update([
                    'etat'         =>  0
                ]);
                return $this->msgJson('Sms a été desactivée avec succès');

            } else {
                // activation
                Texto::where('id',$id)->update([
                    'etat'         =>  1
                ]);
                return $this->msgJson('Sms a été activée avec succès');
            }
            
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
        $data = Texto::where('id', $id)->get();
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
        $data = Texto::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
