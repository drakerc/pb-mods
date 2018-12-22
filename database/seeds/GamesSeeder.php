<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Game-related files
        DB::table('files')->insert([
            [
                'id' => 8,
                'file_path' => 'game/logo/1-gtasa.jpg',
                'file_type' => 'image/jpg',
                'file_size' => 13760,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 9,
                'file_path' => 'game/logo/2-skyrim.jpg',
                'file_type' => 'image/jpg',
                'file_size' => 3900,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 10,
                'file_path' => 'game/logo/3-fallout3.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 57901,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 11,
                'file_path' => 'game/files/3-screen1.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 57901,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 12,
                'file_path' => 'game/files/3-screen2.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 57901,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 13,
                'file_path' => 'game/files/3-screen3.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 57901,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 14,
                'file_path' => 'game/background/2-skyrimbg.png',
                'file_type' => 'image/png',
                'file_size' => 2594489,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 15,
                'file_path' => 'game/background/3-falloutbg.jpg',
                'file_type' => 'image/jpg',
                'file_size' => 470609,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        // Games
        DB::table('games')->insert([
            [
                'id' => 1,
                'created_at'=> Carbon::now()->subHour(),
                'updated_at' => Carbon::now(),
                'title' => 'GTA San Andreas',
                'description' => "Kolejna odsłona jednej z najpopularniejszych i najbardziej kontrowersyjnych gier wszech czasów, w której gracz ma okazję wcielić się w drobnego rzezimieszka, a następnie tworząc własny, kryminalny życiorys samemu stanąć na czele mafii. Tym razem, przychodzi nam wcielić się w niejakiego Carla Johnsona, który przed kilku laty uciekł z rodzinnego miasta w poszukiwaniu lepszego jutra. Po pięciu latach Carl wraca do Los Santos, w którym zastaje gangsterski świat morderstw, narkotyków i korupcji. Jednak nieciekawy krajobraz miasta to nie koniec złych wiadomości; dzielnica w której się wychował wygląda gorzej, niż pamiętał ją sprzed pięciu lat, a skłócona rodzina opłakuje zamordowaną matkę Carla. Na koniec złego, skorumpowani policjanci wrabiają naszego bohatera w morderstwo. Witaj w kalifornijskich latach 90-tych.",
                'logo_id' => 8,
                'background_id' => null,
                'variant' => 'default'
            ],
            [
                'id' => 2,
                'created_at'=> Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now(),
                'title' => 'The Elder Scrolls V Skyrim',
                'description' => "The Elder Scrolls V: Skyrim to kolejna część serii cRPG autorstwa zespołu Bethesda Softworks. Ponownie odwiedzamy w niej kontynent Tamriel, a fabuła tym razem obraca się wokół powrotu do tej krainy pradawnej rasy smoków.",
                'logo_id' => 9,
                'background_id' => 14,
                'variant' => 'dark'
            ],
            [
                'id' => 3,
                'created_at'=> Carbon::now(),
                'updated_at' => Carbon::now(),
                'title' => 'Fallout 3',
                'description' => "Fallout 3 to kolejna odsłona kultowej serii z gatunku cRPG, zapoczątkowanej w 1997 roku. Opracowaniem niniejszej części cyklu zajęli się twórcy gry The Elder Scrolls IV: Oblivion, wykorzystując jej ulepszony silnik. Aczkolwiek przykładowo system animacji i efektów świetlnych zaprojektowano od podstaw.",
                'logo_id' => 10,
                'background_id' => 15,
                'variant' => 'secondary'
            ],
        ]);

        // Game -> file pivot
        DB::table('file_game')->insert([
            [
                'game_id' => '3',
                'file_id' => 11
            ],
            [
                'game_id' => '3',
                'file_id' => 12
            ],
            [
                'game_id' => '3',
                'file_id' => 13
            ]
        ]);

        // Game -> video table
        DB::table('game_videos')->insert([
            'title' => 'Fallout 3 #1',
            'game_id' => 3,
            'url' => "https://www.youtube.com/watch?v=iYZpR51XgW0"
        ]);
    }
}
