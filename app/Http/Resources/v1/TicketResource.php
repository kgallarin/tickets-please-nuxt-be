<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
//    public static $wrap = 'ticket';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    $request->routeIs('api.v1.tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
            'relationships' => [
              'author' => [
                  'data' => [
                      'type' => 'user',
                      'id' => $this->user_id,
                  ],
                  'links' => [
                      'self' => route('api.v1.authors.show', $this->user_id),
                  ]
              ]
            ],
            // passing the reletionship data
            // 'includes' => [
            //     'author' => new UserResource($this->whenLoaded('author')),
            // ],

            // conditionally include user
            'includes' => new UserResource($this->whenLoaded('author')),
            'links' => [
                'self' => route('api.v1.tickets.show', $this->id),
            ],
        ];
    }
}
