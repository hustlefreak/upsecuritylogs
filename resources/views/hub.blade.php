<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Defining the specific geometric polygon shards from the preview */
        .shard-1 { clip-path: polygon(0% 0%, 60% 0%, 40% 100%, 0% 100%); }
        .shard-2 { clip-path: polygon(100% 0%, 30% 0%, 70% 100%, 100% 100%); }
        .shard-3 { clip-path: polygon(20% 0%, 100% 40%, 80% 100%, 0% 80%); }
        .shard-4 { clip-path: polygon(50% 20%, 100% 80%, 20% 100%); }
    </style>
</head>
<body class="bg-slate-50 antialiased">
    @php $hubBg = \App\Models\Setting::get("hub_background"); @endphp
    @if($hubBg)
        <div class="fixed inset-0 z-[-1]" style="background-image: url('{{ $hubBg }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/10"></div>
        </div>
    @endif

    <div class="relative min-h-screen w-full overflow-hidden flex flex-col items-center justify-center p-8">

        @unless($hubBg)
        <div class="absolute inset-0 z-0">
            <div class="shard-1 absolute inset-0 bg-emerald-100/40 blur-3xl scale-110"></div>
            <div class="shard-2 absolute inset-0 bg-purple-100/30 blur-2xl translate-x-10"></div>
            <div class="shard-3 absolute top-[20%] right-[-5%] w-[50%] h-[60%] bg-amber-200/20 mix-blend-multiply rotate-12"></div>
            <div class="shard-4 absolute bottom-[-10%] left-[-5%] w-[40%] h-[50%] bg-blue-200/40 mix-blend-multiply -rotate-12 blur-xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[60%] bg-[#731321]/5 blur-[120px] rounded-full"></div>
            <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(#475569 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
        </div>
        @endunless

        <div class="relative z-10 w-full max-w-6xl">
            
            <div class="flex flex-col items-center mb-5">
                @php $mainHubIcon = \App\Models\Setting::get('hub_main_icon'); @endphp
                @if($mainHubIcon)
                    <img src="{{ $mainHubIcon }}" style=" height: 140px; " class="mb-3">
                @else
                    <img src="/up-logo.png" style=" height: 140px; " class="mb-3">
                @endif
                <div class="text-center bg-white/40 backdrop-blur-xl border border-white/60 p-8 rounded-[2.5rem] shadow-2xl shadow-slate-200/50">
                    <div id="liveClock" class="text-6xl md:text-7xl font-black text-[#731321] tracking-tighter drop-shadow-sm mb-2">--:--:--</div>
                    <p  id="liveDate"  class="text-xs font-bold text-slate-500 uppercase tracking-[0.5em] opacity-80">Loading Date...</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <a  href="{{ route('kiosk.index') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113] hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-purple-100/80 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                                             @php $visIcon = \App\Models\Setting::get("hub_visitor_icon"); @endphp @if($visIcon) <img src="{{ $visIcon }}" style="width: 28px; height: 28px; object-fit: contain;"> @else <svg style="width: 28px; height: 28px;" class="h-7 w-7 text-purple-600 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg> @endif
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Visitor</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">I am a guest, contractor, or delivery personnel checking into the facility.</p>
                </a>

                <a href="{{ route('staff_kiosk.index') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113] hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-blue-100/80 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                        @php $staffIcon = \App\Models\Setting::get("hub_staff_icon"); @endphp @if($staffIcon) <img src="{{ $staffIcon }}" style="width: 28px; height: 28px; object-fit: contain;"> @else <svg style="width: 28px; height: 28px;" class="h-7 w-7 text-blue-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg> @endif
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Staff</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">I am an employee reporting to work or leaving for the day.</p>
                </a>

                <a href="{{ route('guard_kiosk.index') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113] hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-slate-100/80 text-slate-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                        @php $guardIcon = \App\Models\Setting::get("hub_guard_icon"); @endphp @if($guardIcon) <img src="{{ $guardIcon }}" style="width: 28px; height: 28px; object-fit: contain;"> @else <svg style="width: 28px; height: 28px;" class="h-7 w-7 text-gray-800 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> @endif
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Security Guard</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">I need to submit my end of shift Daily Activity Report (DAR).</p>
                </a>

                <a href="{{ route('kiosk.monitor') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113] hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-purple-100/80 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    @php $outIcon = \App\Models\Setting::get("hub_checkout_icon"); @endphp @if($outIcon) <img src="{{ $outIcon }}" style="width: 28px; height: 28px; object-fit: contain;"> @else <svg style="width: 28px; height: 28px;" class="h-7 w-7 text-green-600 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg> @endif
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Visitor Checkout</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">I am leaving the facility and need to process my check-out.</p>
                </a>

                <a href="{{ route('staff_kiosk.monitor') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113]  hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-purple-100/80 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                       <svg class="h-7 w-7 text-blue-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Staff Monitor</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">View currently active staff and manage check-outs.</p>
                </a>
                <a href="{{ route('equipment.hub') }}" class="group relative bg-white/50 backdrop-blur-2xl border border-white/70 p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:border-[#7b1113]  hover:-translate-y-2 transition-all duration-500">
                    <div class="w-16 h-16 bg-purple-100/80 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-inner">
                       <svg class="h-7 w-7 text-orange-600 group-hover:text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 tracking-tight">Equipment Hub</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-medium opacity-90">I need to pull out or return equipment.</p>
                </a>

            </div>

            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="px-6 py-2 bg-white/20 hover:bg-[#7b1113] hover:text-white backdrop-blur-md rounded-full border border-white/30 text-[10px] font-black uppercase tracking-[0.4em] text-slate-500 transition-all">
                    Admin Login Access
                </a>
            </div>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? "PM" : "AM";
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            const strTime = hours + ":" + minutes + ":" + seconds + " " + ampm;
            const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
            const strDate = now.toLocaleDateString("en-US", options);
            document.getElementById("liveClock").innerText = strTime;
            document.getElementById("liveDate").innerText = strDate;
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

</body>
</html>