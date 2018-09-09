<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main mods categories
        DB::table('categories')->insert([
            ['id' => 1, 'title' => 'Nowe pojazdy', 'description' => 'Nowe pojazdy, którymi może poruszać się CJ', 'parent' => null, 'game_category' => false, 'game' => 1],
            ['id' => 2, 'title' => 'Nowe bronie', 'description' => 'Nowe bronie do użytku w Skyrimie', 'parent' => null, 'game_category' => false, 'game' => 2],
            ['id' => 3, 'title' => 'Nowe zbroje', 'description' => 'Zbroje Vault-Tec do Fallouta', 'parent' => null, 'game_category' => false, 'game' => 3],
            ['id' => 4, 'title' => 'Nowe mapy', 'description' => 'Przeróbki świata Skyrim', 'parent' => null, 'game_category' => false, 'game' => 2],

        ]);
        // Additional mods categories
        DB::table('categories')->insert([
            ['id' => 5, 'title' => 'Samochody osobowe', 'description' => 'Nowe osobówki, którymi może poruszać się CJ', 'parent' => 1, 'game_category' => false],
            ['id' => 6, 'title' => 'Samochody ciężarowe', 'description' => 'Nowe ciężarówki, którymi może poruszać się CJ', 'parent' => 1, 'game_category' => false],
        ]);
        // Additional mods categories without descriptions
        DB::table('categories')->insert([
            ['id' => 7, 'title' => 'Audi', 'parent' => 5, 'game_category' => false],
            ['id' => 8, 'title' => 'BMW', 'parent' => 5, 'game_category' => false],
            ['id' => 9, 'title' => 'Scania', 'parent' => 6, 'game_category' => false],
        ]);
    }
}
