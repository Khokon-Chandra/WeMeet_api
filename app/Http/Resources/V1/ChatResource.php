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
            'id'      => $this->id,
            'message' => $this->message,
            'seen'    => $this->seen,
            'user_id' => $this->user_id,
            'date'    => $this->created_at->diffForHumans(),    
            
        ];
    }
}
