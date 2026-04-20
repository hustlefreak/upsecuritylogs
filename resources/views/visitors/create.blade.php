<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register New Visitor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Guest Registration Form</h3>
                                <p class="text-sm text-gray-500">Fill out the required visitor identity information.</p>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('visitors.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="col-span-1 md:col-span-2">
                                <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Personal Details</h4>
                            </div>

                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="firstName" id="firstName" value="{{ old('firstName') }}" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" required placeholder="John">
                            </div>

                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="lastName" id="lastName" value="{{ old('lastName') }}" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" required placeholder="Doe">
                            </div>

                            <!-- Identification & Contact -->
                            <div class="col-span-1 md:col-span-2 mt-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identification & Contact</h4>
                            </div>

                            <div>
                                <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">ID Number / License</label>
                                <input type="text" name="id_number" id="id_number" value="{{ old('id_number') }}" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. DL-1234567">
                                <p class="mt-1 text-xs text-gray-500">Government issued ID or Driver's License.</p>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="+1 (555) 000-0000">
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company / Organization</label>
                                <input type="text" name="company" id="company" value="{{ old('company') }}" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Acme Corp">
                                <p class="mt-1 text-xs text-gray-500">The company the visitor is representing (if applicable).</p>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label for="reason_for_visit" class="block text-sm font-medium text-gray-700 mb-1">Reason for Visit</label>
                                <textarea name="reason_for_visit" id="reason_for_visit" rows="3" class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Meeting with John Doe regarding..."></textarea>
                                <p class="mt-1 text-xs text-gray-500">Briefly describe the purpose of the visit.</p>
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t border-gray-200 flex items-center justify-end space-x-4">
                            <a href="{{ route('visitors.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Register Visitor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
