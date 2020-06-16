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
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Book $book)
    {
        return new BooksResource($book);
    }

    /**
     * Checks out a book from the library.
     *
     * @param Book $book
     * @param CheckoutRequest $request
     * @param LibraryService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Book $book, CheckoutRequest $request, LibraryService $service)
    {
        return $service->checkout(auth()->user(), $book);
    }

    /**
     * Returns a book into the library.
     *
     * @param Book $book
     * @param LibraryService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function return(Book $book, LibraryService $service)
    {
        return $service->return(auth()->user(), $book);
    }
}
