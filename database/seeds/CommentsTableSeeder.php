<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert(
          [
              [
                  'post_id' => 1,
                  'author_id' => '1',
                  'body' => 'Dzięki wielkie za te niezwykle pomocne tipy!',
                  'created_at' => now()
              ],
              [
                  'post_id' => 1,
                  'author_id' => '2',
                  'body' => 'Ech, już wcześniej o tym wiedziałem.',
                  'created_at' => now()
              ]
          ]
        );
    }
}
