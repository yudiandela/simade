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

    public function getTable(Request $request)
    {
        $regional = $request->regional;
        $witel = $request->witel;
        $mode = $request->mode;
        $status = $request->status;
        $task_owner = $request->task_owner;
        $from = $request->from;
        $to = $request->to;

        $surveys = Survey::query();
        if (!is_null($regional) and $regional != 'all') {
            $surveys->where("regional", $regional);
        }
        if (!is_null($witel) and $witel != 'all') {
            $surveys->where("witel", $witel);
        }
        if (!is_null($mode) and $mode != 'all') {
            $surveys->where("mode", $mode);
        }
        if (!is_null($status) and $status != 'all') {
            $surveys->where("status", $status);
        }
        if (!is_null($task_owner) and $task_owner != 'all') {
            $surveys->where("task_owner", $task_owner);
        }

        if (!is_null($from)) {
            $surveys->whereBetween("created_at", [$from, $to]);
        }

        $surveys = $surveys->get();

        $loop = 1;
        $data = [];
        foreach ($surveys as $survey) {
            $data[] = '
                <tr>
                    <td class="align-middle text-center">' . $loop . '</td>
                    <td class="align-middle text-center">Lokasi</td>
                    <td class="align-middle text-left"><a href="' . route('inbox.maps') . '?lat=' . $survey->latitude . '&lng=' . $survey->longitude . '">' . $survey->name . '</a></td>
                    <td class="align-middle text-center">' . $survey->phone . '</td>
                    <td class="align-middle text-center">Paket</td>
                    <td class="align-middle text-left">' . $survey->address . '</td>
                    <td class="align-middle text-center">' . $survey->occupant . '</td>
                    <td class="align-middle text-center">Milik Pribadi</td>
                    <td class="align-middle text-center">7x12</td>
                </tr>
            ';
            $loop++;
        }

        if (count($data) == 0) {
            $data[] = '<tr><td colspan="9" class="text-center">No Data</td></tr>';
        }

        return $data;
    }

    public function maps(Request $request)
    {
        $surveys = Survey::all();
        return view('dashboard.maps', compact('surveys'));
    }

    public function myTask()
    {
        return view('dashboard.my-task');
    }
}
