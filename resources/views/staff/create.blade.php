<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Staff Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('staff.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                        <input type="text" name="firstName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                        <input type="text" name="lastName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Staff ID Number:</label>
                        <input type="text" name="staff_id_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Office:</label>
                        <select name="office_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Team (select):</label>
                        <select id="team_select" name="team_select" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">-- Select Team (optional) --</option>
                            @php
                                $teams = $offices->pluck('contact_person')->filter()->unique();
                            @endphp
                            @foreach($teams as $team)
                                <option value="{{ $team }}">{{ $team }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Selecting an Office will automatically set the Team; changing Team will not alter the selected Office.</p>
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
                    <a href="{{ route('staff.index') }}" class="text-gray-600 ml-4 hover:underline">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var officeSelect = document.querySelector('select[name="office_id"]');
            var teamSelect = document.getElementById('team_select');
            var officeMap = {};
            @foreach($offices as $office)
                officeMap['{{ $office->id }}'] = `{{ $office->contact_person ?? '' }}`;
            @endforeach

            function syncTeam() {
                var selected = officeSelect.value;
                if (!selected) return;
                var team = officeMap[selected] || '';
                if (team) {
                    var opt = Array.from(teamSelect.options).find(o => o.value === team);
                    if (!opt) {
                        var newOpt = document.createElement('option');
                        newOpt.value = team; newOpt.text = team; teamSelect.appendChild(newOpt);
                    }
                    teamSelect.value = team;
                } else {
                    teamSelect.value = '';
                }
            }

            officeSelect.addEventListener('change', syncTeam);
            syncTeam();
        });
    </script>
</x-app-layout>
