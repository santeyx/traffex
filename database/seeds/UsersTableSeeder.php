<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        
        User::create([
            'name' => 'Alexandr',
            'email' => 'santeyx@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
