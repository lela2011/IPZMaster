<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // pre-populates transv_research_prio table
        $transv_research_area_data = [
            [
                'transv_id' => 'default',
                'english' => '',
                'german' => ''
            ],
            [
                'transv_id' => 'demo',
                'english' => 'Democracy and Democratization',
                'german' => 'Demokratie und Demokratisierung'
            ],
            [
                'transv_id' => 'digi',
                'english' => 'Digitalization',
                'german' => 'Digitalisierung'
            ],
            [
                'trasv_id' => 'inter',
                'english' => 'International Cooperation',
                'german' => 'Internationale Kooperation'
            ],
            [
                'transv_id' => 'poli',
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit'
            ]
        ];

        DB::table('transv_research_prios')->insert($transv_research_area_data);
    }
}
