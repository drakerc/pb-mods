<?php

use Illuminate\Database\Seeder;

class CategoryGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_game')->insert([
            [
                'game_id' => '1',
                'category_id' => '13',
                'created_at' => now()
            ],
            [
                'game_id' => '2',
                'category_id' => '12',
                'created_at' => now()
            ],
            [
                'game_id' => '3',
                'category_id' => '12',
                'created_at' => now()
            ],
            [
                'game_id' => '3',
                'category_id' => '11',
                'created_at' => now()
            ]
        ]);
    }
}
