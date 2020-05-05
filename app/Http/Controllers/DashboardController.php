<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $surveys = Survey::paginate(20);
        return view('dashboard.index', compact('surveys'));
    }

    public function maps()
    {
        $surveys = Survey::all();
        return view('dashboard.maps', compact('surveys'));
    }
}
