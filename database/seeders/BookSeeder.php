<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class Bookseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->delete();
        $json = File::get('database/data/books.json');
        $data = json_decode($json);

        foreach ($data as $obj) {
            $description = $obj->title;
            if (isset($obj->shortDescription))
                $description = $obj->shortDescription;
            if (isset($obj->longDescription))
                $description = $obj->longDescription;

            Book::create(array(
                'title' => $obj->title,
                'description' => $description
            ));
        }
    }
}
