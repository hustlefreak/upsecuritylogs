<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daily Guard Shift Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <p class="text-gray-600">Track and manage comprehensive daily activity logs.</p>
                <a href="{{ route('shift_reports.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Log New Shift Report
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-3 px-4 border-b">Date</th>
                                <th class="py-3 px-4 border-b">Shift Time</th>
                                <th class="py-3 px-4 border-b">Location</th>
                                <th class="py-3 px-4 border-b">Logger</th>
                                <th class="py-3 px-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="py-3 px-4">{{ $report->report_date->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($report->shift_start)->format('H:i') }} - {{ $report->shift_end ? \Carbon\Carbon::parse($report->shift_end)->format('H:i') : 'Ongoing' }}</td>
                                <td class="py-3 px-4">{{ $report->post_location }}</td>
                                <td class="py-3 px-4">{{ $report->securityGuard_name ?? optional($report->securityGuard)->name }}</td>
                                <td class="py-3 px-4 flex justify-center gap-2">
                                    <a href="{{ route('shift_reports.show', $report->id) }}" class="text-sm px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">View</a>
                                    <a href="{{ route('shift_reports.edit', $report->id) }}" class="text-sm px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                                    <form action="{{ route('shift_reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Delete this shift report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">No shift reports found. Create one.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
