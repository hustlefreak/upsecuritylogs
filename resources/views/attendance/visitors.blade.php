<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visitor Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Check In Form (Guard Only) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                <h3 class="text-lg font-bold mb-4">New Visitor Registration</h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('attendance.visitors.checkin') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <x-input-label for="visitor_id" value="Select Returning Visitor" />
                        <select name="visitor_id" id="visitor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Or Create New Below --</option>
                            @foreach($visitorsList as $visitor)
                                <option value="{{ $visitor->id }}">{{ $visitor->firstName }} {{ $visitor->lastName }} ({{ $visitor->company ?? 'Individual' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <x-input-label for="firstName" value="First Name" />
                            <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="old('firstName')" />
                        </div>
                        <div>
                            <x-input-label for="lastName" value="Last Name" />
                            <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="company" value="Company (Optional)" />
                        <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')" />
                    </div>

                    <div>
                        <x-input-label for="purpose" value="Purpose of Visit" />
                        <x-text-input id="purpose" class="block mt-1 w-full" type="text" name="purpose" required />
                    </div>

                    <div>
                        <x-input-label for="office_id" value="Offices / Zones" />
                        <select name="office_id" id="office_id" onchange="filterStaff()" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Select Office --</option>
                            @foreach($officeList as $office)
                                <option value="{{ $office->id }}">{{ $office->name }} {{ $office->contact_person ? " - Team: ". $office->contact_person : "" }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="staff_to_visit" value="Host/Staff Member" />
                            <div class="text-xs">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="toggleInternalManualPerson" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 mr-1">
                                    <span class="text-gray-600">Enter Manually</span>
                                </label>
                            </div>
                        </div>
                        <div id="internalPersonSelectContainer">
                            <select name="staff_to_visit" id="staff_to_visit" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Select Staff --</option>
                                @foreach($staffList as $person)
                                    <option value="{{ $person->id }}" data-office="{{ $person->office_id }}">{{ $person->firstName }} {{ $person->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="internalPersonManualContainer" class="hidden mt-1">
                            <input type="text" name="person_to_visit_name" id="person_to_visit_name" placeholder="Type specific name..." class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="md:col-span-2 flex justify-end mt-4">
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Check In Visitor</button>
                    </div>
                </form>
            </div>

            <!-- Main Log / Check Out Panel -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold">Visitor Logs ({{ $date }})</h3>
                    <form method="GET" action="{{ route('attendance.visitors') }}" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ $date }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-4 border-b">Visitor Name</th>
                                <th class="py-2 px-4 border-b">Purpose</th>
                                <th class="py-2 px-4 border-b">Host / Zone</th>
                                <th class="py-2 px-4 border-b">Time In</th>
                                <th class="py-2 px-4 border-b">Time Out</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $log)
                            <tr>
                                <td class="py-2 px-4 border-b text-center">{{ $log->visitor->firstName }} {{ $log->visitor->lastName }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->purpose }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    @if(optional($log->staff)->firstName)
                                        <div>{{ optional($log->staff)->firstName }} {{ optional($log->staff)->lastName }}</div>
                                    @elseif($log->person_to_visit_name)
                                        <div>{{ $log->person_to_visit_name }}</div>
                                    @endif
                                    @if($log->office_id)
                                        <div class="text-sm text-gray-500">{{ optional($log->office)->name }}@if(optional($log->office)->contact_person) <span> (Team: {{ optional($log->office)->contact_person }})</span>@endif</div>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->time_in ? $log->time_in->format('H:i') : '-' }}</td>
                                <td class="py-2 px-4 border-b text-center">{{ $log->time_out ? $log->time_out->format('H:i') : '-' }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    @if(!$log->time_out)
                                        <form action="{{ route('attendance.visitors.checkout') }}" method="POST" class="flex flex-col items-center gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="attendance_id" value="{{ $log->id }}">
                                            <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Check Out</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Checked Out</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($attendances->isEmpty())
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">No visitors found for this date.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            filterStaff();
        });

        function filterStaff() {
            var officeSelect = document.getElementById("office_id");
            var staffSelect = document.getElementById("staff_to_visit");
            
            var selectedOffice = officeSelect.value;
            var staffOptions = staffSelect.querySelectorAll("option");

            staffOptions.forEach(function(option) {
                if (option.value === "") {
                    return;
                }

                var staffOffice = option.getAttribute("data-office");

                if (!selectedOffice || staffOffice === selectedOffice) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                    if (option.selected) {
                        staffSelect.value = "";
                    }
                }
            });
        }
        
        document.getElementById("staff_to_visit").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                var correspondingOffice = selectedOption.getAttribute("data-office");
                if (correspondingOffice) {
                    document.getElementById("office_id").value = correspondingOffice;
                    filterStaff();
                }
            }
        });

        // Toggle Manual Person Insert
        document.getElementById('toggleInternalManualPerson').addEventListener('change', function() {
            var selectContainer = document.getElementById('internalPersonSelectContainer');
            var manualContainer = document.getElementById('internalPersonManualContainer');
            var selectElement = document.getElementById('staff_to_visit');
            var manualElement = document.getElementById('person_to_visit_name');

            if (this.checked) {
                selectContainer.classList.add('hidden');
                manualContainer.classList.remove('hidden');
                selectElement.value = ''; // clear select
            } else {
                selectContainer.classList.remove('hidden');
                manualContainer.classList.add('hidden');
                manualElement.value = ''; // clear manual input
            }
        });
    </script>
</x-app-layout>
