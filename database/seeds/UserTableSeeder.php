<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $user = User::create([
            'usertype' => 'admin',
            'name' => 'Admin',
            'email' => 'info@gwgci.org',
            'password' => bcrypt('password'),
        ]);
    }
}
