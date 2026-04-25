@extends('layouts.admin')
@section('title', 'Kelola Kategori')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Kategori Baru -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-3xl border border-border shadow-sm sticky top-4">
                <h3 class="font-heading font-black text-xl text-primary mb-4">Tambah Kategori</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="block font-bold text-text-primary text-sm">Nama Kategori</label>
                        <input type="text" name="name" required placeholder="Misal: Minuman Dingin" class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-bold text-text-primary text-sm">Urutan Tampil</label>
                        <input type="number" name="order" value="0" required class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium">
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer p-2">
                        <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 rounded text-primary focus:ring-primary border-border">
                        <span class="font-bold text-text-primary text-sm">Kategori Aktif</span>
                    </label>
                    <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-6 rounded-2xl hover:bg-primary-dark active:scale-95 transition-all shadow-md">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-sm border border-border overflow-hidden">
                <div class="p-6 border-b border-border bg-bg-secondary">
                    <h3 class="font-heading font-black text-xl text-primary">Daftar Kategori Tersedia</h3>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-text-muted text-sm border-b border-border">
                            <th class="p-4 font-bold">Nama Kategori</th>
                            <th class="p-4 font-bold text-center w-24">Urutan</th>
                            <th class="p-4 font-bold text-center w-24">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($categories as $category)
                            <tr class="hover:bg-bg/50 transition">
                                <td class="p-4 font-bold text-text-primary text-base">{{ $category->name }}</td>
                                <td class="p-4 text-center font-mono font-medium bg-bg-secondary m-2 rounded-lg">{{ $category->order }}</td>
                                <td class="p-4 text-center">
                                    @if($category->is_active)
                                        <span class="bg-success/10 text-success text-xs font-bold px-3 py-1 rounded-full border border-success/20">Aktif</span>
                                    @else
                                        <span class="bg-border text-text-muted text-xs font-bold px-3 py-1 rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-text-muted font-medium">Belum ada kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
