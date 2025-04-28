<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Handa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for Graphs -->
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-start p-8 space-y-8">

    <!-- Header with gray background -->
    <div class="flex items-center justify-between w-full max-w-5xl bg-gray-200 p-4 rounded-lg shadow-md">
        <!-- Left: Mapúa Logo -->
        <img src="{{ asset('images/Mapua.png') }}" alt="Mapúa Logo" class="h-12">

        <!-- Right: Project Handa -->
        <h1 class="text-3xl font-bold">PROJECT HANDA</h1>
    </div>

    <div class="bg-white p-8 rounded shadow-md w-full max-w-5xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Left side: Input form -->
            <div>
                <form action="{{ route('handa.predict') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <!-- Height -->
                    <div>
                        <label class="block font-semibold mb-1">Height (meters)</label>
                        <input type="number" name="height" class="w-full border rounded px-2 py-1" placeholder="Enter height" required min="1" max="18">
                    </div>

                    <!-- Building Category -->
                    <div>
                        <label class="block font-semibold mb-1">Building Category</label>
                        <select name="building_category" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select Category</option>
                            <option value="Group A">Group A – Residential Dwellings</option>
                            <option value="Group B">Group B – Residentials, Hotels and Apartments</option>
                            <option value="Group C">Group C – Education and Recreation</option>
                            <option value="Group D">Group D – Institutional</option>
                            <option value="Group E">Group E – Business and Mercantile</option>
                        </select>
                    </div>

                    <!-- Material Category -->
                    <div>
                        <label class="block font-semibold mb-1">Material Category</label>
                        <select name="material_category" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select Material</option>
                            <option value="Type I">Type I – Wood Construction</option>
                            <option value="Type II">Type II – Wood + Protective Fire-Resistive Materials</option>
                            <option value="Type III">Type III – Masonry and Wood Construction (1hr fire resistive)</option>
                            <option value="Type IV">Type IV – Steel, Iron, Concrete or Masonry (incombustible)</option>
                            <option value="Type V">Type V – Fire-resistive (Steel, Concrete, Masonry)</option>
                        </select>
                    </div>

                    <!-- Surface Roughness / Exposure Category -->
                    <div>
                        <label class="block font-semibold mb-1">Surface Roughness/Exposure Category</label>
                        <select name="surface_category" class="w-full border rounded px-2 py-1" required>
                            <option value="">Select Surface</option>
                            <option value="B">Surface Roughness B – Urban/Suburban areas</option>
                            <option value="C">Surface Roughness C – Open terrain with scattered obstructions</option>
                            <option value="D">Surface Roughness D – Flat unobstructed areas (mud flats, water)</option>
                        </select>
                    </div>

                    <!-- Typhoon Wind Speed -->
                    <div>
                        <label class="block font-semibold mb-1">Typhoon Wind Speed (km/h)</label>
                        <input type="number" name="wind_speed" class="w-full border rounded px-2 py-1" placeholder="Enter wind speed" required min="0" max="310">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="mt-4 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded">
                        PREDICT
                    </button>

                </form>
            </div>

            <!-- Right side: Prediction Result -->
            <div class="flex flex-col justify-center items-center border rounded p-4 bg-gray-50">
                <h2 class="text-2xl font-semibold mb-4">Prediction Result</h2>
                @if(session('prediction'))
                    <p class="text-lg text-center text-blue-600 font-bold">
                        {{ session('prediction') }}
                    </p>
                @else
                    <p class="text-gray-500 text-center">Result will appear here after submission.</p>
                @endif
            </div>

        </div>
    </div>

    <!-- Graph / Vulnerability Curve -->
    <div class="bg-white p-8 mt-8 rounded shadow-md w-full max-w-5xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Graph / Vulnerability Curves</h2>
        <canvas id="vulnerabilityChart" height="150"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('vulnerabilityChart').getContext('2d');
        const vulnerabilityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5'],
                datasets: [{
                    label: 'Expected Damage (%)',
                    data: [5, 20, 45, 70, 90],
                    backgroundColor: 'rgba(220, 38, 38, 0.2)', 
                    borderColor: 'rgba(220, 38, 38, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(220, 38, 38, 1)',
                    tension: 0.8, // This affects the overall curve
                    cubicInterpolationMode: 'monotone' // This ensures smooth interpolation
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Damage (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Building Category'
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
