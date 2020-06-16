<?php

use Illuminate\Database\Seeder;
use Illuminate\Pipeline\Pipeline;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = app(Pipeline::class);
    }
}
