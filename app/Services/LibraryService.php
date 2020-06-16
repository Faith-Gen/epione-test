<?php

namespace App\Services;

use App\Http\Resources\BookLog;
use App\Models\Book;
use App\User;

class LibraryService
{
    public function checkout(User $user, Book $book)
    {
        if (!$book->is_available)
            abort(403, 'The book you want is not available at the moment.');

        $user->books()->attach($book, [
            'due_at' => request('due_date')
        ]);

        $book = $book->fresh();

        return new BookLog($book);
    }
}
