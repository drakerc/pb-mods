<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostCategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FileSeeder::class);
        $this->call(GamesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ModificationsSeeder::class);
        $this->call(CategoryGameSeeder::class);
    }
}
