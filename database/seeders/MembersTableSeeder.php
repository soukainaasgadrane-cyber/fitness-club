<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
       DB::table('members')->insert([
    ['name' => 'Ali', 'email' => 'ali@example.com'],
    ['name' => 'Sara', 'email' => 'sara@example.com']
]);
    }
}