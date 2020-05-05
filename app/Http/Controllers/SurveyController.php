<?php

namespace App\Http\Controllers;

use App\Survey;
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
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'phone' => ['required', 'string', 'min:3', 'max:15'],
            'occupant' => ['required', 'numeric'],
            'children_education' => ['required']
        ]);

        Survey::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'occupant' => $request->occupant,
            'children_education' => $request->children_education,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('survey.thanks')->with('status', 'Terima kasih telah memberikan tanggapan anda');
    }
}
