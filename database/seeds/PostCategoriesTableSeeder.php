<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_categories')->insert([
            ['name' => 'Poprawki'],
            ['name' => 'Aktualizacje'],
            ['name' => 'Poradniki'],
            ['name' => 'Inne']
        ]);
    }
}
