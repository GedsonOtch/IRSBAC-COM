<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'Super Administrateur',
                'email' => 'admin@irsbac.com',
                'role' => 'super_admin',
                'password' => Hash::make('password'),
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Administrateur',
                'email' => 'gestionnaire@irsbac.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

          DB::table('filieres')->insert([
            [
                'nom' => 'Lettres Modernes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Communication',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Arts Plastiques',
                'created_at' => now(),
                'updated_at' => now(),
            ],
     
            ]);
    }
}