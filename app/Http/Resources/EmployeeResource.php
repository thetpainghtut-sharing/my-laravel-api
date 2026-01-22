<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employeeId' => $this->eid, // Renaming 'name' to 'title' for frontend if needed
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'phoneNo' => $this->phone,
            'profile' => $this->profile ? asset('storage/' . $this->profile): null,
            'department' => $this->department,
            'createdAgo' => $this->created_at->diffForHumans(),
        ];
    }
}
