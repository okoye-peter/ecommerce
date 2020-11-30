<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function fetchChats()
    {
        return response()->json(Chat::whereBetween('created_at',[Carbon::today(), Carbon::tomorrow()])->where(function($query){
            $query->where('user_id', auth()->user()->id)->orwhere('receiver_id', auth()->user()->id);
        })->with('user')->get());
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);
        
        $message = auth()->user()->chats()->create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id
        ]);
        broadcast(new MessageEvent($message->load('user')))->toOthers();
        return ['status' => 'success'];
    }

    public function updateReadMessages($id)
    {
        if (auth()->user()->isadmin == 1) {
            Chat::where('user_id', $id)->whereNull('read_at')->update(['read_at' => now(), 'receiver_id' => auth()->id()]);
        }else{
            Chat::where('receiver_id', $id)->whereNull('read_at')->update(['read_at' => now()]);
        }
    }
    
}
