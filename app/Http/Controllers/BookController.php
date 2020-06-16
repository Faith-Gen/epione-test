<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BooksResource;

class BookController extends Controller
{
    /**
     * Lists/searches books.
     *
     * @return void
     */
    public function index()
    {
        $books = Book::query();

        if (request()->has('search'))
            $books->where('title', 'LIKE', '%' . request('search') . '%');

        $books = $books->paginate(50);

        return BooksResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BooksResource($book);
    }
}
