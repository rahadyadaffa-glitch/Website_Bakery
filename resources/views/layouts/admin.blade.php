<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SweetBite</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        .hand-drawn {
            font-family: 'Caveat', cursive;
        }

        /* Override scrollbar for cleaner artisanal look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #fff8ef;
        }
        ::-webkit-scrollbar-thumb {
            background: #8e4e14;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-[#fff8ef] text-[#1e1b13] font-sans antialiased flex h-screen overflow-hidden">

    <!-- Artisanal Sidebar -->
    <aside class="w-[280px] bg-white border-r-4 border-[#8e4e14] flex flex-col shrink-0 z-20 relative">
        <!-- Sidebar Watercolor texture -->
        <div class="absolute inset-0 opacity-10 pointer-events-none overflow-hidden -z-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-[#f4a261] blur-[60px] -translate-x-1/2 -translate-y-1/2"></div>
        </div>

        <div class="p-8 border-b-2 border-dashed border-[#8e4e14]">
            <a href="{{ route('admin.dashboard') }}" class="hand-drawn font-black text-5xl text-[#8e4e14] italic transform -rotate-2 px-4 py-1 bg-[#fff8ef] wobbly-border-thin shadow-[2px_2px_0_#8e4e14] flex items-center gap-2">
                SweetBite <span class="material-symbols-outlined text-[32px]">cake</span>
            </a>
            <div class="mt-4 inline-block bg-[#f4a261] text-white px-3 py-1 wobbly-border-thin transform rotate-1">
                <p class="text-[10px] font-black tracking-widest uppercase">{{ auth()->user()->role === 'admin' ? 'Studio Admin' : 'Order Waiter' }}</p>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-4 overflow-y-auto mt-8 py-4">
            @php
                $navItems = auth()->user()->role === 'waiter' ? [
                    ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.orders.index', 'icon' => 'receipt_long', 'label' => 'Monitor Meja'],
                    ['route' => 'admin.orders.history', 'icon' => 'history', 'label' => 'Riwayat Jajan'],
                ] : [
                    ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.menus.index', 'icon' => 'restaurant_menu', 'label' => 'Kelola Jajan'],
                    ['route' => 'admin.categories.index', 'icon' => 'category', 'label' => 'Kategori'],
                    ['route' => 'admin.tables.index', 'icon' => 'qr_code_2', 'label' => 'Generate QR'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center gap-4 px-5 py-4 transition-all duration-200 group
                   {{ request()->routeIs($item['route']) ? 'bg-[#8e4e14] text-white wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.3)] transform rotate-1 scale-105' : 'text-[#534439] hover:bg-[#f5edde] hover:translate-x-2' }}">
                    <span class="material-symbols-outlined text-2xl {{ request()->routeIs($item['route']) ? 'fill-1' : '' }}">{{ $item['icon'] }}</span>
                    <span class="font-heading font-black text-lg tracking-wide uppercase">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-6 border-t-2 border-dashed border-[#8e4e14] mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-red-500 hover:bg-red-50 transition-all group font-heading font-black text-lg tracking-wide uppercase">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#fff8ef] relative">
        <!-- Background Doodles -->
        <span class="doodle-accent text-[120px] top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-[0.03]">bakery_dining</span>
        
        <!-- Artisanal Topbar -->
        <header class="bg-white/80 backdrop-blur-md border-b-4 border-[#8e4e14] h-24 flex items-center justify-between px-10 shrink-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <span class="material-symbols-outlined text-[#8e4e14] text-3xl">draw</span>
                <h2 class="font-heading font-black text-3xl text-[#8e4e14] transform -rotate-1 uppercase tracking-tight">@yield('title', 'Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-4 group cursor-pointer bg-[#fff8ef] px-4 py-2 wobbly-border-thin transform rotate-1">
                <div class="w-12 h-12 bg-[#f4a261] text-white wobbly-border-thin flex items-center justify-center font-black text-2xl shadow-[2px_2px_0_#8e4e14]">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="font-heading font-black text-xl text-[#8e4e14] leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-black text-[#f4a261] uppercase tracking-[0.2em]">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-10 relative">
            
            <!-- Artisanal Flash Messages -->
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" class="fixed top-28 right-10 z-[60] flex flex-col gap-4 pointer-events-none">
                @if(session('success'))
                    <div x-show="show" x-transition class="bg-white wobbly-border p-6 shadow-xl border-[#366758] flex items-center gap-4 pointer-events-auto transform -rotate-1">
                        <div class="w-12 h-12 bg-[#b6ebd8] text-[#1c4f41] wobbly-border-thin flex items-center justify-center font-black">✅</div>
                        <span class="hand-drawn text-2xl text-[#1c4f41] font-bold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div x-show="show" x-transition class="bg-white wobbly-border p-6 shadow-xl border-red-500 flex items-center gap-4 pointer-events-auto transform rotate-1">
                        <div class="w-12 h-12 bg-red-50 text-red-500 wobbly-border-thin flex items-center justify-center font-black">⚠️</div>
                        <span class="hand-drawn text-2xl text-red-500 font-bold">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
            
        </main>
    </div>
</body>
</html>
