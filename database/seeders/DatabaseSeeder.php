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
        $transv_research_prio_data = [
            [
                'id' => 'demo',
                'english' => 'Democracy and Democratization',
                'german' => 'Demokratie und Demokratisierung'
            ],
            [
                'id' => 'digi',
                'english' => 'Digitalization',
                'german' => 'Digitalisierung'
            ],
            [
                'id' => 'inter',
                'english' => 'International Cooperation',
                'german' => 'Internationale Kooperation'
            ],
            [
                'id' => 'poli',
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit'
            ]
        ];

        DB::table('transv_research_prios')->insert($transv_research_prio_data);

        // pre-populates research_area table
        $research_area_data = [
            [
                'id' => 'pol_sociology',
                'english' => 'Political Sociology',
                'german' => 'Politische Soziologie'
            ],
            [
                'id' => 'comp_politics',
                'english' => 'Comparative Politics',
                'german' => 'Vergleichende Politik'
            ],
            [
                'id' => 'pol_philo',
                'english' => 'Political Philosophy',
                'german' => 'Politische Philosophie'
            ],
            [
                'id' => 'pol_behav_digi_media',
                'english' => 'Political Behavior and Digital Media',
                'german' => 'Political Behavior and Digital Media'
            ],
            [
                'id' => 'pol_analy',
                'english' => 'Policy Analysis',
                'german' => 'Policy-Analyse'
            ],
            [
                'id' => 'int_sec',
                'english' => 'International Security Peace and Conflict',
                'german' => 'Internationale Sicherheit, Frieden und Konflikt'
            ],
            [
                'id' => 'swiss_pol',
                'english' => 'Swiss Politics and Comparative political Economy',
                'german' => 'Schweizer Politik und Vergleichende politische Ökonomie'
            ],
            [
                'id' => 'demo_pub',
                'english' => 'Democracy and Public Governance',
                'german' => 'Demokratieforschung und Public Governance'
            ],
            [
                'id' => 'pol_ineq',
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit'
            ],
            [
                'id' => 'comp_politics_emp_demo_res',
                'english' => 'Comparative Politics and Empirical Democracy Research',
                'german' => 'Vergleichende Politik mit Schwerpunkt empirische Demokratieforschung'
            ],
            [
                'id' => 'pol_eco',
                'english' => 'Political Economy and Development',
                'german' => 'Politische Ökonomie der Entwicklungs- und Schwellenländer'
            ],
            [
                'id' => 'pol_insiti',
                'english' => 'Political Institutions and European Politics',
                'german' => 'Politische Institutionen und Europäische Politik'
            ],
            [
                'id' => 'pol_metho',
                'english' => 'Political Methodology',
                'german' => 'Methoden der Politikwissenschaft'
            ],
            [
                'id' => 'int_rel',
                'english' => 'International Relations and International Political Economy',
                'german' => 'Internationale Beziehungen und Internationale Politische Ökonomie'
            ],
            [
                'id' => 'comp_politics_dem_rep',
                'english' => 'Comparative Politics with a special focus on Democratic Representation',
                'german' => 'Vergleichende Politikwissenschaft mit Schwerpunkt Demokratische Repräsentation'
            ],
            [
                'id' => 'pol_analy_eval',
                'english' => 'Policy Analysis & Evaluation',
                'german' => 'Policy-Analyse & Evaluation'
            ],
        ];

        DB::table('research_areas')->insert($research_area_data);

        // runs additional seeders
        $this->call([
            UserSeeder::class,
            CompetenceSeeder::class
        ]);
    }
}
