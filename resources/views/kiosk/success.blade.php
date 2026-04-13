<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check In Successful</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Auto redirect after 5 seconds back to kiosk -->
    <meta http-equiv="refresh" content="7;url={{ route('hub') }}" />
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center p-10">
        
        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-8">
            <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">You're Checked In!</h2>
        <p class="text-lg text-gray-600 mb-8">Please proceed to the security guard desk to receive your visitor badge.</p>
        
        <a href="{{ route('hub') }}" class="inline-flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-purple-600 hover:bg-purple-700 transition-colors">
            Return to Hub
        </a>
        <p class="text-sm text-gray-400 mt-6 mt-4">Screen will automatically refresh in 7 seconds...</p>
    </div>
</body>
</html>
