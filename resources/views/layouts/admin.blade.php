<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SweetBite</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg text-text-primary font-sans antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-[260px] bg-[#1E1E2E] text-white flex flex-col shrink-0 z-20 shadow-xl">
        <div class="p-6">
            <a href="{{ route('admin.dashboard') }}" class="font-heading font-black text-3xl flex items-center gap-1">
                SweetBite<span class="text-accent">.</span>
            </a>
            <p class="text-text-muted text-xs mt-1 font-medium tracking-wider uppercase">Admin Panel</p>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto mt-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.orders.index') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">🧾</span> Pesanan
            </a>
            <a href="{{ route('admin.orders.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.orders.history') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">📋</span> Riwayat
            </a>
            <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.menus.*') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">🍰</span> Kelola Menu
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.categories.*') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">📁</span> Kategori
            </a>
            <a href="{{ route('admin.tables.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary transition {{ request()->routeIs('admin.tables.*') ? 'bg-primary text-white font-bold' : 'text-gray-300' }}">
                <span class="text-xl">🪑</span> QR Meja
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 rounded-2xl text-danger hover:bg-danger hover:text-white transition font-bold flex items-center gap-3">
                    <span class="text-xl">🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-bg relative">
        
        <!-- Topbar -->
        <header class="bg-white border-b border-border h-20 flex items-center justify-between px-8 shrink-0 z-10 shadow-sm">
            <h2 class="font-heading font-black text-2xl text-primary">@yield('title', 'Dashboard')</h2>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-accent flex items-center justify-center font-bold text-primary shadow-sm text-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-sm leading-tight text-text-primary">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-text-muted font-medium">Administrator</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-8 relative">
            
            <!-- Flash Messages -->
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-[60] flex flex-col gap-2 pointer-events-none">
                @if(session('success'))
                    <div x-show="show" x-transition class="bg-green-500 text-white px-5 py-4 rounded-2xl shadow-xl font-medium flex items-center gap-3 pointer-events-auto">
                        <span class="text-xl">✅</span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div x-show="show" x-transition class="bg-danger text-white px-5 py-4 rounded-2xl shadow-xl font-medium flex items-center gap-3 pointer-events-auto">
                        <span class="text-xl">⚠️</span> {{ session('error') }}
                    </div>
                @endif
            </div>

            @yield('content')
            
        </main>
    </div>
</body>
</html>
