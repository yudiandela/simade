<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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

    public function overview()
    {
        return view('task.overview');
    }

    public function search(Request $request)
    {
        $surveyId = $request->order;
        $type = $request->type;
        $work = $request->work;
        $workDate = $request->wDate;
        $status = $request->status;
        $statusDate = $request->sDate;
        $role = $request->role;

        $surveys = Survey::query();

        if ($surveyId) {
            $surveys->where('survey_id', 'like', "%$surveyId%");
        }

        if ($role && $role !== 'all') {
            $surveys->where('handler', 'like', "%$role%");
        }

        if ($status && $status !== 'all') {
            $surveys->where('status', 'like', "%$status%");
        }

        $surveys = $surveys->get();

        $data = [];
        foreach ($surveys as $survey) {
            $data[] = '
                    <tr>
                        <td class="align-middle text-center">' . $survey->survey_id . '</td>
                        <td class="align-middle text-left"><a href="' . route('inbox.maps') . '?lat=' . $survey->latitude . '&lng=' . $survey->longitude . '&id=' . $survey->id . '&type=survey">' . $survey->name . '</a></td>
                        <td class="align-middle text-center">' . $survey->phone . '</td>
                        <td class="align-middle text-center">' . Str::title(rtrim(preg_replace('/\d/', '', $survey->province))) . '</td>
                        <td class="align-middle text-center">' . Str::title($survey->districts) . '</td>
                        <td class="align-middle text-center">' . Str::title($survey->sub_district) . '</td>
                        <td class="align-middle text-center">' . $survey->price . '</td>
                        <td class="align-middle text-center">' . $survey->status . '</td>
                        <td class="align-middle text-left">
                            ' . $survey->handler . ' <br>
                            Keterangan : ' . ($survey->note ?: " - ") . ' <br>
                            Estimated Time : ' . ($survey->estimated_time ?: " - ") . '
                        </td>
                        <td class="align-middle text-center">
                            ' . (auth()->user()->role === 'verificator' ?
                '<a href="' . route('survey.edit', $survey->id) . '" class="btn btn-primary">Edit</a>' :
                '<a href="#" disabled class="btn btn-primary disabled">Edit</a>') . '
                        </td>
                    </tr>
                ';
        }

        if (count($data) == 0) {
            $data[] = '<tr><td colspan="10" class="text-center">No Data</td></tr>';
        }

        if ($request->ajax) {
            return $data;
        }

        return view('task.search');
    }
}
