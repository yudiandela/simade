<?php

namespace App\Http\Controllers;

use App\Imports\OdbImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Excel::import(new OdbImport, public_path('documents/ReportODP_05012020_v2.xlsx'));
    }
}
