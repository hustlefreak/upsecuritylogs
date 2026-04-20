<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight print:hidden">
            {{ __('Export & Print Activity Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 print:py-0 print:m-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 print:hidden">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-end gap-3 w-full">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="staff" {{ $type == 'staff' ? 'selected' : '' }}>Staff Report</option>
                            <option value="visitor" {{ $type == 'visitor' ? 'selected' : '' }}>Visitor Report</option>
                            <option value="equipment" {{ $type == 'equipment' ? 'selected' : '' }}>Equipment Logs</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" value="{{ $date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">View Data</button>
                    
                    <div class="flex gap-2 md:ml-auto">
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print
                        </button>
                        <a href="{{ route('reports.export', ['type' => $type, 'date' => $date]) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:ring-2 focus:ring-green-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export to CSV
                        </a>
                    </div>
                </form>
            </div>

            <div class="hidden print:block mb-4">
                <h1 class="text-2xl font-bold text-center">Facility Security Log</h1>
                <p class="text-center text-gray-600">Report Type: {{ ucfirst($type) }} | Date: {{ $date }} | Printed: {{ date('Y-m-d H:i') }}</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 print:shadow-none print:p-0">
                <h3 class="text-lg font-bold mb-4 print:hidden">Report Data Preview</h3>
                <div class="overflow-x-auto print:overflow-visible">
                    <table class="min-w-full bg-white border border-gray-200 text-sm print:border-collapse">
                        @if($type === 'visitor')
                        <thead class="bg-gray-50 print:bg-white text-left">
                            <tr>
                                <th class="py-2 px-4 border-b print:border border-gray-300">#</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Visitor Name</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Company</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Purpose</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Host/Location</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Time In</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="py-2 px-4 border-b print:border border-gray-300 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 font-medium">{{ $row->visitor->firstName }} {{ $row->visitor->lastName }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->visitor->company ?? '-' }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ Str::limit($row->purpose, 40) }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 text-gray-600">
                                    {{ optional($row->staff)->firstName ? $row->staff->firstName . ' ' . $row->staff->lastName : ($row->person_to_visit_name ?? '') }}
                                    @if($row->office_id)
                                    ({{ optional($row->office)->name }})
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->time_in ? $row->time_in->format('H:i') : '' }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->time_out ? $row->time_out->format('H:i') : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                                                @elseif($type === 'equipment')
                        <thead class="bg-gray-50 print:bg-white text-left">
                            <tr>
                                <th class="py-2 px-4 border-b print:border border-gray-300">#</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Date & Time</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Equipment</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Brand</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Model</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Serial No(s)</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Qty</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">User Staff</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Action Taken</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="py-2 px-4 border-b print:border border-gray-300 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 whitespace-nowrap">{{ $row->created_at->format('H:i A') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->equipment_name ?? ($row->equipment ? $row->equipment->name : '') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->brand ?? ($row->equipment ? $row->equipment->brand : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->model ?? ($row->equipment ? $row->equipment->model : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300" style="max-width: 15rem; word-wrap: break-word;">{{ $row->serial_numbers ?? ($row->equipment ? $row->equipment->serial_numbers : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->quantity }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->user_name }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">
                                    @if($row->action === 'pulled_out')
                                        <span class="text-orange-600 font-semibold print:text-black">Pulled Out</span>
                                    @else
                                        <span class="text-indigo-600 font-semibold print:text-black">Returned</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <thead class="bg-gray-50 print:bg-white text-left">
                            <tr>
                                <th class="py-2 px-4 border-b print:border border-gray-300">#</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Staff Name</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Staff ID</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Office</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Time In</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Time Out</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="py-2 px-4 border-b print:border border-gray-300 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 font-medium">{{ $row->staff->firstName }} {{ $row->staff->lastName }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 font-mono text-xs">{{ $row->staff->staff_id_number }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ optional($row->staff->office)->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->time_in ? $row->time_in->format('H:i') : '' }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->time_out ? $row->time_out->format('H:i') : '' }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ ucfirst($row->status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                    
                    @if($data->isEmpty())
                        <div class="py-8 text-center text-gray-500 italic border border-t-0 print:border border-gray-200">No records found for the selected date.</div>
                                            @elseif($type === 'equipment')
                        <thead class="bg-gray-50 print:bg-white text-left">
                            <tr>
                                <th class="py-2 px-4 border-b print:border border-gray-300">#</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Date & Time</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Equipment</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Brand</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Model</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Serial No(s)</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Qty</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">User Staff</th>
                                <th class="py-2 px-4 border-b print:border border-gray-300">Action Taken</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                            <tr>
                                <td class="py-2 px-4 border-b print:border border-gray-300 text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300 whitespace-nowrap">{{ $row->created_at->format('H:i A') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->equipment_name ?? ($row->equipment ? $row->equipment->name : '') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->brand ?? ($row->equipment ? $row->equipment->brand : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->model ?? ($row->equipment ? $row->equipment->model : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300" style="max-width: 15rem; word-wrap: break-word;">{{ $row->serial_numbers ?? ($row->equipment ? $row->equipment->serial_numbers : '-') }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->quantity }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">{{ $row->user_name }}</td>
                                <td class="py-2 px-4 border-b print:border border-gray-300">
                                    @if($row->action === 'pulled_out')
                                        <span class="text-orange-600 font-semibold print:text-black">Pulled Out</span>
                                    @else
                                        <span class="text-indigo-600 font-semibold print:text-black">Returned</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        <div class="hidden print:flex justify-between mt-12 pt-8 border-t border-gray-400">
                            <div class="text-center w-64">
                                <div class="border-b border-gray-600 h-8 mb-2"></div>
                                <span class="text-xs uppercase tracking-wider">Guard Signature</span>
                            </div>
                            <div class="text-center w-64">
                                <div class="border-b border-gray-600 h-8 mb-2"></div>
                                <span class="text-xs uppercase tracking-wider">Supervisor Signature</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    <!-- Print styling rules to hide main navigation and clean up margins -->
    <style>
        @media print {
            body { font-size: 11pt; background-color: white; }
            nav, header, footer { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; }
            .max-w-7xl { max-w: 100% !important; margin: 0 !important; width: 100% !important; }
            @page { margin: 1cm; size: landscape; }
        }
    </style>
</x-app-layout>
