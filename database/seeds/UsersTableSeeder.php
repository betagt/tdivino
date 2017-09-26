<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Portal\Models\User::class)->create([
            'email'=>'user1@teste.com'
        ]);

        factory(\Portal\Models\User::class)->create([
            'email'=>'user2@teste.com'
        ]);
    }
}
