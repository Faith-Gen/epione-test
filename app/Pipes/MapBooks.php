<?php

namespace App\Pipes;

use Closure;
use Illuminate\Support\Collection;

class MapBooks
{
    public function handle(Collection $books, Closure $next)
    {
        $books = $books->map(function ($book) {
            try {
                return [
                    'id' => (int) $book[0],
                    'title' => $book[10],
                    'original_title' => $book[9],
                    'publication_year' => (int) $book[8],
                    'isbn' => $book[5],
                    'language_code' => $book[11],
                    'image' => $book[21],
                    'thumbnail' => $book[22],
                    'average_rating' => $book[12],
                    'total_ratings' => $book[13],
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            } catch (\Exception $e) {
                return [];
            }
        })->reject(function($book){
            return empty($book);
        });

        return $next($books);
    }
}
