<?php

namespace App\Pipes;

use Closure;
use Illuminate\Support\Collection;

class ChunkBooks
{
    public function handle(Collection $books, Closure $next)
    {
        return $next($books->chunk(500)->toArray());
    }
}
