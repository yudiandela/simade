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

    public function overview(Request $request)
    {
        $role = auth()->user()->role;
        $new = Survey::where(['status' => 'new', 'handler' => $role])->count();
        $onProgress = Survey::where(['status' => 'on progress', 'handler' => $role])->count();
        $done = Survey::where(['status' => 'done', 'handler' => $role])->count();

        $action = $request->d;
        $datas = [];
        if ($action) {
            $datas = Survey::where(['status' => $action, 'handler' => $role])->paginate(10);
        }

        $validate1 = auth()->user()->role == 'Verificator' ? 'verificator_1' : (auth()->user()->role == 'Deployment' ? 'deployment_1' : 'manager_1');
        $validate2 = auth()->user()->role == 'Verificator' ? 'verificator_2' : (auth()->user()->role == 'Deployment' ? 'deployment_2' : 'manager_2');
        $validate1Date = $validate1 . '_date';
        $validate2Date = $validate2 . '_date';

        return view('task.overview', compact('datas', 'new', 'onProgress', 'done', 'validate1', 'validate2', 'validate1Date', 'validate2Date'));
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
