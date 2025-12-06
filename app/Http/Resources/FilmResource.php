<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'release_year' => $this->release_year,
            'director' => $this->director,
            'poster_url' => $this->poster_url,
            'video_url' => $this->video_url,
            'rating' => $this->rating,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'genre' => new GenreResource($this->whenLoaded('genre')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}