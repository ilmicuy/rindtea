<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        try {
            Role::create(['name' => 'user']);
        } catch (Exception $e) {
        };

        try {
            Role::create(['name' => 'owner']);
        } catch (Exception $e) {
        };

        try {
            Role::create(['name' => 'marketing']);
        } catch (Exception $e) {
        };

        try {
            Role::create(['name' => 'produksi']);
        } catch (Exception $e) {
        };

        try {
            Role::create(['name' => 'keuangan']);
        } catch (Exception $e) {
        };

        User::create([
            'name' => "Owner Account",
            'email' => "owner@rindtea.biz.id",
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => Hash::make('password'),
            'is_admin' => true
        ])->assignRole('owner');

        User::create([
            'name' => "Marketing Account",
            'email' => "marketing@rindtea.biz.id",
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => Hash::make('password'),
            'is_admin' => true
        ])->assignRole('marketing');

        User::create([
            'name' => "Produksi Account",
            'email' => "produksi@rindtea.biz.id",
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => Hash::make('password'),
            'is_admin' => true
        ])->assignRole('produksi');

        User::create([
            'name' => "Keuangan Account",
            'email' => "keuangan@rindtea.biz.id",
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => Hash::make('password'),
            'is_admin' => true
        ])->assignRole('keuangan');


        // User::factory()->create([
        //     'name' => 'Test',
        //     'email' => 'test@gmail.com',
        //     'email_verified_at' => date('Y-m-d H:i:s', time()),
        //     'password' => bcrypt('12121212'),
        //     'is_admin' => true
        // ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => bcrypt('12121212'),
            'is_admin' => false
        ])->assignRole('user');


    }
}
