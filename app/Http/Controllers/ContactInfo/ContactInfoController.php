<?php

namespace App\Http\Controllers\ContactInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactInfo\{ContactInfo};
use App\Traits\GlobalMethod;
use DB;

class ContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        //
        $data = DB::table("contact_infos")
        ->select("contact_infos.id", "contact_infos.name","contact_infos.email","contact_infos.telephone","contact_infos.subject","contact_infos.message", "contact_infos.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('contact_infos.name', 'like', '%'.$query.'%')
            ->orWhere('contact_infos.email', 'like', '%'.$query.'%')
            ->orWhere('contact_infos.telephone', 'like', '%'.$query.'%')
            ->orWhere('contact_infos.message', 'like', '%'.$query.'%')
            ->orderBy("contact_infos.id", "desc");

            return $this->apiData($data->paginate(4));
           

        }

        $data->orderBy("contact_infos.id", "desc");
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
            $data = ContactInfo::where("id", $request->id)->update([
                'name'      =>  $request->name,
                'email'     =>  $request->email,
                'telephone' =>  $request->telephone,
                'subject'   =>  $request->subject,
                'message'   =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = ContactInfo::create([
                'name'      =>  $request->name,
                'email'     =>  $request->email,
                'telephone' =>  $request->telephone,
                'subject'   =>  $request->subject,
                'message'   =>  $request->message
            ]);
            return response()->json(['data'  =>  "Nous vous répondrons dans un instant!!!"]);
         

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
        $data = ContactInfo::where('id', $id)->get();
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
        $data = ContactInfo::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }


}
