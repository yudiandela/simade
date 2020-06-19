<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Support\Str;
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

    public function approve(Request $request)
    {
        $survey = Survey::find($request->survey);

        if ($survey->handler == 'Verificator') {
            $handler = 'Deployment';
            $note = $request->note;
            $status = 'On Progress';
        } elseif ($survey->handler == 'Deployment') {
            $handler = 'Manager CS';
            $note = $survey->note;
            $status = 'On Progress';
        } else {
            $handler = 'Manager CS';
            $note = $survey->note;
            $status = 'Done';
        }

        $survey->update([
            'note' => $note,
            'status' => $status,
            'handler' => $handler
        ]);

        return redirect()->route('dashboard')->with('status', 'Approved');
    }

    public function not_approve(Request $request)
    {
        $survey = Survey::find($request->survey);

        $status = 'Cancel';
        if ($survey->handler == 'Deployment') {
            $handler = 'Verificator';
            $note = $request->note;
        } elseif ($survey->handler == 'Manager CS') {
            $handler = 'Deployment';
            $note = $request->note;
        } else {
            $handler = 'Verificator';
            $note = 'Not approved ' . $survey->handler;
        }

        $survey->update([
            'note' => $note,
            'status' => $status,
            'handler' => $handler
        ]);

        return redirect()->route('dashboard')->with('status', 'Not Approved');
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
                    <td class="align-middle text-left">' . $survey->position . '</td>
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

    public function getNewTable(Request $request)
    {
        $province = $request->province;
        $districts = $request->districts;
        $price = $request->price;
        $status = $request->status;

        $surveys = Survey::query();
        if (!is_null($province) and $province != 'all') {
            $surveys->where("province", "LIKE", "%$province%");
        }

        if (!is_null($districts) and $districts != 'all') {
            $surveys->where("districts", "LIKE", "%$districts%");
        }

        if (!is_null($status) and $status != 'all') {
            $surveys->where("status", strtolower($status));
        }

        $price = $request->price;

        if (!is_null($price) and $price != 'all') {
            $price = explode(',', $price);
            $from = $price[0];
            $to = null;
            if (array_key_exists(1, $price)) {
                $to = $price[1];
            }

            $surveys->where([
                "price_from" => $from,
                "price_to" => $to
            ]);
        }

        $surveys = $surveys->get();

        $data = [];
        foreach ($surveys as $survey) {
            $data[] = '
                <tr>
                    <td class="align-middle text-center">' . $survey->survey_id . '</td>
                    <td class="align-middle text-left"><a href="' . route('inbox.maps') . '?lat=' . $survey->latitude . '&lng=' . $survey->longitude . '">' . $survey->name . '</a></td>
                    <td class="align-middle text-center">' . $survey->phone . '</td>
                    <td class="align-middle text-center">' . Str::title(rtrim(preg_replace('/\d/', '', $survey->province))) . '</td>
                    <td class="align-middle text-center">' . Str::title($survey->districts) . '</td>
                    <td class="align-middle text-center">' . Str::title($survey->sub_district) . '</td>
                    <td class="align-middle text-center">' . $survey->price . '</td>
                    <td class="align-middle text-center">' . $survey->status . '</td>
                    <td class="align-middle text-left">
                        ' . $survey->handler . ' <br>
                        Keterangan : ' . $survey->note . ' <br>
                        Estimated Time : ' . $survey->estimated_time ?: " - " . '
                    </td>
                </tr>
            ';
        }

        if (count($data) == 0) {
            $data[] = '<tr><td colspan="9" class="text-center">No Data</td></tr>';
        }

        return $data;
    }

    public function getDataApi(Request $request)
    {
        $param = $request->get;
        $surveys = Survey::select('*');

        if ($request->province) {
            $surveys->where('province', 'LIKE', "%$request->province%");
        }

        $surveys = $surveys->get();
        $unique = $surveys->sortBy($param)->unique(function ($item) use ($param) {
            return strtolower(preg_replace('/\d/', '', $item[$param]));
        });

        $surveys = $unique->values()->all();

        $data = ['<option value="all">Semua</option>'];
        foreach ($surveys as $survey) {
            $data[] = '<option value="' . strtolower(rtrim(preg_replace('/\d/', '', $survey->$param))) . '">' . Str::title(rtrim(preg_replace('/\d/', '', $survey->$param))) . '</option>';
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
