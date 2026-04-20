<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight print:hidden">
            {{ __('View Shift Report: ') }} {{ $shiftReport->report_date->format('M d, Y') }}
        </h2>
    </x-slot>

    <div class="py-12 print:py-0 print:m-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 print:hidden flex justify-between">
                <a href="{{ route('shift_reports.index') }}" class="text-indigo-600 hover:underline">&larr; Back to Logs</a>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Print Report</button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:shadow-none">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    
                    <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
                        <h1 class="text-2xl font-bold uppercase tracking-widest">Daily Activity Report</h1>
                        <p class="text-md text-gray-500">Security & Information Logs</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8 text-sm">
                        <div><strong class="text-indigo-600">Date:</strong> <br>{{ $shiftReport->report_date->format('Y-m-d') }}</div>
                        <div><strong class="text-indigo-600">Shift Started:</strong> <br>{{ \Carbon\Carbon::parse($shiftReport->shift_start)->format('H:i') }}</div>
                        <div><strong class="text-indigo-600">Shift Ended:</strong> <br>{{ $shiftReport->shift_end ? \Carbon\Carbon::parse($shiftReport->shift_end)->format('H:i') : 'N/A' }}</div>
                        <div><strong class="text-indigo-600">Guard On Duty:</strong> <br>{{ $shiftReport->securityGuard_name ?? optional($shiftReport->securityGuard)->name }}</div>
                        <div><strong class="text-indigo-600">Post Location:</strong> <br>{{ $shiftReport->post_location ? $shiftReport->post_location : 'N/A' }}</div>
                        <div><strong class="text-indigo-600">Weather:</strong> <br>{{ $shiftReport->weather_conditions ? $shiftReport->weather_conditions : 'N/A' }}</div>
                    </div>

                    <div class="space-y-6">
                        @if($shiftReport->activity_entries)
                        <div>
                            <h3 class="font-bold text-lg text-indigo-600 border-b pb-1 mb-2">Activities & Patrols</h3>
                            <p class="whitespace-pre-wrap text-sm">{{ $shiftReport->activity_entries }}</p>
                        </div>
                        @endif

                        @if($shiftReport->incident_details)
                        <div>
                            <h3 class="font-bold text-lg text-red-600 border-b border-red-200 pb-1 mb-2">Incident Details</h3>
                            <p class="whitespace-pre-wrap text-sm">{{ $shiftReport->incident_details }}</p>
                        </div>
                        @endif

                        @if($shiftReport->handover_notes)
                        <div>
                            <h3 class="font-bold text-lg text-indigo-600 border-b pb-1 mb-2">Handover Notes</h3>
                            <p class="whitespace-pre-wrap text-sm">{{ $shiftReport->handover_notes }}</p>
                        </div>
                        @endif

                        @if($shiftReport->tech_access_logs)
                        <div>
                            <h3 class="font-bold text-lg text-indigo-600 border-b pb-1 mb-2">Tech Access Logs</h3>
                            <p class="whitespace-pre-wrap text-sm">{{ $shiftReport->tech_access_logs }}</p>
                        </div>
                        @endif

                        @if($shiftReport->equipment_monitoring)
                        <div>
                            <h3 class="font-bold text-lg text-indigo-600 border-b pb-1 mb-2">Equipment Monitoring</h3>
                            <p class="whitespace-pre-wrap text-sm">{{ $shiftReport->equipment_monitoring }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-400 flex justify-between print:flex">
                        <div class="w-48 text-center">
                            <div class="border-b border-gray-800 h-8 mb-2"></div>
                            <p class="text-xs uppercase">Guard Signature</p>
                        </div>
                        <div class="w-48 text-center">
                            <div class="border-b border-gray-800 h-8 mb-2"></div>
                            <p class="text-xs uppercase">Supervisor Review</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { font-size: 12pt; background-color: white; }
            nav, header, footer { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; }
            .max-w-4xl { max-width: 100% !important; margin: 0 !important; }
        }
    </style>
</x-app-layout>
