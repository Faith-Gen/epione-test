<?php

use App\Models\Book;
use App\Pipes\ChunkBooks;
use App\Pipes\MapBooks;
use App\Pipes\MineBooks;
use Illuminate\Database\Seeder;
use Illuminate\Pipeline\Pipeline;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app(Pipeline::class)
            ->send(fopen(storage_path('books.csv'), 'r'))
            ->through([
                MineBooks::class,
                MapBooks::class,
                ChunkBooks::class,
            ])->then(function ($books) {
                foreach ($books as $booksChunk) {
                    Book::insert($booksChunk);
                }
            });
    }
}
