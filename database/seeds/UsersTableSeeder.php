<?php

use App\User;
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
        //clear table
        User::truncate();

        User::create([
            'name' => 'Felipe',
            'email' => 'felipe@hertzer.com.br',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Augusto',
            'email' => 'augusto@hertzer.com.br',
            'password' => bcrypt('123456'),
        ]);
    }
}
