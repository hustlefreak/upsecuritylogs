<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Shift Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form method="POST" action="{{ route('shift_reports.store') }}">
                        @csrf
                        
                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">1. Core Header Fields</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Date</label>
                                <input type="date" name="report_date" value="{{ old('report_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Shift Start Time</label>
                                <input type="time" name="shift_start" value="{{ old('shift_start') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Shift End Time</label>
                                <input type="time" name="shift_end" value="{{ old('shift_end') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Guard Name / ID</label>
                                <input type="text" name="guard_name" value="{{ old('guard_name', Auth::user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Post Location</label>
                                <input type="text" name="post_location" value="{{ old('post_location') }}" placeholder="e.g. Main Gate, Building A" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Weather Conditions</label>
                                <input type="text" name="weather_conditions" value="{{ old('weather_conditions') }}" placeholder="e.g. Clear, Raining" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">2. Activity Entries</h3>
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Patrol routes, inspection areas, status checks, visitor logs (Use timestamps)</label>
                            <textarea name="activity_entries" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="08:00 - Commenced patrol in Zone A...&#10;09:15 - Checked back gate, all secure...">{{ old('activity_entries') }}</textarea>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">3. Incident Details</h3>
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">What happened, where, when, involved parties, actions taken, follow-up.</label>
                            <textarea name="incident_details" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('incident_details') }}</textarea>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">4. Handover Notes</h3>
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Pending tasks, ongoing issues, instructions for the next shift.</label>
                            <textarea name="handover_notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('handover_notes') }}</textarea>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">5. Tech Access Logs</h3>
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">Server room entries, data center door checks, badge scans authorization.</label>
                            <textarea name="tech_access_logs" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('tech_access_logs') }}</textarea>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-2">6. Equipment Monitoring</h3>
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700 mb-1">CCTV feeds, alarm systems, UPS backups, HVAC status.</label>
                            <textarea name="equipment_monitoring" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('equipment_monitoring') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="text-sm text-gray-600 hover:text-gray-900 mr-4" href="{{ route('shift_reports.index') }}">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Shift Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
