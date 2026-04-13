<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guard Kiosk - Shift Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 w-full max-w-4xl text-left">
        <a href="{{ route('hub') }}" class="text-gray-600 hover:text-gray-800 flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to UPSecurityHub
        </a>
    </div>

    <div class="max-w-4xl mx-auto w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-800 py-6 px-8 text-center text-white flex items-center justify-center space-x-4">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight text-left">Daily Activity Report (DAR)</h2>
                <p class="mt-1 text-gray-400 text-left text-sm">Security Guard Kiosk Submission</p>
            </div>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Errors found:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('guard_kiosk.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Core Submissions -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">1. Core Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="guard_id" class="block text-sm font-medium text-gray-700">Guard Name <span class="text-red-500">*</span></label>
                            <select name="guard_id" id="guard_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">
                                <option value="">-- Select Identity --</option>
                                @foreach($guards as $guard)
                                    <option value="{{ $guard->id }}" {{ old('guard_id') == $guard->id ? 'selected' : '' }}>{{ $guard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="report_date" class="block text-sm font-medium text-gray-700">Report Date <span class="text-red-500">*</span></label>
                            <input type="date" name="report_date" id="report_date" value="{{ old('report_date', date('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">
                        </div>

                        <div>
                            <label for="post_location" class="block text-sm font-medium text-gray-700">Post / Location <span class="text-red-500">*</span></label>
                            <input type="text" name="post_location" id="post_location" value="{{ old('post_location') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500" placeholder="e.g. Main Gate">
                        </div>

                        <div>
                            <label for="weather_conditions" class="block text-sm font-medium text-gray-700">Weather</label>
                            <input type="text" name="weather_conditions" id="weather_conditions" value="{{ old('weather_conditions') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500" placeholder="e.g. Clear, 72°F">
                        </div>

                        <div>
                            <label for="shift_start" class="block text-sm font-medium text-gray-700">Shift Start Time <span class="text-red-500">*</span></label>
                            <input type="time" name="shift_start" id="shift_start" value="{{ old('shift_start') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">
                        </div>
                        
                        <div>
                            <label for="shift_end" class="block text-sm font-medium text-gray-700">Shift End Time</label>
                            <input type="time" name="shift_end" id="shift_end" value="{{ old('shift_end') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">
                        </div>
                    </div>
                </div>

                <!-- Logs -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">2. Logs & Activity</h3>
                    <div class="space-y-6">
                        <div>
                            <label for="activity_entries" class="block text-sm font-medium text-gray-700 font-bold mb-1">Routine Activity Entries</label>
                            <p class="text-xs text-gray-500 mb-2">Log standard rounds, patrols, and regular occurrences here.</p>
                            <textarea name="activity_entries" id="activity_entries" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">{{ old('activity_entries') }}</textarea>
                        </div>
                        
                        <div>
                            <label for="incident_details" class="block text-sm font-medium text-gray-700 font-bold mb-1">Incident Details</label>
                            <p class="text-xs text-gray-500 mb-2">Record security breaches, rule violations, injuries, or unusual events.</p>
                            <textarea name="incident_details" id="incident_details" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">{{ old('incident_details') }}</textarea>
                        </div>
                        
                        <div>
                            <label for="handover_notes" class="block text-sm font-medium text-gray-700 font-bold mb-1">Handover Notes</label>
                            <p class="text-xs text-gray-500 mb-2">Notes or instructions to be passed onto the incoming guard.</p>
                            <textarea name="handover_notes" id="handover_notes" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">{{ old('handover_notes') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tech_access_logs" class="block text-sm font-medium text-gray-700 font-bold mb-1">Tech / Vendor Access Logs</label>
                                <textarea name="tech_access_logs" id="tech_access_logs" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">{{ old('tech_access_logs') }}</textarea>
                            </div>
                            
                            <div>
                                <label for="equipment_monitoring" class="block text-sm font-medium text-gray-700 font-bold mb-1">Equipment Monitoring</label>
                                <textarea name="equipment_monitoring" id="equipment_monitoring" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">{{ old('equipment_monitoring') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors">
                        Submit Daily Activity Report
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">This log acts as a legal binding contract of events during the specified shift.</p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
