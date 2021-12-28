<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'active']);
    }

    /**
     * Show the chat page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index() {
        $menu = 'chat';
        $submenu = '';
        $role = Auth::user()->role();
        $myId = Auth::user()->id;

        if($role == 'client') {
            $users = User::join('projects', 'users.id', '=', 'projects.seller_id')
                ->where('projects.user_id', $myId)
                ->whereIn('projects.status', ['pending', 'accepted'])
                ->orderBy('projects.created_at', 'desc')
                ->groupBy('users.id')
                ->select('users.*')
                ->get();
        }
        if($role == 'copywriter'){
            $users = User::join('projects', 'users.id', '=', 'projects.user_id')
                ->where('projects.seller_id', $myId)
                ->whereIn('projects.status', ['pending', 'accepted'])
                ->orderBy('projects.created_at', 'desc')
                ->distinct('users.id')
                ->groupBy('users.id')
                ->select('users.*')
                ->get();
        }

        return view('chat.index', compact('menu', 'submenu', 'users'));
    }

    /**
     * Get Latest Chatting History by UserId
     *
     * @method: POST
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chat_get_latest(Request $request) {
        $uid = $request->get('uid');
        $me = Auth::user();
        $myId = $me->id;
        $messages = Message::where(function ($query) use ($me, $uid) {
            $query->where('sender_id', $me->id)->where('receiver_id', $uid);
        })->orWhere(function ($query) use ($me, $uid) {
            $query->where('sender_id', $uid)->where('receiver_id', $me->id);
        })->orderBy('created_at', 'desc')->take(10)->get();
        return view('chat.components.messages', compact('messages', 'myId'));
    }

    /**
     * Save New Message
     *
     * @method POST
     * @param Request $request
     */
    public function chat_send(Request $request) {
        $text = $request->get('text');
        $uid = $request->get('uid');
        $me = Auth::user();
        $myId = $me->id;
        $message = new Message;
        $message->sender_id = $me->id;
        $message->receiver_id = $uid;
        $message->text = $text;
        $message->save();
        return view('chat.components.onemessage', compact('message', 'myId'));
    }
}
