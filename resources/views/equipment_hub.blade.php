<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equipment Hub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-100 to-indigo-50">

    <div class="mb-6 w-full max-w-md text-left">
        <a href="{{ route('hub') }}" class="text-blue-600 hover:text-blue-800 flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to UPSecurityHub
        </a>
    </div>

    <div class="max-w-md w-full bg-orange-50 rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-orange-600 py-6 px-8 text-center text-white" style="background-color: #F97316 !important;">
            @php $equipIcon = \App\Models\Setting::get('hub_equipment_icon'); @endphp
            @if($equipIcon)
                <img src="{{ $equipIcon }}" alt="Equipment Icon" class="w-16 h-16 mx-auto mb-4 rounded-full bg-white p-1" />
            @else
                <svg class="w-16 h-16 mx-auto mb-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"></path></svg>
            @endif
            <h2 class="text-3xl font-extrabold tracking-tight">Equipment Hub</h2>
            <p class="mt-2 text-orange-100">Pull out or return facility equipment.</p>
        </div>

        <div class="p-8">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('equipment.process') }}" method="POST" class="space-y-6 rounded-lg">
            @csrf
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700">Your Name</label>
                <input type="text" name="user_name" id="user_name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
            </div>

            <div>
                <label for="equipment_name" class="block text-sm font-medium text-gray-700">Equipment Name</label>
                <input type="text" name="equipment_name" id="equipment_name" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand <span class="text-gray-400 font-normal">(Optional)</span></label>
                    <input type="text" name="brand" id="brand" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
                </div>
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Model <span class="text-gray-400 font-normal">(Optional)</span></label>
                    <input type="text" name="model" id="model" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
                </div>
            </div>

            <div>
                <label for="serial_numbers" class="block text-sm font-medium text-gray-700">Serial Number(s) <span class="text-gray-400 font-normal">(Optional, comma-separated)</span></label>
                <textarea name="serial_numbers" id="serial_numbers" rows="2" placeholder="e.g. SN-001, SN-002" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border text-gray-700"></textarea>
            </div>

            <div>
                <label for="action" class="block text-sm font-medium text-gray-700">Action</label>
                <select name="action" id="action" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
                    <option value="pulled_out">Pull Out</option>
                    <option value="returned">Return</option>
                </select>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" required min="1" value="1" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border">
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit
            </button>
        </form>

        
    </div>
</body>
</html>
