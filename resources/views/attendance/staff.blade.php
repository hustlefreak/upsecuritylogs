<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Logs (Attendance)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Check In Staff</h3>
                <form action="{{ route('attendance.staff.checkin') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Select Staff</label>
                        <select name="staff_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Choose Staff --</option>
                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->firstName }} {{ $staff->lastName }} ({{ $staff->staff_id_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Check In</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Today's Logs ({{ $date }})</h3>
                    <form method="GET" action="{{ route('attendance.staff') }}" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ $date }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
                @endif
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-4 border-b">Staff Name</th>
                                <th class="py-2 px-4 border-b">ID Number</th>
                                <th class="py-2 px-4 border-b">Office</th>
                                <th class="py-2 px-4 border-b">Time In</th>
                                <th class="py-2 px-4 border-b">Time Out</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $log)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">{{ $log->staff->firstName }} {{ $log->staff->lastName }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->staff->staff_id_number }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ optional($log->staff->office)->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->time_in ? $log->time_in->format('H:i:s') : '-' }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->time_out ? $log->time_out->format('H:i:s') : '-' }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    @if(!$log->time_out)
                                        <form action="{{ route('attendance.staff.checkout') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="attendance_id" value="{{ $log->id }}">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">Check Out</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Checked Out</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($attendances->isEmpty())
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">No logs found for this date.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
