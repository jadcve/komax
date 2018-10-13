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
            array('name' => 'Erick Velasquez', 'email' => 'erikvelasquez.25@gmail.com', 'password' => bcrypt('123456')),
        );
        DB::table('users')->delete();
        //resetea el autoincremento a 1
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 1");
        DB::table('users')->insert($users);
    }
}
