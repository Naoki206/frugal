<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //一括削除
        User::truncate();

        User::create([
            'name' => 'test1',
            'email' => 'test1@test.com',
            'password' => Hash::make('testtest'),
            'income' => 100000,
            'remember_token' => Str::random(10),
        ]);

        factory(User::class, 10)->create();
    }
}
