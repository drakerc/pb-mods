<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModificationRatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modification_ratings')->insert([
            [
                'id' => 1,
                'title' => 'Świetna, ekscytująca modyfikacja',
                'modification_id' => 2,
                'rating' => 5,
                'rating_usability' => 5,
                'rating_quality' => 5,
                'rating_fun' => 5,
                'description' => 'Najlepsza modyfikacja w jaką grałem!',
                'author_id' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Dosyć fajna modyfikacja',
                'modification_id' => 3,
                'rating' => 4,
                'rating_usability' => 5,
                'rating_quality' => 4,
                'rating_fun' => 4,
                'description' => 'Bardzo podobała mi się ta modyfikacja, aczkolwiek jakość tekstur była niska.',
                'author_id' => 1,
            ],
            [
                'id' => 3,
                'title' => 'Nie ma sensu tego pobierać!',
                'modification_id' => 2,
                'rating' => 1,
                'rating_usability' => 1,
                'rating_quality' => 1,
                'rating_fun' => 1,
                'description' => 'Nie psuj sobie gry pobierając to coś. Szkoda tracić czasu!',
                'author_id' => 2,
            ],
        ]);
    }
}
