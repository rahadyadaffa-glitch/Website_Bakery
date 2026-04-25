<table class="w-full text-left border-collapse">
    <thead>
        <tr class="bg-bg-secondary text-text-primary font-bold border-b border-border">
            <th class="p-5">Foto</th>
            <th class="p-5">Nama Menu</th>
            <th class="p-5">Kategori</th>
            <th class="p-5">Harga</th>
            <th class="p-5">Status</th>
            <th class="p-5 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-border">
        @forelse($menus as $menu)
            <tr class="hover:bg-bg/50 transition-colors group">
                <td class="p-5">
                    <div class="w-16 h-16 rounded-2xl bg-bg-secondary flex items-center justify-center overflow-hidden border border-border shadow-sm group-hover:scale-110 transition-transform duration-300">
                        @if($menu->image)
                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl opacity-50">🍰</span>
                        @endif
                    </div>
                </td>
                <td class="p-5">
                    <p class="font-heading font-bold text-text-primary text-base">{{ $menu->name }}</p>
                    @if($menu->badge)
                        <span class="text-[10px] font-black uppercase bg-accent text-primary px-2.5 py-1 rounded-full inline-block mt-1.5 shadow-sm border border-white/50">{{ str_replace('_', ' ', $menu->badge) }}</span>
                    @endif
                </td>
                <td class="p-5">
                    <span class="px-3 py-1.5 bg-primary-light text-primary text-xs font-black rounded-xl border border-primary/10">
                        {{ $menu->category->name }}
                    </span>
                </td>
                <td class="p-5 font-heading font-black text-primary text-lg tracking-tight">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </td>
                <td class="p-5">
                    <form action="{{ route('admin.menus.toggle', $menu->id) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($menu->is_available)
                            <button type="submit" class="flex items-center gap-2 text-success text-xs font-black bg-success/10 px-3 py-1.5 rounded-xl border border-success/20 hover:bg-danger/10 hover:text-danger hover:border-danger/20 transition-all cursor-pointer" title="Klik untuk ubah ke Habis">
                                <span class="w-2 h-2 rounded-full bg-success"></span> Tersedia
                            </button>
                        @else
                            <button type="submit" class="flex items-center gap-2 text-danger text-xs font-black bg-danger/10 px-3 py-1.5 rounded-xl border border-danger/20 hover:bg-success/10 hover:text-success hover:border-success/20 transition-all cursor-pointer" title="Klik untuk ubah ke Tersedia">
                                <span class="w-2 h-2 rounded-full bg-danger"></span> Habis
                            </button>
                        @endif
                    </form>
                </td>
                <td class="p-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="w-10 h-10 bg-white border border-border rounded-xl flex items-center justify-center text-text-secondary hover:bg-primary hover:text-white hover:border-primary transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-white border border-border rounded-xl flex items-center justify-center text-danger hover:bg-danger hover:text-white hover:border-danger transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-12 text-center">
                    <div class="text-6xl mb-4 opacity-20">🍰</div>
                    <p class="text-text-muted font-bold">Menu tidak ditemukan.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
