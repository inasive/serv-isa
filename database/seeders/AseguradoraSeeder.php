<?php

namespace Database\Seeders;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AseguradoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('aseguradoras')->insert([
            'nombre' => 'GNP',
            'icono' => 'gnp',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('aseguradoras')->insert([
            'nombre' => 'ZURICH',
            'icono' => 'zurich',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('aseguradoras')->insert([
            'nombre' => 'QUALITAS',
            'icono' => 'qualitas',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('aseguradoras')->insert([
            'nombre' => 'MAPFRE',
            'icono' => 'mapfre',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
