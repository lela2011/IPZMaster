<?php

namespace Database\Seeders;

use App\Models\EmployeeProfile;
use App\Models\TransversalReserachPrio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reads employee data from csv and loads it into user table to provide functionality when not yet signed in
        $csvFile = fopen(public_path('data/employee.csv'), "r");
        $firstLine = fgets($csvFile);

        // Check for BOM and remove if present
        if (str_starts_with($firstLine, "\xEF\xBB\xBF")) {
            // If BOM found, move file pointer to the start of the file
            fseek($csvFile, 3);
        } else {
            // If no BOM, rewind to the start of the file
            rewind($csvFile);
        }

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            DB::table('users')->insert([
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
