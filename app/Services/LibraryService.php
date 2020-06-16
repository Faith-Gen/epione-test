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

    public function return(User $user, Book $book)
    {
        if ($book->is_available)
            abort(403, 'The book is already in the library');

        $updated = $user->books()->updateExistingPivot($book->id, [
            'returned_at' => now()
        ]);

        if ($updated)
            return new BookLog($book->refresh());

        abort(500, 'Failed to mark the book returned');
    }
}
