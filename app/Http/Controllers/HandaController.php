<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandaController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'height' => 'required|numeric',
            'building_category' => 'required',
            'material_category' => 'required',
            'surface_category' => 'required',
            'wind_speed' => 'required|numeric',
        ]);

        // Dummy prediction logic (you can replace this with ML API)
        $height = $request->input('height');
        $wind_speed = $request->input('wind_speed');

        // Basic fake calculation
        $risk_score = ($height * 0.5) + ($wind_speed * 1.2);

        if ($risk_score > 300) {
            $prediction = "Severe Damage Possible.";
        } elseif ($risk_score > 150) {
            $prediction = "Moderate Damage Possible.";
        } else {
            $prediction = "Minor Damage Possible.";
        }

        return redirect()->route('handa.view')->with('prediction', $prediction);
    }
}
