<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Visitors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('visitors.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Pre-Register New Visitor</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">{{ session('success') }}</div>
                @endif

                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Reason for Visit</th>
                            <th class="py-2 px-4 border-b">Company</th>
                            <th class="py-2 px-4 border-b">ID/License #</th>
                            <th class="py-2 px-4 border-b">Phone</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors as $visitor)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{ $visitor->firstName }} {{ $visitor->lastName }}</td>
                            <td class="py-2 px-4 border-b text-center text-sm truncate max-w-xs" title="{{ $visitor->reason_for_visit }}">{{ $visitor->reason_for_visit ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $visitor->company ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $visitor->id_number ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $visitor->phone ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{ route('visitors.edit', $visitor) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                                <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" class="inline">
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
