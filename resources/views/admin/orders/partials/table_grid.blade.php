@foreach($tables as $table)
    @php 
        $stats = $tableStats[$table->number]; 
        $isOccupied = $stats->total > 0;
        $hasNewOrder = $stats->pending_count > 0;
        $allDelivered = $isOccupied && ($stats->total == $stats->delivered_count);
        
        // High Contrast Artisanal Logic
        $containerClass = 'bg-white border-4 border-dashed border-[#d8c2b5] opacity-60';
        $numberCircleClass = 'bg-white text-[#d8c2b5] border-2 border-[#d8c2b5]';
        $statusLabel = 'KOSONG';
        $statusLabelClass = 'text-[#d8c2b5]';
        $cardRotation = $loop->index % 2 == 0 ? '-rotate-1' : 'rotate-1';
        
        if ($isOccupied) {
            $containerClass = 'bg-white border-4 border-[#8e4e14] shadow-[8px_8px_0_rgba(142,78,20,0.2)] opacity-100';
            $numberCircleClass = 'bg-[#8e4e14] text-white wobbly-border-thin shadow-[3px_3px_0_#000]';
            $statusLabel = 'MASAK...';
            $statusLabelClass = 'text-[#8e4e14]';

            if ($hasNewOrder) {
                $containerClass = 'bg-[#f4a261] border-4 border-[#8e4e14] shadow-[10px_10px_0_#8e4e14] animate-pulse opacity-100 scale-105 z-10';
                $numberCircleClass = 'bg-white text-[#8e4e14] wobbly-border-thin shadow-[4px_4px_0_#000]';
                $statusLabel = 'ORDER BARU!';
                $statusLabelClass = 'text-white bg-[#8e4e14] px-3 py-1 wobbly-border-thin';
            } elseif ($allDelivered) {
                $containerClass = 'bg-[#ba1a1a] border-4 border-[#000] shadow-[10px_10px_0_#000] opacity-100';
                $numberCircleClass = 'bg-white text-[#ba1a1a] wobbly-border-thin shadow-[4px_4px_0_#000]';
                $statusLabel = 'SIAP TUTUP';
                $statusLabelClass = 'text-white bg-[#000] px-4 py-1 wobbly-border-thin';
            }
        }
    @endphp

    <a href="{{ route('admin.orders.table', $table->number) }}" 
       class="{{ $containerClass }} p-8 wobbly-border flex flex-col items-center justify-center text-center transition-all duration-300 transform {{ $cardRotation }} hover:scale-110 hover:z-20 min-h-[220px]">
        
        <div class="mb-4 relative">
            <div class="w-24 h-24 flex flex-col items-center justify-center {{ $numberCircleClass }} transform {{ $loop->index % 2 == 0 ? '-rotate-3' : 'rotate-3' }}">
                <span class="text-[10px] font-black uppercase leading-none mb-1 opacity-60">Meja</span>
                <span class="font-heading font-black text-5xl leading-none">{{ $table->number }}</span>
            </div>
            
            @if($hasNewOrder)
                <span class="absolute -top-4 -right-4 bg-white text-red-600 w-12 h-12 rounded-full wobbly-border flex items-center justify-center shadow-lg animate-bounce">
                    <span class="material-symbols-outlined font-black">notifications_active</span>
                </span>
            @endif
        </div>

        <div class="mt-2 space-y-2">
            <span class="hand-drawn text-3xl font-black {{ $statusLabelClass }} block transform {{ $loop->index % 2 == 0 ? 'rotate-1' : '-rotate-1' }}">
                {{ $statusLabel }}
            </span>
            
            @if($isOccupied)
                <div class="font-heading font-black text-2xl {{ $allDelivered || $hasNewOrder ? 'text-white' : 'text-[#8e4e14]' }}">
                    {{ $hasNewOrder ? $stats->pending_count : ($allDelivered ? 'FINISH' : $stats->total - $stats->delivered_count) }}
                    <span class="text-xs uppercase ml-1 opacity-70">{{ $allDelivered ? '' : 'Menu' }}</span>
                </div>
            @endif
        </div>

        @if($isOccupied)
            <div class="mt-6 flex items-center gap-2 {{ $allDelivered || $hasNewOrder ? 'text-white' : 'text-[#8e4e14]' }} font-black uppercase text-[10px] tracking-[0.2em] opacity-80 group-hover:scale-110 transition-all">
                <span>Detail</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </div>
        @endif
    </a>
@endforeach
