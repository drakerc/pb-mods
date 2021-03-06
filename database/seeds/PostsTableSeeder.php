<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert(
            [
                'title' => 'Witaj w postapokaliptycznym Waszyngtonie!',
                'body' => '<p><strong>Dzięki temu postowi dowiesz się, jak poradzić sobie w surowym i brutalnym świecie Fallout 3!</strong></p><p><em>Powodzenia w Capital Wastelands,</em></p><p><em>Deweloperzy Fallout 3</em></p>',
                'game_id' => 3,
                'created_at' => now(),
                'post_category_id' => 3
            ]
        );
    }
}
