<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ApplicationResource extends JsonResource
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
            'job' => new JobResource($this->whenLoaded('jobs')),
            'user_id' => [
                'id' => $this->user_id,
                'name' => $this->user->name
            ],
            'resume_path' => $this->resume_path ? asset('storage/' . $this->resume_path) : null,
            'cover_letter' => $this->cover_letter,
            'status' => $this->status,
            'applied_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
