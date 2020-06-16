<?php

namespace App\Pipes;

class MineBooks
{
    public function handle($booksRawData, \Closure $next)
    {
        $books = [];

        while (!feof($booksRawData)) {
            array_push($books, fgetcsv($booksRawData));
        }

        $data = collect($books)
            ->reject(function ($book, $key) {
                return $key == 0 || empty($book);
            });

        return $next($data);
    }
}
