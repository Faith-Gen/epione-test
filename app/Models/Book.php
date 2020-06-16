<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relates this book to many users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_books')
            ->withTimestamps()
            ->withPivot(['due_at', 'returned_at']);
    }

    /**
     * Checks if a book is available or not.
     *
     * @return boolean
     */
    public function getIsAvailableAttribute(): bool
    {
        $checkedOutBooks = $this->users()->whereNull('user_books.returned_at')->count();

        if ($checkedOutBooks) return false;

        return true;
    }
}
