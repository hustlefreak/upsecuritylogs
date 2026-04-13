<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Equipment Status Tabulation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 print:hidden">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold">Current Equipment Status</h3>
                        
                        <form action="{{ route('equipment.logs') }}" method="GET" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, brand, model, serial..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-1 w-64">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm font-semibold shadow-sm">Search</button>
                            @if(request('search'))
                                <a href="{{ route('equipment.logs') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm font-semibold shadow-sm flex items-center">Clear</a>
                            @endif
                        </form>
                    </div>
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial No(s)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quick Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($equipment as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->brand ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->model ?: '-' }}</td>
                                    <td class="px-6 py-4" style="max-width: 15rem; word-wrap: break-word;">{{ $item->serial_numbers ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($item->status === 'available')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pulled Out</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            <form action="{{ route('equipment.process') }}" method="POST" class="flex gap-1 items-center">
                                                @csrf
                                                <input type="hidden" name="equipment_id" value="{{ $item->id }}">
                                                <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $item->quantity > 0 ? $item->quantity : '' }}" class="w-16 rounded border-gray-300 shadow-sm text-xs px-2 py-1">
                                                @if($item->status === 'available')
                                                    <input type="hidden" name="action" value="pulled_out">
                                                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm">Pull Out</button>
                                                @else
                                                    <input type="hidden" name="action" value="returned">
                                                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm">Return</button>
                                                @endif
                                            </form>
                                            
                                            <button type="button" onclick="let newName = prompt('Enter new equipment name:', '{{ addslashes($item->name) }}'); let newBrand = prompt('Enter new brand:', '{{ addslashes($item->brand) }}'); let newModel = prompt('Enter new model:', '{{ addslashes($item->model) }}'); let newSerials = prompt('Enter serial number(s) (comma separated):', '{{ addslashes($item->serial_numbers) }}'); let newQty = prompt('Enter new quantity:', '{{ $item->quantity }}'); if(newName && newQty) { document.getElementById('edit-name-{{ $item->id }}').value = newName; document.getElementById('edit-brand-{{ $item->id }}').value = newBrand || ''; document.getElementById('edit-model-{{ $item->id }}').value = newModel || ''; document.getElementById('edit-serials-{{ $item->id }}').value = newSerials || ''; document.getElementById('edit-qty-{{ $item->id }}').value = newQty; document.getElementById('edit-form-{{ $item->id }}').submit(); }" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm">Edit</button>

                                            <form id="edit-form-{{ $item->id }}" action="{{ route('equipment.update', $item->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="name" id="edit-name-{{ $item->id }}" value="">
                                                <input type="hidden" name="brand" id="edit-brand-{{ $item->id }}" value="">
                                                <input type="hidden" name="model" id="edit-model-{{ $item->id }}" value="">
                                                <input type="hidden" name="serial_numbers" id="edit-serials-{{ $item->id }}" value="">
                                                <input type="hidden" name="quantity" id="edit-qty-{{ $item->id }}" value="">
                                            </form>

                                            <form action="{{ route('equipment.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

                    </div>
    </div>
</x-app-layout>