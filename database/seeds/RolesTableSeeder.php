<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = array(
            array('name' => 'Administrador', 'guard_name' => 'web'),
            array('name' => 'Analista', 'guard_name' => 'web'),
        );

        DB::table('roles')->insert($roles);

    }
}
