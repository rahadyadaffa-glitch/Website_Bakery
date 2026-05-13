@extends('layouts.admin')
@section('title', 'Studio Overview')

@section('content')
    <div class="relative">
        <!-- Artisanal Welcome Section -->
        <div class="bg-[#8e4e14] wobbly-border-extreme p-10 mb-12 shadow-[10px_10px_0_rgba(142,78,20,0.2)] relative overflow-hidden transform -rotate-1">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="hand-drawn font-black text-5xl text-white mb-3">Semangat Jualan, {{ explode(' ', auth()->user()->name)[0] }}! 🧁</h2>
                    <p class="hand-drawn text-3xl text-white opacity-80 leading-tight">Hari ini ada <span class="underline decoration-wavy">{{ $ordersCount }} pesanan</span> masuk. Yuk, cek antrean monitor sekarang!</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="bg-white text-[#8e4e14] font-heading font-black py-5 px-10 wobbly-border-thin hover:scale-105 transition-all shadow-[5px_5px_0_#000] flex items-center gap-3 group hand-drawn text-3xl transform rotate-2">
                    Cek Antrean Dapur
                    <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform text-3xl">restaurant</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Stat Card -->
            <div class="bg-white p-8 wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.1)] group hover:-rotate-1 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 wobbly-border-thin bg-[#f5edde] flex items-center justify-center text-3xl transform -rotate-3 group-hover:bg-[#8e4e14] group-hover:text-white transition-all duration-300">
                        🧾
                    </div>
                </div>
                <p class="hand-drawn text-2xl text-[#534439] opacity-60 mb-1">Total Pesanan</p>
                <h3 class="font-heading font-black text-4xl text-[#8e4e14]">{{ $ordersCount }}</h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-8 wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.1)] group hover:rotate-1 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 wobbly-border-thin bg-[#f5edde] flex items-center justify-center text-3xl transform rotate-3 group-hover:bg-[#f4a261] group-hover:text-white transition-all duration-300">
                        💰
                    </div>
                </div>
                <p class="hand-drawn text-2xl text-[#534439] opacity-60 mb-1">Pendapatan</p>
                <h3 class="font-heading font-black text-3xl text-[#8e4e14] leading-none">Rp {{ number_format($revenue, 0, ',', '.') }}</h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-8 wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.1)] group hover:-rotate-1 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 wobbly-border-thin bg-[#f5edde] flex items-center justify-center text-3xl transform -rotate-6 group-hover:bg-[#366758] group-hover:text-white transition-all duration-300">
                        🍰
                    </div>
                    <span class="hand-drawn text-xl text-[#f4a261] font-black italic transform rotate-6">Terlaris!</span>
                </div>
                <p class="hand-drawn text-2xl text-[#534439] opacity-60 mb-1">Top Menu</p>
                <h3 class="font-heading font-black text-2xl text-[#8e4e14] truncate">
                    {{ $topMenu ? $topMenu->menu_name : 'Belum ada data' }}
                </h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-8 wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.1)] group hover:rotate-2 transition-all">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 wobbly-border-thin bg-[#f5edde] flex items-center justify-center text-3xl transform rotate-2 group-hover:bg-[#8e4e14] group-hover:text-white transition-all duration-300">
                        🪑
                    </div>
                </div>
                <p class="hand-drawn text-2xl text-[#534439] opacity-60 mb-1">Meja Aktif</p>
                <h3 class="font-heading font-black text-4xl text-[#8e4e14]">{{ $activeTablesCount }}</h3>
            </div>
        </div>

        <!-- Quick Links Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-[#8e4e14] text-4xl">bolt</span>
                    <h3 class="hand-drawn font-black text-4xl text-[#1e1b13]">Aksi Cepat Artisanal</h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <a href="{{ route('admin.menus.create') }}" class="p-8 bg-white wobbly-border-thin hover:border-[#8e4e14] hover:shadow-xl transition-all text-center group transform hover:-rotate-2">
                        <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">➕</div>
                        <p class="hand-drawn text-2xl font-black text-[#1e1b13]">Menu Baru</p>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="p-8 bg-white wobbly-border-thin hover:border-[#8e4e14] hover:shadow-xl transition-all text-center group transform hover:rotate-2">
                        <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">📁</div>
                        <p class="hand-drawn text-2xl font-black text-[#1e1b13]">Kategori</p>
                    </a>
                    <a href="{{ route('admin.tables.index') }}" class="p-8 bg-white wobbly-border-thin hover:border-[#8e4e14] hover:shadow-xl transition-all text-center group transform hover:-rotate-1">
                        <div class="text-4xl mb-4 group-hover:scale-125 transition-transform">🖨️</div>
                        <p class="hand-drawn text-2xl font-black text-[#1e1b13]">Cetak QR</p>
                    </a>
                </div>
            </div>

            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-[#8e4e14] text-4xl">storefront</span>
                    <h3 class="hand-drawn font-black text-4xl text-[#1e1b13]">Info Resto 🏠</h3>
                </div>
                <div class="bg-white wobbly-border-extreme p-8 shadow-[6px_6px_0_rgba(142,78,20,0.1)] transform rotate-1">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 bg-[#f5edde] wobbly-border-thin transform -rotate-1">
                            <span class="hand-drawn text-2xl text-[#534439]">Status Studio</span>
                            <span class="px-4 py-1 bg-[#366758] text-white hand-drawn text-xl font-black wobbly-border-thin shadow-sm">OPEN ✨</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-[#f5edde] wobbly-border-thin transform rotate-1">
                            <span class="hand-drawn text-2xl text-[#534439]">Admin Aktif</span>
                            <span class="hand-drawn text-2xl font-black text-[#8e4e14]">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
