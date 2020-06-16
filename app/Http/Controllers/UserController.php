<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SaveRequest;
use App\Http\Resources\BookLog;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Models\Book;

class UserController extends Controller
{
    /**
     * Gets the user details.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Updates the name of the given user.
     *
     * @param User $user
     * @param SaveRequest $request
     * @return void
     */
    public function update(User $user, SaveRequest $request)
    {
        $user->update($request->validated());

        return new UserResource($user->fresh());
    }

    /**
     * Get user book logs.
     *
     * @param User $user
     * @return void
     */
    public function userBooks(User $user)
    {
        $this->authorize('view', $user);

        $books = $user->books()->latest();

        if (request()->has('due') && request('due'))
            $books->whereNull('returned_at');

        return BookLog::collection($books->paginate(50));
    }

    /**
     * Shows the details of a book borrowing.
     *
     * @param User $user
     * @param Book $book
     * @return void
     */
    public function showUserBook(User $user, Book $book)
    {
        $this->authorize('view', $user);

        $book = $user->books()->where('user_books.book_id', $book->id)->latest()->first();

        if ($book)
            return new BookLog($book);

        abort(403, 'This user doesnt have logs for that book!');
    }
}
