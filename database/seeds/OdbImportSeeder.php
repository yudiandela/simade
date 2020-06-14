<?php

use Illuminate\Database\Seeder;

use App\Imports\OdbImport;
use Maatwebsite\Excel\Facades\Excel;

class OdbImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new OdbImport, public_path('documents/ReportODP_05012020_v2.xlsx'));
    }
}
