<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
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
        User::create([
            'full_name' => 'Admin Lokalingo',
            'username' => 'admin',
            'email' => 'admin@lokalingo.fun',
            'password' => Hash::make('Adminl0kalingo2022'),
            'asal' => 'Bekasi',
            'role' => 'admin',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
