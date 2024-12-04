<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $owner = new UserResource($this->owner);
        return [
            "id"=> $this->id,
            "unit_type"=> $this->unit_type,
            "name"=> $this->name,
            "area"=> $this->area,
            "address"=> $this->address,
            "rooms"=> $this->rooms,
            "bathrooms"=> $this->bathrooms,
            "is_finished"=> $this->is_finished,
            "images"=> $this->getMedia('images')->map(function($media) {
                return $media->getFullUrl();
            }),
            "contract"=> $this->getFirstMediaUrl('contract'),
            "owner"=> $owner,
        ];
    }
}
