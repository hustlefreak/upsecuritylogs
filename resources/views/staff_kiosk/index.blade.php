<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php $favicon = \App\Models\Setting::get('favicon_icon'); @endphp
    @if($favicon) <link rel="icon" href="{{ $favicon }}"> @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Kiosk - Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 lg:px-8">                    
    <div class="mb-6 w-full max-w-md text-left">
        <a href="{{ route('hub') }}" class="text-blue-600 hover:text-blue-800 flex items-center font-medium">                                                               <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>                                             Back to UPSecurityHub
        </a>
    </div>

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 py-6 px-8 text-center text-white">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>              <h2 class="text-3xl font-extrabold tracking-tight">Staff Portal</h2>
            <p class="mt-2 text-blue-100">Clock in or out of your shift.</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Invalid selection. Please try again.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('staff_kiosk.process') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="office_id" class="block text-sm font-medium text-gray-700">Office / Zone</label>                              
                    <select name="office_id" id="office_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-base py-3 bg-white" onchange="filterStaff()">                                           <option value="">-- Select Office --</option>                                                                               
                        @foreach($offices as $office)                                                       
                            <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>                              
                                {{ $office->name }} {{ $office->contact_person ? ' - Team: ' . $office->contact_person : '' }}                                                         
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="staff_id" class="block text-sm font-medium text-gray-700">Staff Member</label>                                
                    <select name="staff_id" id="staff_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-base py-3 bg-white">                                                          
                        <option value="">-- Select Your Name --</option>                                    
                        @foreach($staff as $person)
                            <option value="{{ $person->id }}" data-office="{{ $person->office_id }}" {{ old('staff_id') == $person->id ? 'selected' : '' }}>
                                {{ $person->firstName }} {{ $person->lastName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Clock In / Out
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            filterStaff();
        });

        function filterStaff() {
            var officeSelect = document.getElementById("office_id");
            var staffSelect = document.getElementById("staff_id");
            
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
        
        document.getElementById("staff_id").addEventListener("change", function() {                                                                       
            var selectedOption = this.options[this.selectedIndex];                          
            if (selectedOption.value !== "") {
                var correspondingOffice = selectedOption.getAttribute("data-office");                                                                           
                if (correspondingOffice) {                                                          
                    document.getElementById("office_id").value = correspondingOffice;                                                                           
                    filterStaff();                                                              
                }
            }
        });
    </script>
</body>
</html>
