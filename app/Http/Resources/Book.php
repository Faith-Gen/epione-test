<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

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
        $isIndex = Str::contains(Route::currentRouteName(), 'index');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'thumbnail' => $this->thumbnail,
            'average_rating' => $this->average_rating,
            'available' => $this->is_available,
            $this->mergeWhen(!$isIndex, [
                'language_code' => $this->language_code,                
                'image' => $this->image,                
                'original_title' => $this->original_title,                
            ])
        ];
    }
}
