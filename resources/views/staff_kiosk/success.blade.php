<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Successfully Clocked {{ session('action') === 'in' ? 'In' : 'Out' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="5;url={{ route('hub') }}" />
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center p-10">
        
        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-100 mb-8">
            <svg class="h-16 w-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Hello, {{ session('staff_name') }}!</h2>
        <p class="text-lg text-gray-600 mb-8">You have successfully clocked <strong class="{{ session('action') === 'in' ? 'text-green-600' : 'text-red-600' }}">{{ strtoupper(session('action')) }}</strong>.</p>
        
        <a href="{{ route('hub') }}" class="inline-flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
            Return to Hub
        </a>
        <p class="text-sm text-gray-400 mt-6 mt-4">Screen will automatically refresh in 5 seconds...</p>
    </div>
</body>
</html>
