<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Staff: ') }} {{ $staff->firstName }} {{ $staff->lastName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block font-medium text-sm text-gray-700">First Name</label>
                                <input id="firstName" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="firstName" value="{{ old('firstName', $staff->firstName) }}" required autofocus />
                            </div>
                            <div>
                                <label for="lastName" class="block font-medium text-sm text-gray-700">Last Name</label>
                                <input id="lastName" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="lastName" value="{{ old('lastName', $staff->lastName) }}" required />
                            </div>
                            <div>
                                <label for="staff_id_number" class="block font-medium text-sm text-gray-700">Staff ID Number</label>
                                <input id="staff_id_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="staff_id_number" value="{{ old('staff_id_number', $staff->staff_id_number) }}" required />
                            </div>
                            <div>
                                <label for="contact_number" class="block font-medium text-sm text-gray-700">Team</label>
                                <input id="contact_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="contact_number" value="{{ old('contact_number', $staff->contact_number) }}" />
                            </div>
                            <div class="md:col-span-2">
                                <label for="office_id" class="block font-medium text-sm text-gray-700">Assigned Office / Department</label>
                                <select id="office_id" name="office_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @foreach(\App\Models\Office::all() as $office)
                                        <option value="{{ $office->id }}" {{ $staff->office_id == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('staff.index') }}">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Staff
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
