<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'chatable_id' => $this->chatable_id,
            'message'     => $this->message,
            'seen'        => $this->seen,
            'date'        => $this->created_at->diffForHumans(),   
            'avatar'      => "https://static.thenounproject.com/png/363640-200.png", 
            
        ];
    }
}
