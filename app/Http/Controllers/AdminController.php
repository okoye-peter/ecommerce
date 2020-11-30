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
        $user = auth()->user();
        $user->image = $user->image;
        return view('admin.home',compact('user'));
    }
    
    public function users()
    {
        $ids = Chat::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->pluck('user_id');
        $users = User::whereIn('id', $ids)->where('isadmin', 0)->with('image')->get();
        $unreadIds = Chat::select(\DB::raw('`user_id` as sender, count(`user_id`) as messages_count'))
        ->where(function($q){
            $q->where(function($q){
                $q->where('receiver_id', auth()->id())
                ->where('read_at', null);
            })->orWhere(function ($q) {
                $q->where('receiver_id', null)
                ->where('read_at', null);
            });
        })
        ->groupBy('user_id')
        ->whereBetween('created_at',[Carbon::today(), Carbon::tomorrow()])
        ->get();
        // dd($unreadIds);
        $users = $users->map(function($user) use ($unreadIds){
            $userUnread = $unreadIds->where('sender', $user->id)->first();
            $user->unread = $userUnread ? $userUnread->messages_count : 0;
            return $user;
        });
        return response()->json($users);
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