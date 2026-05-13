@extends('layouts.admin')
@section('title', 'Edit Menu — ' . $menu->name)

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.menus.index') }}" class="w-10 h-10 bg-white border border-border rounded-full flex items-center justify-center text-primary shadow-sm hover:bg-bg-secondary transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h3 class="font-heading font-black text-2xl text-primary">Edit Menu</h3>
    </div>

    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl border border-border shadow-sm max-w-3xl">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1 md:col-span-2">
                <label class="block font-bold text-text-primary text-sm">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="name" required value="{{ old('name', $menu->name) }}" class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium">
                @error('name') <p class="text-danger text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-text-primary text-sm">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-text-primary text-sm">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="text" name="price" id="price_input" required 
                       value="{{ number_format(old('price', $menu->price), 0, ',', '.') }}" 
                       class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-heading font-bold text-lg text-primary"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
            </div>

            @push('scripts')
            <script>
                document.querySelector('form').addEventListener('submit', function(e) {
                    const priceInput = document.getElementById('price_input');
                    priceInput.value = priceInput.value.replace(/\./g, '');
                });
            </script>
            @endpush

            <div class="space-y-1 md:col-span-2">
                <label class="block font-bold text-text-primary text-sm">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-text-primary text-sm">Upload Foto (Opsional)</label>
                @if($menu->image)
                    <div class="mb-3 flex items-center gap-4">
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-20 h-20 object-cover rounded-2xl border-2 border-border">
                        <span class="text-xs text-text-muted font-medium">Foto saat ini</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-2xl border-2 border-border border-dashed focus:border-primary focus:ring-2 focus:ring-primary/20 transition file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary-light file:text-primary hover:file:bg-primary hover:file:text-white cursor-pointer">
                <p class="text-xs text-text-muted mt-1">Kosongkan jika tidak ingin mengganti foto</p>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-text-primary text-sm">Badge (Label Unik)</label>
                <select name="badge" class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium bg-white">
                    <option value="">-- Tanpa Badge --</option>
                    <option value="best_seller" {{ $menu->badge === 'best_seller' ? 'selected' : '' }}>Best Seller 🌟</option>
                    <option value="new" {{ $menu->badge === 'new' ? 'selected' : '' }}>Menu Baru ✨</option>
                    <option value="spicy" {{ $menu->badge === 'spicy' ? 'selected' : '' }}>Pedas 🌶️</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="block font-bold text-text-primary text-sm">Urutan Tampil <span class="text-danger">*</span></label>
                <input type="number" name="order" value="{{ old('order', $menu->order) }}" required class="w-full px-4 py-3 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium">
            </div>

            <div class="flex items-center gap-6 mt-2 md:col-span-2 p-4 bg-bg-secondary rounded-2xl border border-border">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_available" value="1" {{ $menu->is_available ? 'checked' : '' }} class="w-5 h-5 rounded text-primary focus:ring-primary border-border">
                    <span class="font-bold text-text-primary text-sm">Menu Tersedia (Ready)</span>
                </label>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-border flex justify-end gap-4">
            <a href="{{ route('admin.menus.index') }}" class="bg-white text-text-secondary font-bold py-3 px-8 rounded-2xl border-2 border-border hover:bg-bg-secondary transition-all text-lg">
                Batal
            </a>
            <button type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-2xl hover:bg-primary-dark hover:scale-[1.02] active:scale-95 transition-all shadow-md text-lg">
                Simpan Perubahan
            </button>
        </div>
    </form>
@endsection
