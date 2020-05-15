<?php

namespace App\Http\Controllers\Api;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return response()->json([
            'took' => round(microtime(true) - LARAVEL_START, 2),
            'status' => 'Success',
            'data' => $surveys,
        ]);
    }
}
