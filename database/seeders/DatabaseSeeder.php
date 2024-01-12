<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // runs additional seeders
        $this->call([
            UserSeeder::class,
            CompetenceSeeder::class
        ]);

        // pre-populates transv_research_prio table
        $transv_research_prio_data = [
            [
                'english' => 'Democracy and Democratization',
                'german' => 'Demokratie und Demokratisierung'
            ],
            [
                'english' => 'Digitalization',
                'german' => 'Digitalisierung'
            ],
            [
                'english' => 'International Cooperation',
                'german' => 'Internationale Kooperation'
            ],
            [
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit'
            ]
        ];

        DB::table('transv_research_prios')->insert($transv_research_prio_data);

        // pre-populates research_area table
        $research_area_data = [
            [
                'english' => 'Political Sociology',
                'german' => 'Politische Soziologie',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischesoziologie.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischesoziologie.html',
                'manager_uid' => 'sborns'
            ],
            [
                'english' => 'Comparative Politics',
                'german' => 'Vergleichende Politik',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/vergleichende-politik.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/vergleichende-politik.html',
                'manager_uid' => 'dcaram'
            ],
            [
                'english' => 'Political Philosophy',
                'german' => 'Politische Philosophie',
                'url_english' => 'https://www.philosophie.uzh.ch/en/research/professorial_chair/politics_cheneval.html',
                'url_german' => 'https://www.philosophie.uzh.ch/de/research/professorial_chair/politics_cheneval.html',
                'manager_uid' => null
            ],
            [
                'english' => 'Political Behavior and Digital Media',
                'german' => 'Political Behavior and Digital Media',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/bdm.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/bdm.html',
                'manager_uid' => 'kdonna'
            ],
            [
                'english' => 'Policy Analysis',
                'german' => 'Policy-Analyse',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pa.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pa.html',
                'manager_uid' => 'fgilar'
            ],
            [
                'english' => 'International Security Peace and Conflict',
                'german' => 'Internationale Sicherheit, Frieden und Konflikt',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/isfk.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/isfk.html',
                'manager_uid' => 'begonz'
            ],
            [
                'english' => 'Swiss Politics and Comparative political Economy',
                'german' => 'Schweizer Politik und Vergleichende politische Ökonomie',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/sp.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/sp.html',
                'manager_uid' => 'shaeus'
            ],
            [
                'english' => 'Democracy and Public Governance',
                'german' => 'Demokratieforschung und Public Governance',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/df.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/df.html',
                'manager_uid' => 'dkuebl'
            ],
            [
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pu.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pu.html',
                'manager_uid' => 'tkurer'
            ],
            [
                'english' => 'Comparative Politics and Empirical Democracy Research',
                'german' => 'Vergleichende Politik mit Schwerpunkt empirische Demokratieforschung',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpedr.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpedr.html',
                'manager_uid' => 'luleem'
            ],
            [
                'english' => 'Political Economy and Development',
                'german' => 'Politische Ökonomie der Entwicklungs- und Schwellenländer',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ep.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ep.html',
                'manager_uid' => 'kmicha'
            ],
            [
                'english' => 'Political Institutions and European Politics',
                'german' => 'Politische Institutionen und Europäische Politik',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischeinstitutionen.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischeinstitutionen.html',
                'manager_uid' => 'jslapi'
            ],
            [
                'english' => 'Political Methodology',
                'german' => 'Methoden der Politikwissenschaft',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/mp.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/mp.html',
                'manager_uid' => 'msteen'
            ],
            [
                'english' => 'International Relations and International Political Economy',
                'german' => 'Internationale Beziehungen und Internationale Politische Ökonomie',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ibpe.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ibpe.html',
                'manager_uid' => 'swalter'
            ],
            [
                'english' => 'Comparative Politics with a special focus on Democratic Representation',
                'german' => 'Vergleichende Politikwissenschaft mit Schwerpunkt Demokratische Repräsentation',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpdr.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpdr.html',
                'manager_uid' => 'hawern'
            ],
            [
                'english' => 'Policy Analysis & Evaluation',
                'german' => 'Policy-Analyse & Evaluation',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/fbpa.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/fbpa.html',
                'manager_uid' => 'twidme'
            ],
        ];

        DB::table('research_areas')->insert($research_area_data);

        // pre-populates employment_type table
        $employment_type_data = [
            [
                'english' => 'Senior Researchers',
                'german' => 'Wissenschaftliche Mitarbeitende'
            ],
            [
                'english' => 'Post Docs',
                'german' => 'Post Docs'
            ],
            [
                'english' => 'Doctoral Students/Aassistants',
                'german' => 'Doktorierende/Assestierende',
            ],
            [
                'english' => 'Auxiliary Assistants',
                'german' => 'Hilfsassistierende'
            ],
            [
                'english' => 'Tutors',
                'german' => 'Tutorierende'
            ],
            [
                'english' => 'Associate Researchers',
                'german' => 'Assoziierte Forschende'
            ],
            [
                'english' => 'Academic Guests',
                'german' => 'Akademische Gäste'
            ],
        ];

        DB::table('employment_types')->insert($employment_type_data);
    }
}
