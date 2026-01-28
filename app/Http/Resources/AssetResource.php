<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serialNo' => $this->serial_no, // Renaming 
            'name' => $this->name,
            'condition' => $this->status,
            'photo' => $this->image ? asset('storage/' . $this->image): null,
            'category' => new CategoryResource($this->category),
            'createdAgo' => $this->created_at->diffForHumans(),
        ];
    }
}
