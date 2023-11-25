<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        collect([
            [
                'indikator' => 'Return On Assets',
                'abbr' => 'roa',
                'atribut' => 'benefit',
                'bobot' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'indikator' => 'Gross Margin',
                'abbr' => 'gm',
                'atribut' => 'benefit',
                'bobot' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'indikator' => 'Inventory Turn Over',
                'abbr' => 'ito',
                'atribut' => 'benefit',
                'bobot' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'indikator' => 'Rasio Efisiensi',
                'abbr' => 're',
                'atribut' => 'cost',
                'bobot' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ])->each(function ($kriteria) {
            DB::table('kriteria')->insert($kriteria);
        });

        \App\Models\Asset::factory()->create([
            'nama' => 'Rak',
            'nilai' => '100000',
            'penyusutan' => '0',
        ]);

        \App\Models\User::factory()->create([
            'nama' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
