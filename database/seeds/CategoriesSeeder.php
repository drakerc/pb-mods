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
            ['id' => 1, 'created_at' => now(), 'title' => 'Nowe pojazdy', 'description' => 'Nowe pojazdy, którymi może poruszać się CJ', 'parent' => null, 'game_category' => false, 'game' => 1, 'active' => true],
            ['id' => 2, 'created_at' => now(), 'title' => 'Nowe bronie', 'description' => 'Nowe bronie do użytku w Skyrimie', 'parent' => null, 'game_category' => false, 'game' => 2, 'active' => true],
            ['id' => 3, 'created_at' => now(), 'title' => 'Nowe zbroje', 'description' => 'Zbroje Vault-Tec do Fallouta', 'parent' => null, 'game_category' => false, 'game' => 3, 'active' => true],
            ['id' => 4, 'created_at' => now(), 'title' => 'Nowe mapy', 'description' => 'Przeróbki świata Skyrim', 'parent' => null, 'game_category' => false, 'game' => 2, 'active' => true],

        ]);
        // Additional mods categories
        DB::table('categories')->insert([
            ['id' => 5, 'created_at' => now(), 'title' => 'Samochody osobowe', 'description' => 'Nowe osobówki, którymi może poruszać się CJ', 'parent' => 1, 'game_category' => false, 'active' => true],
            ['id' => 6, 'created_at' => now(), 'title' => 'Samochody ciężarowe', 'description' => 'Nowe ciężarówki, którymi może poruszać się CJ', 'parent' => 1, 'game_category' => false, 'active' => true],
        ]);
        // Additional mods categories without descriptions
        DB::table('categories')->insert([
            ['id' => 7, 'created_at' => now(), 'title' => 'Audi', 'parent' => 5, 'game_category' => false, 'active' => true],
            ['id' => 8, 'created_at' => now(), 'title' => 'BMW', 'parent' => 5, 'game_category' => false, 'active' => true],
            ['id' => 9, 'created_at' => now(), 'title' => 'Scania', 'parent' => 6, 'game_category' => false, 'active' => true],
        ]);

        // Mods categories that are not active
        DB::table('categories')->insert([
            ['title' => 'Fałszywa kategoria użytkownika', 'created_at' => now(), 'parent' => 6, 'game_category' => false, 'active' => false],
        ]);
        // Game categories
        DB::table('categories')->insert([
            [
                'id' => 11,
                'title' => 'FPS',
                'description' => 'First Person Shooter',
                'game_category' => true,
                'active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'title' => 'RPG',
                'description' => 'Role Playing Game',
                'game_category' => true,
                'active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 13,
                'title' => 'Action',
                'description' => 'Action',
                'game_category' => true,
                'active' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
