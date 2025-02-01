<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\PrivateMessageSent;

use App\Traits\{GlobalMethod,Slug};
use DB;

class MessageController extends Controller
{
    use GlobalMethod, slug;
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

   
   
    public function privateMessages(User $user)
    {

        if(request()->has('file')){
            // $filename = request('file')->store('chat');

            $filename = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('storage'), $filename);

            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => $filename,
                'receiver_id' => $user->id
            ]);
        }else{
            $privateCommunication= Message::with('user')
            ->where(['user_id'=> auth()->id(), 'receiver_id'=> $user->id])
            ->orWhere(function($query) use($user){
                $query->where(['user_id' => $user->id, 'receiver_id' => auth()->id()]);
            })
            ->get();

            return $privateCommunication;

        }

        
        
    }

    public function sendMessage(Request $request)
    {


        if(request()->has('file')){
            // $filename = request('file')->store('chat');

            $filename = time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path('storage'), $filename);

            $message=Message::create([
                'user_id' => request()->user()->id,
                'image' => $filename,
                'receiver_id' => request('receiver')
            ]);
        }else{
            $message = auth()->user()->messages()->create(['message' => $request->message]);

        }


        broadcast(new MessageSent(auth()->user(),$message->load('user')))->toOthers();
        
        return response(['status'=>'Message sent successfully','message'=>$message]);

    }

    public function sendPrivateMessage(Request $request,User $user)
    {
        $input=$request->all();
        $input['receiver_id']=$user->id;
        $message=auth()->user()->messages()->create($input);

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();
        
        return response(['status'=>'Message private sent successfully','message'=>$message]);

    }

    
   
}
