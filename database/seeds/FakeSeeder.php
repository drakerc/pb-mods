<?php

use App\DevelopmentStudio;
use App\Game;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function (User $user) {
            factory(DevelopmentStudio::class, 1)->create(['owner_id'=>$user->id])->each(function (DevelopmentStudio $studio) use ($user) {
                $studio->users()->attach($user);
                factory(Game::class, 1)->create()->each(function (Game $game) use ($studio, $user) {
                    factory(Post::class, 2)->create(['game_id' => $game->id]);
                    $studio->games()->attach($game);
                });
            });
        });
    }
}
