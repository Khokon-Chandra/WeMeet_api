<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\ChatResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\SendMessage;
use App\Http\Resources\V1\ContactResource;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class ChatController extends Controller
{
    public function index(Request $request, User $user): AnonymousResourceCollection
    {
        // updated unseen messages
        Chat::where('user_id', Auth::id())
            ->where('chatable_id', $user->id)
            ->where('seen', false)
            ->update(['seen'=>true]);

        // messages data
        $conversations = Chat::where(function($query) use($user){
            $query->where('user_id',Auth::id())
                    ->where('chatable_id',$user->id);
        })

        ->OrWhere(function($query) use($user){
            $query->where('chatable_id',Auth::id())
                    ->where('user_id',$user->id);
        })

        ->when($request->offset ?? false, function ($query, $offset) {
            $query->offset($offset);
        })
        ->limit(20)->latest()->get();

        return ChatResource::collection($conversations);
    }


    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $chat = new Chat([
                'user_id' => Auth::id(),
                'message' => $request->message,
            ]);

            $user->chats()->save($chat);

            SendMessage::dispatch($chat);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'successfully message sent',
                'chat'    => new ChatResource($chat)
            ], 200);
        } catch (\Exception $error) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
    }
    public function contacts() : AnonymousResourceCollection
    {
        try{
            $contacts = User::with([
                'chat' => function($q){
                    return $q->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
                }])
                ->withCount(['chats' => function($q){
                    return $q->where('user_id', Auth::user()->id)->where('seen', false);
                }])
                ->where('id', '!=', Auth::user()->id)->get();
            return ContactResource::collection($contacts);
        }catch(Throwable $th){
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
