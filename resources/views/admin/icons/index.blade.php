<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Customize Portal Icons</h3>
                        <p class="text-sm text-gray-500">Upload your own images to replace the default SVG icons on the main facility hub page. Recommended file types: PNG, SVG, or JPG (max 5MB).</p>
                    </div>

                    @if(session('status'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.icons.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($icons as $key => $label)
                                @php $currentVal = \App\Models\Setting::get($key); @endphp
                                <div class="border rounded-lg p-6 bg-gray-50 flex flex-col justify-between">
                                    <div>
                                        <label class="block font-medium text-gray-700 text-lg mb-2">{{ $label }}</label>
                                        
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center border shadow-inner overflow-hidden">
                                                @if($currentVal)
                                                    <img src="{{ $currentVal }}" alt="Current Icon" class="max-w-full max-h-full object-contain">
                                                @else
                                                    <span class="text-xs text-gray-500 text-center px-2">Default SVG</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                <input type="file" name="{{ $key }}" accept="image/*" class="block w-full text-sm text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-md file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-indigo-50 file:text-indigo-700
                                                    hover:file:bg-indigo-100
                                                "/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($currentVal)
                                        <div class="mt-4 flex justify-end">
                                            <!-- Separate form for individual reset -->
                                            <button type="submit" form="reset-{{ $key }}" class="text-sm text-red-600 hover:text-red-900 border border-red-200 rounded px-3 py-1 bg-white hover:bg-red-50 transition">
                                                Reset to Default
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-6 border-t flex justify-end gap-4">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium shadow-sm transition">
                                Save All Changes
                            </button>
                        </div>
                    </form>

                    <!-- Hidden forms for resetting individual elements -->
                    @foreach($icons as $key => $label)
                        <form id="reset-{{ $key }}" action="{{ route('admin.icons.reset') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="key" value="{{ $key }}">
                        </form>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>