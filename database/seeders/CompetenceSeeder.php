<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

class CompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen(public_path('data/medienauskunft_Kompetenzen.txt'), "r");
        if($file) {
            while (($line = fgets($file)) !== false) {
                try {
                    DB::table('competences')->insert([
                        'competence' => str_replace(array("\r", "\n"), "", $line)
                    ]);
                } catch (UniqueConstraintViolationException) {
                    continue;
                }
            }
            fclose($file);
        }
    }
}
