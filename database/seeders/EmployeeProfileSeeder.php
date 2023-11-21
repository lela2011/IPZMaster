<?php

namespace Database\Seeders;

use App\Models\EmployeeProfile;
use App\Models\TransversalReserachPrio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeProfile::truncate();

        $csvFile = fopen(public_path('data/employee.csv'), "r");
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            DB::table('employee_profiles')->insert([
                'uid' => $data[0],
                'first_name' => $data[1],
                'last_name' => $data[2],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
        fclose($csvFile);
    }
}
