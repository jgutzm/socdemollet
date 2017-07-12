<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
	        'first_name' => 'Jesús',
	        'last_name' => 'Gutiérrez',
	        'username' => 'jgutzm',
	        'email' => 'jgutzm@gmail.com',
	        'password' => bcrypt('1234Abc'),
	       	'role' => 'admin',
        ]);
    }
}
