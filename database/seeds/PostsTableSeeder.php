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
                'body' => 'Dzięki temu postowi dowiesz się, jak poradzić sobie w surowym i brutalnym świecie Fallout 3!',
                'game_id' => 3,
                'created_at' => now(),
                'post_category_id' => 3
            ]
        );
    }
}
