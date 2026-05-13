@forelse($incomingItems as $item)
    <div class="incoming-item-card flex flex-col md:flex-row md:items-center justify-between p-6 bg-white wobbly-border shadow-[4px_4px_0_rgba(142,78,20,0.1)] group hover:-rotate-1 transition-all">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 wobbly-border-thin flex flex-col items-center justify-center transform -rotate-3 {{ $item->status === 'pending' ? 'bg-[#f4a261] text-white' : 'bg-[#8e4e14] text-white' }}">
                <span class="text-[9px] font-black uppercase leading-none mb-1">Meja</span>
                <span class="font-heading font-black text-3xl leading-none">{{ $item->order->table_number }}</span>
            </div>
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h4 class="hand-drawn text-4xl text-[#8e4e14] leading-tight">{{ $item->menu_name }}</h4>
                    <span class="bg-[#8e4e14] text-white px-3 py-1 wobbly-border-thin font-black text-xs transform rotate-2 italic">x{{ $item->quantity }}</span>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    @if($item->status === 'pending')
                        <span class="hand-drawn text-2xl text-[#f4a261] font-black animate-pulse">✨ Pesanan Baru Masuk!</span>
                    @else
                        <span class="hand-drawn text-2xl text-[#8e4e14] font-black italic">👨‍🍳 Sedang diproses...</span>
                    @endif
                    
                    @if($item->notes)
                        <div class="bg-red-50 text-red-500 px-4 py-2 wobbly-border-thin text-xs font-bold italic flex items-center gap-2 transform rotate-1">
                            <span class="material-symbols-outlined text-sm">edit_note</span>
                            "{{ $item->notes }}"
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <a href="{{ route('admin.orders.table', $item->order->table_number) }}" class="mt-4 md:mt-0 bg-white wobbly-border-thin text-[#8e4e14] px-8 py-3 hand-drawn text-2xl font-bold hover:bg-[#8e4e14] hover:text-white transition-all shadow-[3px_3px_0_#8e4e14] group-hover:rotate-2 active:scale-95 flex items-center justify-center gap-2">
            Proses Pesanan <span class="material-symbols-outlined text-xl">restaurant</span>
        </a>
    </div>
@empty
    <div class="text-center py-12 opacity-30">
        <span class="material-symbols-outlined text-8xl mb-4">notifications_off</span>
        <h4 class="hand-drawn text-4xl">Belum ada menu yang dipesan...</h4>
    </div>
@endforelse
