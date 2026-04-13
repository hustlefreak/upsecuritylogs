<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visitor Kiosk - Check In</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-6 w-full max-w-2xl text-left">
        <a href="{{ route('hub') }}" class="text-purple-600 hover:text-purple-800 flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to UPSecurityHub
        </a>
    </div>

    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-purple-700 py-6 px-8 text-center text-white">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
            <h2 class="text-3xl font-extrabold tracking-tight">Visitor Check-In</h2>
            <p class="mt-2 text-purple-100">Welcome! Please fill out the form below to sign in.</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('kiosk.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Info -->
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="firstName" id="firstName" value="{{ old('firstName') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3">
                    </div>

                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="lastName" id="lastName" value="{{ old('lastName') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3">
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700">Your Company</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3">
                    </div>

                    <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                        <label for="reason_for_visit" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit <span class="text-red-500">*</span></label>
                        <textarea name="reason_for_visit" id="reason_for_visit" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3" placeholder="I am here to see..."></textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Who are you visiting?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="office_id" class="block text-sm font-medium text-gray-700">Office / Zone</label>
                                <select name="office_id" id="office_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3 bg-white" onchange="filterStaff()">
                                    <option value="">-- Select Office --</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }} {{ $office->contact_person ? ' - Team: ' . $office->contact_person : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="staff_to_visit" class="block text-sm font-medium text-gray-700">Person to Visit</label>
                                    <div class="text-xs">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="toggleManualPerson" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 mr-1">
                                            <span class="text-gray-600">Enter Manually</span>
                                        </label>
                                    </div>
                                </div>
                                <div id="personSelectContainer">
                                    <select name="staff_to_visit" id="staff_to_visit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3 bg-white">
                                        <option value="">-- Select Person to Visit --</option>
                                            @foreach($staff as $person)
                                                <option value="{{ $person->id }}" data-office="{{ $person->office_id }}" {{ old('staff_to_visit') == $person->id ? 'selected' : '' }}>
                                                    {{ $person->firstName }} {{ $person->lastName }}
                                                </option>
                                            @endforeach
                                    </select>
                                </div>
                                <div id="personManualContainer" class="hidden mt-1">
                                    <input type="text" name="person_to_visit_name" id="person_to_visit_name" value="{{ old('person_to_visit_name') }}" placeholder="Type specific name..." class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-base py-3">
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Please select either the person you are visiting, their office, or both.</p>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                        Complete Check In
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">By continuing, you agree to comply with facility security policies.</p>
                </div>
            </form>
        </div>
    </div>

    <!-- Script to filter staff based on office selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initial filter run in case there's an old value after validation error
            filterStaff();
        });

        function filterStaff() {
            var officeSelect = document.getElementById("office_id");
            var staffSelect = document.getElementById("staff_to_visit");
            
            var selectedOffice = officeSelect.value;
            var staffOptions = staffSelect.querySelectorAll("option");

            staffOptions.forEach(function(option) {
                // Always show the default "-- Select Staff --" option
                if (option.value === "") {
                    return;
                }

                var staffOffice = option.getAttribute("data-office");

                // If no office is selected, or if the staff belongs to the selected office, show the option
                if (!selectedOffice || staffOffice === selectedOffice) {
                    option.style.display = "";
                } else {
                    option.style.display = "none";
                    // If the currently selected staff is being hidden, unselect it
                    if (option.selected) {
                        staffSelect.value = "";
                    }
                }
            });
        }
        
        // Also automatically select the office if a staff member is manually chosen
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
        document.getElementById('toggleManualPerson').addEventListener('change', function() {
            var selectContainer = document.getElementById('personSelectContainer');
            var manualContainer = document.getElementById('personManualContainer');
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
</body>
</html>
