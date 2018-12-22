<?php

use App\DevelopmentStudio;
use App\User;
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
            [
                'id' => 2,
                'name' => 'Bethesda Softworks',
                'address' => '1370 Piccard Drive, Rockville',
                'description' => 'Bethesda (spółka ZeniMax Media) jest producentem i wydawcą interaktywnej rozrywki od trzech dekad. Została założona w 1986 roku przez Christophera Weavera w miejscowości Bethesda w stanie Maryland, a ich obecna siedziba mieści się w Rockville. Firma posiada długą historię w grach na PC i konsole. Bethesda jest najprawdopodobniej najbardziej znana z produkcji serii gier cRPG – The Elder Scrolls.',
                'website' => 'https://bethesdagamestudios.com',
                'email' => 'info@bethsoft.example.com',
                'commercial' => true,
                'owner_id' => 1,
                'specialization' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Edmund McMillen & Others',
                'address' => '1234 Some Rd, Santa Cruz',
                'description' => 'Edmund McMillen is an American video game designer and artist known for his Flash game visual style. His most notable works include 2010\'s side-scroller Super Meat Boy and 2011\'s roguelike game The Binding of Isaac and its remake.',
                'website' => 'bindingofisaac.com',
                'email' => 'mcmillen@example.com',
                'commercial' => true,
                'owner_id' => 2,
                'specialization' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
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
            [
                'game_id' => 2,
                'development_studio_id' => 2,
            ],
            [
                'game_id' => 3,
                'development_studio_id' => 2
            ]
        ]);
        DB::table('user_development_studio')->insert([
            [
                'user_id' => 1,
                'development_studio_id' => 1,
            ],
            [
                'user_id' => 2,
                'development_studio_id' => 2,
            ],
            [
                'user_id' => 1,
                'development_studio_id' => 2
            ],
            [
                'user_id' => 2,
                'development_studio_id' => 3
            ]
        ]);
    }
}
