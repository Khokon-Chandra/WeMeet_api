<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\ChatResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request, User $user): AnonymousResourceCollection
    {
        $conversations = Chat::whereIn('id', [Auth::id(), $user->id])
            ->latest()
            ->when($request->offset ?? false, function ($query, $offset) {
                $query->offset($offset);
            })
            ->limit(20)

            ->get();

        return ChatResource::collection($conversations);
    }
}
