<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin if debug mode is activ
        if (config('app.debug')) {
            DB::table('users')->insert([
                'email' => config('app.admin.email'),
                'password' => Hash::make(config('app.admin.password')),
            ]);
        }
    }
}
