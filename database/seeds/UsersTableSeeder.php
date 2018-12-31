<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                    'password' => Hash::make('anonim'),
                    'is_admin' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'anonymous_user',
                    'email' => 'anonymous@asdasd.com',
                    'password' => Hash::make('somerandompassword'),
                    'is_admin' => false,
                ]
            ]
        );
    }
}
