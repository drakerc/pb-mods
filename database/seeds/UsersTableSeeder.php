<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'gallanonim',
                    'email' => 'gallanonim@anonim.com',
                    'password' => 'anonim'
                ],
                [
                    'id' => 2,
                    'name' => 'anonymous_user',
                    'email' => 'anonymous@asdasd.com',
                    'password' => 'somerandompassword'
                ]
            ]
        );
    }
}
