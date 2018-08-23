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
        DB::table('users')->insert([
            'name' => 'seven',
            'email' => 'jheancg@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        DB::table('users')->insert([
            'name' => 'Alain Diaz',
            'email' => 'jadcve@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
