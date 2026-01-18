<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'salary' => [
                'min' => $this->salary_min,
                'max' => $this->salary_max,
            ],
            'company' => new CompanyResource($this->whenLoaded('company')),
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}