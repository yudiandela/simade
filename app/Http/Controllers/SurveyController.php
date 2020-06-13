<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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

        Survey::create([
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
}
