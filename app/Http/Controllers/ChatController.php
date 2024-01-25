<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request, User $user)
    {
        $conversations = Chat::with([
            'user' => function($query){
            $query->where('id',Auth::id());
        },
        'chatable' => function($query) use($user){
            $query->where('id',$user->id);
        }
        ])->get();

        return $conversations;

    }
}
