<?php

use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files')->insert([
            [
                'id' => 1,
                'file_path' => 'game/logo/1-gtasa.png',
                'file_type' => 'image/png',
                'file_size' => 13760,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'file_path' => 'game/logo/2-skyrim.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 3900,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'file_path' => 'game/logo/3-fallout3.jpg',
                'file_type' => 'image/jpg',
                'file_size' => 57901,
                'availability' => '1',
                'uploader_id' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
