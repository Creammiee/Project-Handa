<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HandaController extends Controller
{
    public function predict(Request $request)
    {
        $validated = $request->validate([
            'height' => 'required|numeric|between:4,18',
            'building_category' => 'required',
            'material_category' => 'required',
            'surface_category' => 'required',
            'wind_speed' => 'required|numeric|between:16,310',
        ]);

        $building_map = [
            'Group A' => 1,
            'Group B' => 2,
            'Group C' => 3,
            'Group D' => 4,
            'Group E' => 5
        ];

        $material_map = [
            'Type I' => 1,
            'Type II' => 2,
            'Type III' => 3,
            'Type IV' => 4,
            'Type V' => 5
        ];

        $surface_map = [
            'B' => 1,
            'C' => 2,
            'D' => 3
        ];

        $features = [
            (float) $validated['height'],
            (float) ($building_map[$validated['building_category']] ?? 0),
            (float) ($material_map[$validated['material_category']] ?? 0),
            (float) ($surface_map[$validated['surface_category']] ?? 0),
            (float) $validated['wind_speed']
        ];

        $response = Http::post('http://127.0.0.1:5000/predict', ['features' => $features]);

        logger($response->body());

        // Extract the first value from the prediction array
        $prediction = $response->json()['prediction'][0] ?? 'Prediction unavailable';

        return redirect()->route('handa.view')->with('prediction', $prediction);
    }
}
