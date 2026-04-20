<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Active Staff Monitor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6 flex justify-between items-center w-full">
            <a href="{{ route('hub') }}" class="text-blue-600 hover:text-blue-800 flex items-center font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to UPSecurityHub
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Active Staff Monitor</h1>
            <div class="w-24"></div> <!-- Placeholder for balancing -->
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex flex-col sm:flex-row justify-between sm:items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Currently Checked-In Staff ({{ $activeStaff->count() }})</h3>
                    <p class="mt-1 text-sm text-gray-500">List of all employees who are currently on the premises.</p>
                </div>
                <div class="mt-4 sm:mt-0 w-full sm:w-64">
                    <input type="text" id="zoneSearch" placeholder="Search by Office/Zone..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Office / Zone</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="staffTableBody">
                        @forelse($activeStaff as $attendance)
                            <tr class="staff-row" data-office="{{ strtolower($attendance->staff->office->name ?? '') }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $attendance->staff->firstName ?? '' }} {{ $attendance->staff->lastName ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $attendance->staff->office->name ?? 'N/A' }}</span>
                                        @if(optional($attendance->staff->office)->contact_person)
                                            <span class="text-xs text-gray-400">Team: {{ optional($attendance->staff->office)->contact_person }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($attendance->time_in)->format('M d, g:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <form action="{{ route('staff_kiosk.checkout', $attendance->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to check out this staff member?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Check Out
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No staff currently checked in.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('zoneSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    let filter = this.value.toLowerCase();
                    let rows = document.querySelectorAll('.staff-row');
                    
                    rows.forEach(row => {
                        let office = row.getAttribute('data-office');
                        if(office.includes(filter)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
