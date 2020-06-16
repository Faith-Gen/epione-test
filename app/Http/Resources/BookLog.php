<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class BookLog extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userBook = $this->users()->latest()->first()->pivot;

        return [
            'book' => new Book($this),
            'due_at' => Carbon::parse($userBook->due_at)
                ->toDateTime(),
            'returned_at' => $userBook->returned_at ? Carbon::parse($userBook->returned_at)->toDateTime() : null
        ];
    }
}
