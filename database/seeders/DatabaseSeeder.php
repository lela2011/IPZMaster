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
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischesoziologie.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischesoziologie.html'
            ],
            [
                'id' => 'comp_politics',
                'english' => 'Comparative Politics',
                'german' => 'Vergleichende Politik',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/vergleichende-politik.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/vergleichende-politik.html'
            ],
            [
                'id' => 'pol_philo',
                'english' => 'Political Philosophy',
                'german' => 'Politische Philosophie',
                'url_english' => 'https://www.philosophie.uzh.ch/en/research/professorial_chair/politics_cheneval.html',
                'url_german' => 'https://www.philosophie.uzh.ch/de/research/professorial_chair/politics_cheneval.html'
            ],
            [
                'id' => 'pol_behav_digi_media',
                'english' => 'Political Behavior and Digital Media',
                'german' => 'Political Behavior and Digital Media',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/bdm.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/bdm.html'
            ],
            [
                'id' => 'pol_analy',
                'english' => 'Policy Analysis',
                'german' => 'Policy-Analyse',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pa.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pa.html'
            ],
            [
                'id' => 'int_sec',
                'english' => 'International Security Peace and Conflict',
                'german' => 'Internationale Sicherheit, Frieden und Konflikt',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/isfk.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/isfk.html'
            ],
            [
                'id' => 'swiss_pol',
                'english' => 'Swiss Politics and Comparative political Economy',
                'german' => 'Schweizer Politik und Vergleichende politische Ökonomie',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/sp.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/sp.html'
            ],
            [
                'id' => 'demo_pub',
                'english' => 'Democracy and Public Governance',
                'german' => 'Demokratieforschung und Public Governance',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/df.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/df.html'
            ],
            [
                'id' => 'pol_ineq',
                'english' => 'Politics and Inequality',
                'german' => 'Politik und Ungleichheit',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/pu.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/pu.html'
            ],
            [
                'id' => 'comp_politics_emp_demo_res',
                'english' => 'Comparative Politics and Empirical Democracy Research',
                'german' => 'Vergleichende Politik mit Schwerpunkt empirische Demokratieforschung',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpedr.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpedr.html'
            ],
            [
                'id' => 'pol_eco',
                'english' => 'Political Economy and Development',
                'german' => 'Politische Ökonomie der Entwicklungs- und Schwellenländer',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ep.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ep.html'
            ],
            [
                'id' => 'pol_insti',
                'english' => 'Political Institutions and European Politics',
                'german' => 'Politische Institutionen und Europäische Politik',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/politischeinstitutionen.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/politischeinstitutionen.html'
            ],
            [
                'id' => 'pol_metho',
                'english' => 'Political Methodology',
                'german' => 'Methoden der Politikwissenschaft',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/mp.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/mp.html'
            ],
            [
                'id' => 'int_rel',
                'english' => 'International Relations and International Political Economy',
                'german' => 'Internationale Beziehungen und Internationale Politische Ökonomie',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/ibpe.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/ibpe.html'
            ],
            [
                'id' => 'comp_politics_dem_rep',
                'english' => 'Comparative Politics with a special focus on Democratic Representation',
                'german' => 'Vergleichende Politikwissenschaft mit Schwerpunkt Demokratische Repräsentation',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/cpdr.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/cpdr.html'
            ],
            [
                'id' => 'pol_analy_eval',
                'english' => 'Policy Analysis & Evaluation',
                'german' => 'Policy-Analyse & Evaluation',
                'url_english' => 'https://www.ipz.uzh.ch/en/research/professorships-and-research-areas/fbpa.html',
                'url_german' => 'https://www.ipz.uzh.ch/de/forschung/professuren-und-forschungsbereiche/fbpa.html'
            ],
        ];

        DB::table('research_areas')->insert($research_area_data);

        // pre-populates employment_type table
        $employment_type_data = [
            [
                'id' => 'pd',
                'english' => 'Post Docs',
                'german' => 'Post Docs'
            ],
            [
                'id' => 'ag',
                'english' => 'Academic Guests',
                'german' => 'Akademische Gäste'
            ],
            [
                'id' => 'da',
                'english' => 'Doctoral students/assistants',
                'german' => 'Doktorierende/Assestierende',
            ],
            [
                'id' => 'ar',
                'english' => 'Associate researchers',
                'german' => 'Assoziierte Forschende'
            ],
            [
                'id' => 'ra',
                'english' => 'Research assistants',
                'german' => 'Wissenschaftliche Mitarbeitende'
            ],
            [
                'id' => 'aa',
                'english' => 'Auxiliary assistants',
                'german' => 'Hilfsassistierende'
            ],
            [
                'id' => 'tu',
                'english' => 'Tutors',
                'german' => 'Tutorierende'
            ]
        ];

        DB::table('employment_types')->insert($employment_type_data);

        // runs additional seeders
        $this->call([
            UserSeeder::class,
            CompetenceSeeder::class
        ]);

        $manager_area = [
            'sborns' => 'pol_sociology',
            'dcaram'=> 'comp_politics',
            'kdonna' => 'pol_behav_digi_media',
            'fgilar' => 'pol_analy',
            'begonz' => 'int_sec',
            'shaeus' => 'swiss_pol',
            'dkuebl' => 'demo_pub',
            'tkurer' => 'pol_ineq',
            'luleem' => 'comp_politics_emp_demo_res',
            'kmicha' => 'pol_eco',
            'jslapi' => 'pol_insti',
            'msteen' => 'pol_metho',
            'swalter' => 'int_rel',
            'hawern' => 'comp_politics_dem_rep',
            'twidme' => 'pol_analy_eval'
        ];

        foreach ($manager_area as $userUid => $areaId) {
            $user = User::where('uid', $userUid)->first();
            $area = ResearchArea::where('id', $areaId)->first();

            if ($user && $area) {
                $area->manager_uid = $user->uid; // Set the user_id in the research_areas table
                $area->save();
            }
        }
    }
}
