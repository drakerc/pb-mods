<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModificationFilesSeeder extends Seeder
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
                'file_path' => 'modification_files/testzip.zip',
                'file_type' => 'application/zip',
                'file_size' => 11445,
                'downloads' => 0,
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 2,
                'file_path' => 'modification_files/testrar.rar',
                'file_type' => 'x-rar-compressed',
                'file_size' => 8640,
                'downloads' => 100,
                'availability' => 1,
                'uploader_id' => 1,
            ],
            [
                'id' => 3,
                'file_path' => 'modification_files/testpdf.pdf',
                'file_type' => 'application/pdf',
                'file_size' => 8718,
                'downloads' => 55,
                'availability' => 1,
                'uploader_id' => 1,
            ],
        ]);

        DB::table('file_modification')->insert([
            [
                'file_id' => 1,
                'modification_id' => 2,
                'title' => 'Wysoka rozdzielczość',
                'description' => 'Wersja samochodu wykonana w wysokiej rozdzielczości'
            ],
            [
                'file_id' => 2,
                'modification_id' => 3,
                'title' => 'Topory',
                'description' => 'Archiwum podmieniające tylko topory w grze.'
            ],
            [
                'file_id' => 3,
                'modification_id' => 3,
                'title' => 'Instrukcja',
                'description' => 'Jest to instrukcja instalacji modyfikacji'
            ],
        ]);
    }
}
