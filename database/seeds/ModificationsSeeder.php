<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modifications')->insert([
            [
                'id' => 1,
                'title' => 'BMW M5 E60',
                'description' => 'Modyfikacja dodaje sportowe BMW z 2015 roku',
                'development_status' => 3,
                'size' => 0,
                'version' => '2.0',
                'replaces' => 'Vincent',
                'game_id' => 1,
                'category_id' => 8
            ],
            [
                'id' => 2,
                'title' => 'Audi A6',
                'description' => 'Modyfikacja dodaje komfortowe Audi z 2012 roku',
                'development_status' => 3,
                'size' => 0,
                'version' => '1.0',
                'replaces' => 'Infernus',
                'game_id' => 1,
                'category_id' => 7
            ],
            [
                'id' => 3,
                'title' => 'Immersive Weapons',
                'description' => 'Modyfikacja dodaje ogromną ilość nowych broni z wielu różnych kategorii do świata gry',
                'development_status' => 3,
                'size' => 1,
                'version' => '1.5',
                'replaces' => 'Wszystkie bronie',
                'game_id' => 2,
                'category_id' => 2
            ],
        ]);
    }
}
