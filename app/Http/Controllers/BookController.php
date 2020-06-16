<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CheckoutRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Book as BooksResource;
use App\Services\LibraryService;

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

    /**
     * Shows the book details.
     *
     * @param Book $book
     * @return void
     */
    public function show(Book $book)
    {
        return new BooksResource($book);
    }

    public function checkout(Book $book, CheckoutRequest $request, LibraryService $service)
    {
        return $service->checkout(auth()->user(), $book);
    }
}
