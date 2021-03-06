<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relates this user to many books.
     *
     * @return BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_books')
            ->withTimestamps()
            ->withPivot(['due_at', 'returned_at']);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Title case names on select queries.
     *
     * @param [type] $name
     * @return void
     */
    public function getNameAttribute($name)
    {
        return Str::title($name);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (request() && request()->has('password'))
                $user->password = Hash::make(request('password'));
        });
    }
}
