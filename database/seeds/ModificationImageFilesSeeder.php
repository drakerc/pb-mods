<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModificationImageFilesSeeder extends Seeder
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
                'id' => 4,
                'file_path' => 'modification_files/testimage1.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 133176,
                'downloads' => 0,
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 5,
                'file_path' => 'modification_files/testimage2.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 151258,
                'downloads' => 0,
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 6,
                'file_path' => 'modification_files/testimage3.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 216354,
                'downloads' => 0,
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 7,
                'file_path' => 'modification_files/testimage4.jpeg',
                'file_type' => 'image/jpeg',
                'file_size' => 108634,
                'downloads' => 0,
                'availability' => 1,
                'uploader_id' => 1,
            ],
        ]);

        DB::table('image_file_modification')->insert([
            [
                'file_id' => 4,
                'modification_id' => 3,
                'type' => 1,
            ],
            [
                'file_id' => 5,
                'modification_id' => 3,
                'type' => 2,
            ],
            [
                'file_id' => 6,
                'modification_id' => 3,
                'type' => 3,
            ],
            [
                'file_id' => 7,
                'modification_id' => 3,
                'type' => 3,
            ],
        ]);
    }
}
