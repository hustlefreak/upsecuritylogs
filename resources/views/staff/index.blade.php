<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('staff.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add New Staff</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
                @endif

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID Number</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Office</th>
                            <th class="py-2 px-4 border-b">Team</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $member)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $member->staff_id_number }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $member->firstName }} {{ $member->lastName }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ optional($member->office)->name ?? 'No Office' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $member->contact_number }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('staff.edit', $member) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                                <form action="{{ route('staff.destroy', $member) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
