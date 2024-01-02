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
        // opens the file
        $file = fopen(public_path('data/medienauskunft_Kompetenzen.txt'), "r");
        if($file) {
            // reads the file line by line
            while (($line = fgets($file)) !== false) {
                try {
                    // inserts the line into the database
                    DB::table('competences')->insert([
                        'name' => str_replace(array("\r", "\n"), "", $line)
                    ]);
                } catch (UniqueConstraintViolationException) {
                    // if the line already exists, skip it
                    continue;
                }
            }
            // closes the file
            fclose($file);
        }
    }
}
