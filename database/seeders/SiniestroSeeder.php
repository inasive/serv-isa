<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SiniestroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datos = [
                    array( 
                        'nombre' =>  "15646556",
                        'marca' => "FORD",
                        'modelo' => "2007",
                        'serie' => "4564564456",
                        'placas' => "56456DD",
                        'terminado' => 0,
                        'aseguradora_id' => 2,
                        'user_id' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ),
                    array( 
                        'nombre' =>  "446466564",
                        'marca' => "NISSAN",
                        'modelo' => "2015",
                        'serie' => "111111111111",
                        'placas' => "56456DD",
                        'terminado' => 0,
                        'aseguradora_id' => 2,
                        'user_id' => 2,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                    
                ];
	
	    DB::table('siniestros')->insert($datos);
    }
}
