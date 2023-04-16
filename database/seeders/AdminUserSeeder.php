<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        User::where('name', 'admin')->delete();
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminuser'),
            'master_key' =>  strtoupper(Str::random(32))
        ]);
        User::where('name', 'felica')->delete();
        User::create([
            'name' => 'felica',
            'email' => 'felica@felica.com',
            'password' => Hash::make('felicauser'),
        ]);
    }
}
