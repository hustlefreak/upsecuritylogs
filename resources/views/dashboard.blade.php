<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facility Hub Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">You are currently logged into the Security Facility Management System.</p>
                </div>
            </div>

            <!-- Quick Access Portals -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">

                <!-- Shift Reports Portal -->
                <a href="{{ route('shift_reports.index') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-100 rounded-lg text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                @php $dashboardShiftIcon = \App\Models\Setting::get('dashboard_shift_report_icon'); @endphp
                                @if($dashboardShiftIcon)
                                    <img src="{{ $dashboardShiftIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardStaffIcon = \App\Models\Setting::get('dashboard_staff_icon'); @endphp
                                @if($dashboardStaffIcon)
                                    <img src="{{ $dashboardStaffIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardVisitorIcon = \App\Models\Setting::get('dashboard_visitor_icon'); @endphp
                                @if($dashboardVisitorIcon)
                                    <img src="{{ $dashboardVisitorIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardTimelineIcon = \App\Models\Setting::get('dashboard_timeline_icon'); @endphp
                                @if($dashboardTimelineIcon)
                                    <img src="{{ $dashboardTimelineIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardReportsIcon = \App\Models\Setting::get('dashboard_reports_icon'); @endphp
                                @if($dashboardReportsIcon)
                                    <img src="{{ $dashboardReportsIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardShiftIcon = \App\Models\Setting::get('dashboard_shift_report_icon'); @endphp
                                @if($dashboardShiftIcon)
                                    <img src="{{ $dashboardShiftIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_shift_report_icon = \App\Models\Setting::get('dashboard_shift_report_icon'); @endphp
                                @if($dashboardIcon_dashboard_shift_report_icon)
                                    <img src="{{ $dashboardIcon_dashboard_shift_report_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_shift_report_icon = \App\Models\Setting::get('dashboard_shift_report_icon'); @endphp
                                @if($dashboardIcon_dashboard_shift_report_icon)
                                    <img src="{{ $dashboardIcon_dashboard_shift_report_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardShiftIcon = \App\Models\Setting::get('dashboard_shift_report_icon'); @endphp
                                @if($dashboardShiftIcon)
                                    <img src="{{ $dashboardShiftIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                @endif
                                @endif
                                @endif
                                @endif
                                @endif
                                @endif
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Shift Logs</h4>
                        <p class="text-sm text-gray-600 mt-2">Write detailed End-of-Shift activity DAR records.</p>
                        <div class="mt-4 flex items-center text-red-600 text-sm font-medium">
                            <span>Write Dar Log</span>
                        </div>
                    </div>
                </a>

                <!-- Staff Logs Portal -->
                <a href="{{ route('attendance.staff') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                @php $dashboardStaffIcon = \App\Models\Setting::get('dashboard_staff_icon'); @endphp
                                @if($dashboardStaffIcon)
                                    <img src="{{ $dashboardStaffIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_staff_icon = \App\Models\Setting::get('dashboard_staff_icon'); @endphp
                                @if($dashboardIcon_dashboard_staff_icon)
                                    <img src="{{ $dashboardIcon_dashboard_staff_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_staff_icon = \App\Models\Setting::get('dashboard_staff_icon'); @endphp
                                @if($dashboardIcon_dashboard_staff_icon)
                                    <img src="{{ $dashboardIcon_dashboard_staff_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardStaffIcon = \App\Models\Setting::get('dashboard_staff_icon'); @endphp
                                @if($dashboardStaffIcon)
                                    <img src="{{ $dashboardStaffIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                @endif
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Staff Logs</h4>
                        <p class="text-sm text-gray-600 mt-2">Manage facility employee check-ins and check-outs.</p>
                        <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
                            <span>Manage access</span>
                        </div>
                    </div>
                </a>

                <!-- Visitor Logs Portal -->
                <a href="{{ route('attendance.visitors') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                @php $dashboardVisitorIcon = \App\Models\Setting::get('dashboard_visitor_icon'); @endphp
                                @if($dashboardVisitorIcon)
                                    <img src="{{ $dashboardVisitorIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_visitor_icon = \App\Models\Setting::get('dashboard_visitor_icon'); @endphp
                                @if($dashboardIcon_dashboard_visitor_icon)
                                    <img src="{{ $dashboardIcon_dashboard_visitor_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_visitor_icon = \App\Models\Setting::get('dashboard_visitor_icon'); @endphp
                                @if($dashboardIcon_dashboard_visitor_icon)
                                    <img src="{{ $dashboardIcon_dashboard_visitor_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardVisitorIcon = \App\Models\Setting::get('dashboard_visitor_icon'); @endphp
                                @if($dashboardVisitorIcon)
                                    <img src="{{ $dashboardVisitorIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                @endif
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Visitor Logs</h4>
                        <p class="text-sm text-gray-600 mt-2">Register guests, assign badges, and track departures.</p>
                        <div class="mt-4 flex items-center text-purple-600 text-sm font-medium">
                            <span>Register visitors</span>
                        </div>
                    </div>
                </a>

                <!-- Calendar Portal -->
                <a href="{{ route('calendar.index') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                @php $dashboardTimelineIcon = \App\Models\Setting::get('dashboard_timeline_icon'); @endphp
                                @if($dashboardTimelineIcon)
                                    <img src="{{ $dashboardTimelineIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_timeline_icon = \App\Models\Setting::get('dashboard_timeline_icon'); @endphp
                                @if($dashboardIcon_dashboard_timeline_icon)
                                    <img src="{{ $dashboardIcon_dashboard_timeline_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_timeline_icon = \App\Models\Setting::get('dashboard_timeline_icon'); @endphp
                                @if($dashboardIcon_dashboard_timeline_icon)
                                    <img src="{{ $dashboardIcon_dashboard_timeline_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardTimelineIcon = \App\Models\Setting::get('dashboard_timeline_icon'); @endphp
                                @if($dashboardTimelineIcon)
                                    <img src="{{ $dashboardTimelineIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Calendar</h4>
                        <p class="text-sm text-gray-600 mt-2">View monthly activity records for staff and visitors.</p>
                        <div class="mt-4 flex items-center text-indigo-600 text-sm font-medium">
                            <span>View schedule</span>
                        </div>
                    </div>
                </a>

                <!-- Reports Portal -->
                <a href="{{ route('reports.index') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                @php $dashboardReportsIcon = \App\Models\Setting::get('dashboard_reports_icon'); @endphp
                                @if($dashboardReportsIcon)
                                    <img src="{{ $dashboardReportsIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_reports_icon = \App\Models\Setting::get('dashboard_reports_icon'); @endphp
                                @if($dashboardIcon_dashboard_reports_icon)
                                    <img src="{{ $dashboardIcon_dashboard_reports_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardIcon_dashboard_reports_icon = \App\Models\Setting::get('dashboard_reports_icon'); @endphp
                                @if($dashboardIcon_dashboard_reports_icon)
                                    <img src="{{ $dashboardIcon_dashboard_reports_icon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    @php $dashboardReportsIcon = \App\Models\Setting::get('dashboard_reports_icon'); @endphp
                                @if($dashboardReportsIcon)
                                    <img src="{{ $dashboardReportsIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                @endif
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Reports</h4>
                        <p class="text-sm text-gray-600 mt-2">Generate CSV documents and print daily logs.</p>
                        <div class="mt-4 flex items-center text-green-600 text-sm font-medium">
                            <span>Access reports</span>
                        </div>
                    </div>
                </a>

                <!-- Dashboard Management Portal -->
                <a href="{{ route('admin.icons.index') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-slate-100 rounded-lg text-slate-600 group-hover:bg-slate-600 group-hover:text-white transition-colors">
                                @php $dashboardSettingsIcon = \App\Models\Setting::get('dashboard_settings_icon'); @endphp
                                @if($dashboardSettingsIcon)
                                    <img src="{{ $dashboardSettingsIcon }}" class="w-8 h-8 object-contain" alt="Icon">
                                @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                @endif
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">Dashboard Management</h4>
                        <p class="text-sm text-gray-500">Configure logos, portals & icons.</p>
                    </div>
                </a>

                <!-- Equipment Log Portal -->
                <a href="{{ route('equipment.logs') }}" class="group block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-100 rounded-lg text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Equipment</h4>
                        <p class="text-sm text-gray-600 mt-2">Manage Equipment Records.</p>
                        <div class="mt-4 flex items-center text-orange-600 text-sm font-medium">
                            <span>Manage equipment</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
