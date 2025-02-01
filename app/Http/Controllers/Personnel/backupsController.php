<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class backupsController extends Controller
{
    use GlobalMethod;
    use Slug;


    public function downloadBackup()
    {
        $filePath = 'backups/caritas_db.sql'; // Replace with your actual backup file name

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return response()->json(['message' => 'File not found.'], 404);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



}
