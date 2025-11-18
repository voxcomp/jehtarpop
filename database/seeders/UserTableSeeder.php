<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
