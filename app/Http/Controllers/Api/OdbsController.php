<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Odb;
use Illuminate\Http\Request;

class OdbsController extends Controller
{
    public function index()
    {
        $odbs = Odb::get();
        return response()->json([
            'took' => round(microtime(true) - LARAVEL_START, 2),
            'status' => 'Success',
            'data' => $odbs,
        ]);
    }
}
