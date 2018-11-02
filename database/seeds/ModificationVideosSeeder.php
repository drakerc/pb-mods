<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModificationVideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modification_videos')->insert([
            [
                'id' => 1,
                'title' => 'Inauguracja roku akademickiego na Politechnice Białostockiej',
                'modification_id' => 2,
                'url' => 'https://www.youtube.com/watch?v=JsaSUiswXCw',
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 2,
                'title' => 'Politechnika Białostocka - Oficjalny spot promocyjny (2014)',
                'modification_id' => 2,
                'url' => 'https://www.youtube.com/watch?v=iHikK_mU20c',
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 3,
                'title' => 'Politechnika Białostocka - Bialystok University of Technology (BUT)',
                'modification_id' => 3,
                'url' => 'https://www.youtube.com/watch?v=ypSodkZALoA',
                'availability' => 1,
                'uploader_id' => 1,
            ],
        ]);
    }
}
