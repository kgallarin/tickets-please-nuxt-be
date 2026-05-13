<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,

            $this->mergeWhen($request->routeIs('authors.*'), [
                'emailVerifiedAt' => $this->email_verified_at->format('Y-m-d H:i:s'),
                'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
                'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            ]),

            'attributes' => [
                'email' => $this->email,
                'emailVerifiedAt' => $this->when(
                    $request->routeIs('authors.*'),
                    $this->email_verified_at->format('Y-m-d H:i:s')
                ),

                'updatedAt' => $this->when(
                    $request->routeIs('authors.*'),
                    $this->updated_at->format('Y-m-d H:i:s')
                ),

                'createdAt' => $this->when(
                    $request->routeIs('authors.*'),
                    $this->created_at->format('Y-m-d H:i:s')
                ),
            ],

            'includes' => TicketResource::collection($this->whenLoaded('tickets')),
            'links' => [
                'self' => route('api.v1.authors.show', $this->id),
            ]
        ];
    }
}
