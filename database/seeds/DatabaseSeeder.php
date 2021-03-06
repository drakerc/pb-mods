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
        $this->call(GamesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ModificationsSeeder::class);
        $this->call(CategoryGameSeeder::class);
        $this->call(ModificationFilesSeeder::class);
        $this->call(ModificationImageFilesSeeder::class);
        $this->call(ModificationRatingsSeeder::class);
        $this->call(ModificationVideosSeeder::class);
        $this->call(InstructionSeeder::class);
        $this->call(DevelopmentStudiosSeeder::class);
        $this->call(JobOffersSeeder::class);
        $this->call(FakeSeeder::class);
    }
}
