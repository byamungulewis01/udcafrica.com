<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category->name,
            'location' => $this->location,
            'year' => $this->year_of_completion,
            'size' => $this->size,
            'client' => $this->client,
            'content' => $this->content,
            'shortDescription' => $this->description,
            'architect' => $this->architect,
            'featured' => $this->is_featured,
            'coverImage' => $this->featured_image,
            'gallery' => $this->gallery,
        ];
    }
}
