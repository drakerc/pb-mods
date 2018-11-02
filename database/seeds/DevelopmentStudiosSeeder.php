<?php

use Illuminate\Database\Seeder;

class DevelopmentStudiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('development_studios')->insert([
            [
                'id' => 1,
                'name' => 'Rockstar Games',
                'address' => '1 Rockstar Way, New York',
                'description' => 'Studio deweloperskie odpowiedzialne za największe produkcje, takie jak GTA czy Red Dead Redemption',
                'website' => 'https://rockstargames.com',
                'email' => 'admin@rockstargames.com',
                'commercial' => true,
                'owner_id' => 1,
                'specialization' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('modification_development_studio')->insert([
            [
                'modification_id' => 1,
                'development_studio_id' => 1,
            ],
        ]);
        DB::table('game_development_studio')->insert([
            [
                'game_id' => 1,
                'development_studio_id' => 1,
            ],
        ]);
        DB::table('user_development_studio')->insert([
            [
                'user_id' => 1,
                'development_studio_id' => 1,
            ],
        ]);
    }
}
