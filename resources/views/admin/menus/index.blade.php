@extends('layouts.admin')
@section('title', 'Kelola Menu')

@section('content')
    <div x-data="menuManager()" class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 rounded-[2rem] shadow-sm border border-border">
            <div>
                <h3 class="font-heading font-black text-3xl text-primary flex items-center gap-3">
                    Daftar Menu 🍰
                </h3>
                <p class="text-text-secondary font-medium mt-1">Kelola menu restoran dengan cepat dan mudah.</p>
            </div>
            <a href="{{ route('admin.menus.create') }}" class="bg-primary text-white font-black py-4 px-8 rounded-2xl hover:bg-primary-dark hover:scale-105 active:scale-95 transition-all shadow-xl flex items-center justify-center gap-2">
                <span>➕</span> Tambah Menu Baru
            </a>
        </div>

        <!-- Search & Filter Bar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-2 relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-text-muted group-focus-within:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       x-model="search" 
                       @input.debounce.300ms="fetchMenus"
                       placeholder="Cari nama menu..." 
                       class="w-full pl-14 pr-6 py-4 bg-white rounded-2xl border-2 border-border focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-text-primary shadow-sm">
            </div>

            <!-- Filter Category -->
            <div class="relative">
                <select x-model="categoryId" 
                        @change="fetchMenus"
                        class="w-full pl-6 pr-12 py-4 bg-white rounded-2xl border-2 border-border focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-text-primary shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Menu Table Container -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-border overflow-hidden relative min-h-[400px]">
            <!-- Loading Overlay -->
            <div x-show="loading" 
                 class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center transition-all">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    <p class="font-black text-primary text-xs uppercase tracking-[0.2em]">Mencari...</p>
                </div>
            </div>

            <div x-ref="menuList">
                @include('admin.menus.partials.list', ['menus' => $menus])
            </div>
        </div>
    </div>

    <script>
        function menuManager() {
            return {
                search: '',
                categoryId: '',
                loading: false,
                fetchMenus() {
                    this.loading = true;
                    const params = new URLSearchParams({
                        search: this.search,
                        category_id: this.categoryId
                    });

                    fetch(`{{ route('admin.menus.index') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        this.$refs.menuList.innerHTML = html;
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Error fetching menus:', error);
                        this.loading = false;
                    });
                }
            }
        }
    </script>
@endsection
