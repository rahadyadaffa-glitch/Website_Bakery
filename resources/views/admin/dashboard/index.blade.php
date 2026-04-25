@extends('layouts.admin')
@section('title', 'Admin Overview')

@section('content')
    <div class="relative">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary to-primary-dark rounded-[2.5rem] p-10 mb-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="font-heading font-black text-3xl text-white mb-2">Semangat Jualan, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
                    <p class="text-primary-light font-medium opacity-90">Hari ini ada {{ $ordersCount }} pesanan masuk. Yuk, cek antrean sekarang!</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="bg-accent text-primary font-black py-4 px-8 rounded-2xl hover:bg-accent-dark hover:scale-105 transition-all shadow-xl flex items-center gap-2 group">
                    Cek Antrean Dapur
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Stat Card -->
            <div class="bg-white p-6 rounded-3xl border border-border shadow-sm hover:shadow-xl transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary-light/50 flex items-center justify-center text-2xl group-hover:bg-primary group-hover:text-white transition-colors duration-500">
                        🧾
                    </div>
                </div>
                <p class="text-text-secondary text-sm font-bold uppercase tracking-widest mb-1 opacity-60">Total Pesanan</p>
                <h3 class="font-heading font-black text-3xl text-text-primary">{{ $ordersCount }}</h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-6 rounded-3xl border border-border shadow-sm hover:shadow-xl transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-accent-light/50 flex items-center justify-center text-2xl group-hover:bg-accent group-hover:text-primary transition-colors duration-500">
                        💰
                    </div>
                </div>
                <p class="text-text-secondary text-sm font-bold uppercase tracking-widest mb-1 opacity-60">Pendapatan</p>
                <h3 class="font-heading font-black text-2xl text-text-primary leading-none">Rp{{ number_format($revenue, 0, ',', '.') }}</h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-6 rounded-3xl border border-border shadow-sm hover:shadow-xl transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-danger-light/50 flex items-center justify-center text-2xl group-hover:bg-danger group-hover:text-white transition-colors duration-500">
                        🍰
                    </div>
                    <span class="text-text-muted text-xs font-black">Terlaris</span>
                </div>
                <p class="text-text-secondary text-sm font-bold uppercase tracking-widest mb-1 opacity-60">Top Menu</p>
                <h3 class="font-heading font-black text-xl text-text-primary truncate">
                    {{ $topMenu ? $topMenu->menu_name : 'Belum ada data' }}
                </h3>
            </div>

            <!-- Stat Card -->
            <div class="bg-white p-6 rounded-3xl border border-border shadow-sm hover:shadow-xl transition-all group">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-2xl group-hover:bg-green-500 group-hover:text-white transition-colors duration-500">
                        🪑
                    </div>
                </div>
                <p class="text-text-secondary text-sm font-bold uppercase tracking-widest mb-1 opacity-60">Meja Aktif</p>
                <h3 class="font-heading font-black text-3xl text-text-primary">{{ $activeTablesCount }}</h3>
            </div>
        </div>

        <!-- Quick Links Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-heading font-black text-2xl text-text-primary">Aksi Cepat ⚡</h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <a href="{{ route('admin.menus.create') }}" class="p-6 bg-white rounded-3xl border border-border hover:border-primary hover:shadow-xl transition-all text-center group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">➕</div>
                        <p class="font-bold text-sm text-text-primary">Menu Baru</p>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="p-6 bg-white rounded-3xl border border-border hover:border-primary hover:shadow-xl transition-all text-center group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📁</div>
                        <p class="font-bold text-sm text-text-primary">Kategori</p>
                    </a>
                    <a href="{{ route('admin.tables.index') }}" class="p-6 bg-white rounded-3xl border border-border hover:border-primary hover:shadow-xl transition-all text-center group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🖨️</div>
                        <p class="font-bold text-sm text-text-primary">Cetak QR</p>
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="font-heading font-black text-2xl text-text-primary">Info Resto 🏠</h3>
                <div class="bg-white rounded-[2.5rem] p-8 border border-border shadow-sm">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-bg-secondary rounded-2xl">
                            <span class="text-sm font-bold text-text-secondary">Status Resto</span>
                            <span class="px-3 py-1 bg-green-500 text-white text-[10px] font-black rounded-full uppercase tracking-widest shadow-sm">Open</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-bg-secondary rounded-2xl">
                            <span class="text-sm font-bold text-text-secondary">Admin Aktif</span>
                            <span class="font-heading font-bold text-primary">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
