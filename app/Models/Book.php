<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
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
}
