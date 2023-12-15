<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("admins")->insert([
            "full_name" => "Admin",
            "email"=> "admin@gmail.com",
            "user_name" =>"admin",
            "password"=> Hash::make("Password123"),
            "created_at"=> now(),
            "updated_at"=> now(),
        ]);
    }
}
