<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Book extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'thumbnail' => $this->thumbnail,
            'average_rating' => $this->average_rating,
            'available' => $this->is_available,
        ];
    }
}
