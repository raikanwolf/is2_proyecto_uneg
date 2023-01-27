<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Studentseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'nombre' => Str::random(10),
        ]);
        DB::table('students')->insert([
            'nombre' => Str::random(10),
        ]);
        DB::table('students')->insert([
            'nombre' => Str::random(10),
        ]);
        DB::table('students')->insert([
            'nombre' => Str::random(10),
        ]);
    }
}
