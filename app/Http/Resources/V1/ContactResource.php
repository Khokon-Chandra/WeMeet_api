<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'active'            => true,
            'last_message'      => $this->chat?->message,
            'last_message_at'   => Carbon::parse($this->created_at)->format('h:i'),
            'count_unseen'      => $this->chats_count,
            'avatar'            => "https://static.thenounproject.com/png/363640-200.png",
        ];
    }
}
