<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Visitor: ') }} {{ $visitor->firstName }} {{ $visitor->lastName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form method="POST" action="{{ route('visitors.update', $visitor->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block font-medium text-sm text-gray-700">First Name</label>
                                <input id="firstName" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="firstName" value="{{ old('firstName', $visitor->firstName) }}" required autofocus />
                            </div>
                            <div>
                                <label for="lastName" class="block font-medium text-sm text-gray-700">Last Name</label>
                                <input id="lastName" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="lastName" value="{{ old('lastName', $visitor->lastName) }}" required />
                            </div>
                            <div>
                                <label for="id_number" class="block font-medium text-sm text-gray-700">ID / Passport Number</label>
                                <input id="id_number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="id_number" value="{{ old('id_number', $visitor->id_number) }}" />
                            </div>
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">Phone Contact</label>
                                <input id="phone" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="phone" value="{{ old('phone', $visitor->phone) }}" />
                            </div>
                            <div class="md:col-span-2">
                                <label for="company" class="block font-medium text-sm text-gray-700">Company Represented (if applicable)</label>
                                <input id="company" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="company" value="{{ old('company', $visitor->company) }}" />
                            </div>
                            <div class="md:col-span-2">
                                <label for="reason_for_visit" class="block font-medium text-sm text-gray-700">Reason for Visit</label>
                                <textarea id="reason_for_visit" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="reason_for_visit" rows="3">{{ old('reason_for_visit', $visitor->reason_for_visit) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('visitors.index') }}">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Visitor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
