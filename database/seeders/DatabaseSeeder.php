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
                'german' => 'Politische Soziologie',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischesoziologie.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischesoziologie.html'
            ],
            [
                'id' => 'comp_politics',
                'english' => 'Comparative Politics',
                'german' => 'Vergleichende Politik',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/vergleichende-politik.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/vergleichende-politik.html'
            ],
            [
                'id' => 'pol_philo',
                'english' => 'Political Philosophy',
                'german' => 'Politische Philosophie',
                'english_url' => 'https://www.philosophie.uzh.ch/en/research/professorial_chair/politics_cheneval.html',
                'german_url' => 'https://www.philosophie.uzh.ch/de/research/professorial_chair/politics_cheneval.html'
            ],
            [
                'id' => 'pol_behav_digi_media',
                'english' => 'Political Behavior and Digital Media',
                'german' => 'Political Behavior and Digital Media',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/bdm.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/bdm.html'
            ],
            [
                'id' => 'pol_analy',
                'english' => 'Policy Analysis',
                'german' => 'Policy-Analyse',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pa.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pa.html'
            ],
            [
                'id' => 'int_sec',
                'english' => 'International Security Peace and Conflict',
                'german' => 'Internationale Sicherheit, Frieden und Konflikt',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/isfk.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/isfk.html'
            ],
            [
                'id' => 'swiss_pol',
                'english' => 'Swiss Politics and Comparative political Economy',
                'german' => 'Schweizer Politik und Vergleichende politische Ökonomie',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/sp.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/sp.html'
            ],
            [
                'id' => 'demo_pub',
                'english' => 'Democracy and Public Governance',
                'german' => 'Demokratieforschung und Public Governance',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/df.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/df.html'
            ],
            [
                'id' => 'pol_ineq',
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pu.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pu.html'
            ],
            [
                'id' => 'comp_politics_emp_demo_res',
                'english' => 'Comparative Politics and Empirical Democracy Research',
                'german' => 'Vergleichende Politik mit Schwerpunkt empirische Demokratieforschung',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpedr.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpedr.html'
            ],
            [
                'id' => 'pol_eco',
                'english' => 'Political Economy and Development',
                'german' => 'Politische Ökonomie der Entwicklungs- und Schwellenländer',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ep.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ep.html'
            ],
            [
                'id' => 'pol_insiti',
                'english' => 'Political Institutions and European Politics',
                'german' => 'Politische Institutionen und Europäische Politik',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischeinstitutionen.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischeinstitutionen.html'
            ],
            [
                'id' => 'pol_metho',
                'english' => 'Political Methodology',
                'german' => 'Methoden der Politikwissenschaft',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/mp.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/mp.html'
            ],
            [
                'id' => 'int_rel',
                'english' => 'International Relations and International Political Economy',
                'german' => 'Internationale Beziehungen und Internationale Politische Ökonomie',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ibpe.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ibpe.html'
            ],
            [
                'id' => 'comp_politics_dem_rep',
                'english' => 'Comparative Politics with a special focus on Democratic Representation',
                'german' => 'Vergleichende Politikwissenschaft mit Schwerpunkt Demokratische Repräsentation',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpdr.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpdr.html'
            ],
            [
                'id' => 'pol_analy_eval',
                'english' => 'Policy Analysis & Evaluation',
                'german' => 'Policy-Analyse & Evaluation',
                'english_url' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/fbpa.html',
                'german_url' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/fbpa.html'
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
