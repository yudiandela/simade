<?php

namespace App\Http\Controllers;

use App\Survey;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'ktp' => ['required', 'string'],
            'price' => ['required']
        ]);

        $price = explode(',', $request->price);
        $address = explode(',', $request->address);
        $price_to = null;
        if (array_key_exists(1, $price)) {
            $price_to = $price[1];
        }

        $survey_id = Carbon::now()->format('dmY') . '/SID';

        $survey = Survey::create([
            'name' => $request->name,
            'address' => $request->address,
            'province' => trim($this->last($address, 2)),
            'districts' => trim($this->last($address, 3)),
            'sub_district' => trim($this->last($address, 4)),
            'phone' => (string) $request->phone,
            'ktp' => (string) $request->ktp,
            'price_from' => (int) $price[0],
            'price_to' => (int) $price_to,
            'latitude' => (float) $request->latitude,
            'longitude' => (float) $request->longitude,
            'status' => 'New'
        ]);

        $id = $survey->id;
        if (strlen($id) == 1) {
            $id = 00 . $survey->id;
        } elseif (strlen($id) == 2) {
            $id = 0 . $survey->id;
        }

        $survey->update([
            'survey_id' => $survey_id . $id,
        ]);

        return redirect()->route('survey.thanks')->with('status', 'Terima kasih telah memberikan tanggapan anda');
    }

    private function last(array $array, $n = null)
    {
        if (!is_array($array) || empty($array)) {
            return NULL;
        }

        if ($n) {
            return array_values($array)[count($array) - $n];
        }

        return array_values($array)[count($array) - 1];
    }

    public function edit(Request $request, Survey $survey)
    {
        if (Auth::user()->role != 'Verificator') {
            return view('errors.403');
        }

        return view('survey.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'ktp' => ['required', 'string'],
            'price' => ['required']
        ]);

        $price = explode(',', $request->price);
        $address = explode(',', $request->address);
        $price_to = null;
        if (array_key_exists(1, $price)) {
            $price_to = $price[1];
        }

        $survey->update([
            'name' => $request->name,
            'address' => $request->address,
            'province' => trim($this->last($address, 2)),
            'districts' => trim($this->last($address, 3)),
            'sub_district' => trim($this->last($address, 4)),
            'phone' => (string) $request->phone,
            'ktp' => (string) $request->ktp,
            'price_from' => (int) $price[0],
            'price_to' => (int) $price_to,
            'latitude' => (float) $request->latitude,
            'longitude' => (float) $request->longitude
        ]);

        return redirect()->route('dashboard')->with('status', 'Data berhasil diubah');
    }

    public function updateTime(Request $request, Survey $survey)
    {
        $survey->update([
            'estimated_time' => $request->estimated_time
        ]);

        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function validator(Request $request, Survey $survey)
    {
        $handler = null;
        $status = $request->status;
        $note = null;

        $survey->update($request->all());

        foreach ($request->all() as $key => $value) {
            $requestKey[] = $key;
        }

        if ($requestKey[0] == 'verificator_1') {
            if ($survey->verificator_2 !== 'Complete') {
                $note = 'Pending Task 2 Verificator';
            } else {
                $handler = 'Deployment';
                $note = 'Verificator approved : Data benar dan Pelanggan Minat';
            }
        } elseif ($requestKey[0] == 'verificator_2') {
            if ($survey->verificator_1 !== 'Complete') {
                $note = 'Pending Task 1 Verificator';
            } else {
                $handler = 'Deployment';
                $note = 'Verificator approved : Data benar dan Pelanggan Minat';
            }
        } elseif ($requestKey[0] == 'deployment_1') {
            if ($survey->deployment_2 !== 'Complete') {
                $note = 'Pending Task 2, Ready to Deploy Tanggal ' . $survey->work_date->format('d-M-Y');
            } else {
                $handler = 'Manager CS';
            }
        } elseif ($requestKey[0] == 'deployment_2') {
            if ($survey->deployment_1 === 'Complete') {
                $note = 'Deployment Approved dan sudah selesai pembangunan ' . $survey->work_date->format('d-M-Y');
                $handler = 'Manager CS';
            }
        } elseif ($requestKey[0] == 'manager_1') {
            if ($survey->manager_2 !== 'Complete') {
                $note = 'Pending Task 2 Manager CS';
            } else {
                $status = 'Done';
                $note = 'Manager CS approved : Data benar dan Pelanggan Minat';
            }
        } elseif ($requestKey[0] == 'manager_2') {
            if ($survey->manager_1 !== 'Complete') {
                $note = 'Pending Task 2 Manager CS';
            } else {
                $status = 'Done';
                $note = 'Manager CS approved : Data benar dan Pelanggan Minat';
            }
        }

        if ($handler) {
            $survey->update(['handler' => $handler]);
        }

        if ($note) {
            $survey->update(['note' => $note]);
        }

        if ($status) {
            $survey->update(['status' => $status]);
        } else {
            $survey->update(['status' => 'On Progress']);
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }
}
