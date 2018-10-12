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
        $users = array(
            array('name' => 'seven', 'email' => 'jheancg@gmail.com', 'password' => bcrypt('123456')),
            array('name' => 'Alain Diaz', 'email' => 'jadcve@gmail.com', 'password' => bcrypt('123456')),
            array('name' => 'Erick Velasquez', 'email' => 'erik@gmail.com', 'password' => bcrypt('123456')),
        );
        DB::table('users')->insert();
    }
}
