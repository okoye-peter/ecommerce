<?php 
namespace App\Http\Controllers;

use App\Chat;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\AdminMessageEvent;


class AdminController extends Controller{
    public function __construct()
    {
        $this->middleware('isadmin');
    }
    
    public function page(){
        return view('admin');
    }
    
    public function users(){
        return User::where('isadmin', 0)->with('image')->get();
    }


    public function getUserConversation(Request $request)
    {
        $chats = Chat::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
        ->where(function($q) use ($request){
            $q->where(function($query) use ($request){
                $query->where('user_id', $request->id)->where('receiver_id', auth()->id());
            })
            ->orWhere(function($query) use ($request){
                $query->where('user_id', auth()->id())->where('receiver_id', $request->id);
            })
            ->orWhere(function ($q) use ($request) {
                $q->where('user_id', $request->id)->where('receiver_id', null)->where('read_at', null);
            });
        })
        ->with('user')->get();
        return response()->json($chats);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|integer|numeric',
        ]);
        $message = auth()->user()->chats()->create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id
        ]);
        broadcast(new AdminMessageEvent($message->load('user'), $request->receiver_id));
        return response()->json(['status' => 'success']);
    }
}
