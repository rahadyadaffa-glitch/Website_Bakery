@extends('layouts.admin')
@section('title', 'Detail Jajan Meja ' . $table->number)

@section('content')
    <div class="mb-10 flex items-center gap-6">
        <a href="{{ route('admin.orders.index') }}" class="w-14 h-14 bg-white wobbly-border-thin flex items-center justify-center text-[#8e4e14] shadow-[3px_3px_0_#8e4e14] hover:bg-[#8e4e14] hover:text-white transition-all">
            <span class="material-symbols-outlined font-black">arrow_back</span>
        </a>
        <div>
            <h3 class="hand-drawn font-black text-5xl text-[#8e4e14] transform -rotate-1">Meja {{ $table->number }}</h3>
            <p class="hand-drawn text-2xl text-[#534439] mt-1 opacity-70">Ayo proses setiap menu biar pelanggan happy! ✨</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- List Pesanan -->
        <div class="lg:col-span-2 space-y-6">
            @forelse($items as $item)
                <div class="bg-white p-6 wobbly-border {{ $item->status === 'delivered' ? 'opacity-60 grayscale' : ($item->status === 'processing' ? 'border-[#8e4e14]' : 'border-[#f4a261]') }} shadow-[4px_4px_0_rgba(0,0,0,0.05)] flex items-center justify-between transition-all group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 wobbly-border-thin overflow-hidden bg-[#f5edde] shrink-0 transform {{ $loop->index % 2 == 0 ? 'rotate-2' : '-rotate-2' }}">
                            <img src="{{ $item->menu->image ? Storage::url($item->menu->image) : 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&q=80&w=100' }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="hand-drawn text-3xl text-[#1e1b13] leading-tight">{{ $item->menu_name }}</h4>
                                <span class="bg-[#8e4e14] text-white px-3 py-1 wobbly-border-thin font-black text-xs italic">x{{ $item->quantity }}</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-xs">
                                <span class="font-bold text-[#8e4e14]/50">Order #{{ $item->order->order_number }} — {{ $item->order->customer_name }}</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-3 mt-1">
                                @if($item->status === 'pending')
                                    <span class="hand-drawn text-2xl text-[#f4a261] font-black">Bell Belum Dijawab 🛎️</span>
                                @elseif($item->status === 'processing')
                                    <span class="hand-drawn text-2xl text-[#8e4e14] font-black italic">👨‍🍳 Lagi Dibikin...</span>
                                @else
                                    <span class="hand-drawn text-2xl text-[#366758] font-black">✅ Sudah Diantar</span>
                                @endif
                                
                                @if($item->notes)
                                    <div class="bg-red-50 text-red-500 px-3 py-1 wobbly-border-thin text-[10px] font-bold italic flex items-center gap-2 transform rotate-1">
                                        <span class="material-symbols-outlined text-xs">edit_note</span>
                                        "{{ $item->notes }}"
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        @if($item->status === 'pending')
                            <form action="{{ route('admin.orders.item.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-[#f4a261] text-white px-6 py-3 wobbly-border-thin hand-drawn text-2xl font-bold shadow-[3px_3px_0_#8e4e14] hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                    Terima <span class="material-symbols-outlined">check_circle</span>
                                </button>
                            </form>
                        @elseif($item->status === 'processing')
                            <form action="{{ route('admin.orders.item.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-[#8e4e14] text-white px-6 py-3 wobbly-border-thin hand-drawn text-2xl font-bold shadow-[3px_3px_0_#000] hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                                    Antar Selesai <span class="material-symbols-outlined text-lg">done_all</span>
                                </button>
                            </form>
                        @else
                            <div class="w-14 h-14 bg-[#b6ebd8] text-[#1c4f41] wobbly-border-thin flex items-center justify-center shadow-inner">
                                <span class="material-symbols-outlined font-black">done_all</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 wobbly-border border-dashed border-[#d8c2b5] text-center opacity-30">
                    <span class="material-symbols-outlined text-8xl mb-4">no_meals</span>
                    <h4 class="hand-drawn text-4xl">Gak ada pesanan aktif buat meja ini.</h4>
                </div>
            @endforelse
        </div>

        <!-- Sidebar / Actions -->
        <div class="space-y-8">
            <div class="bg-white p-8 wobbly-border-extreme shadow-[6px_6px_0_rgba(142,78,20,0.1)] sticky top-8">
                <h4 class="hand-drawn text-4xl text-[#8e4e14] mb-2">Aksi Meja</h4>
                
                @php 
                    $processingCount = $items->where('status', 'processing')->count(); 
                @endphp

                <!-- New Global Print Button -->
                <div class="mb-6 pb-6 border-b-2 border-dashed border-[#d8c2b5]">
                    <button type="button" 
                            onclick="window.open('{{ route('admin.orders.table.receipt', $table->number) }}', '_blank', 'width=400,height=600')"
                            {{ $processingCount === 0 ? 'disabled' : '' }}
                            class="w-full py-4 wobbly-border hand-drawn text-2xl font-black transition-all flex items-center justify-center gap-3
                            {{ $processingCount > 0 ? 'bg-white border-[#8e4e14] text-[#8e4e14] shadow-[4px_4px_0_#8e4e14] hover:bg-[#f5edde] active:scale-95' : 'bg-gray-100 text-gray-400 cursor-not-allowed border-[#d8c2b5]' }}">
                        Cetak Struk Siap Antar <span class="material-symbols-outlined">print</span>
                    </button>
                    <p class="text-[10px] font-bold text-[#8e4e14] mt-2 text-center opacity-70">
                        {{ $processingCount }} menu sedang dibikin & siap antar
                    </p>
                </div>
                <p class="hand-drawn text-xl text-[#534439] mb-8 opacity-70 leading-tight">Klik tombol di bawah jika pelanggan sudah bayar dan mau pulang ya!</p>
                
                <div x-data="{ showModal: false }">
                    @php $canComplete = $items->count() > 0 && $items->where('status', '!=', 'delivered')->count() === 0; @endphp

                    <button type="button" 
                            @click="showModal = true"
                            {{ !$canComplete ? 'disabled' : '' }}
                            class="w-full py-5 wobbly-border hand-drawn text-3xl font-black transition-all shadow-xl hover:scale-[1.03] active:scale-95
                            {{ $canComplete ? 'bg-red-500 text-white shadow-red-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed shadow-none border-[#d8c2b5]' }}">
                        Selesaikan Meja 🧹
                    </button>

                    <!-- Artisanal Confirmation Modal -->
                    <div x-show="showModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90"
                         class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/40 backdrop-blur-sm"
                         x-cloak>
                        
                        <div @click.away="showModal = false" 
                             class="bg-white wobbly-border-extreme p-10 max-w-md w-full shadow-[10px_10px_0_#8e4e14] relative overflow-hidden">
                            
                            <!-- Modal Background Accent -->
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-3xl opacity-50"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-24 h-24 bg-red-50 text-red-500 wobbly-border-thin flex items-center justify-center mx-auto mb-6">
                                    <span class="material-symbols-outlined text-5xl font-black">cleaning_services</span>
                                </div>
                                
                                <h3 class="hand-drawn text-4xl text-[#8e4e14] mb-4">Selesaikan Pesanan?</h3>
                                <p class="hand-drawn text-2xl text-[#534439] mb-10 opacity-80 leading-relaxed">
                                    Yakin mau menyelesaikan seluruh pesanan dan mengosongkan <span class="font-bold underline decoration-red-500 underline-offset-4">Meja {{ $table->number }}</span>?
                                </p>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <button @click="showModal = false" 
                                            class="py-4 bg-[#f5edde] text-[#534439] wobbly-border-thin hand-drawn text-2xl font-bold hover:bg-[#e9dec9] transition-all">
                                        Nanti Dulu
                                    </button>
                                    
                                    <form action="{{ route('admin.orders.table.complete', $table->number) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="w-full py-4 bg-red-500 text-white wobbly-border-thin hand-drawn text-2xl font-bold shadow-[4px_4px_0_#8e4e14] hover:scale-105 active:scale-95 transition-all">
                                            Iya, Kosongkan!
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$canComplete && $items->count() > 0)
                        <div class="bg-red-50 text-red-500 p-4 wobbly-border-thin mt-6 text-center transform -rotate-1">
                            <p class="hand-drawn text-xl font-bold">⚠️ Antar semua menu dulu baru bisa tutup meja!</p>
                        </div>
                    @endif
                </div>

                <div class="mt-10 pt-8 border-t-2 border-dashed border-[#d8c2b5]">
                    <div class="flex items-center justify-between text-[#534439] mb-4">
                        <span class="hand-drawn text-2xl">Total Jajan</span>
                        <span class="font-heading font-black text-2xl text-[#8e4e14]">{{ $items->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[#534439]">
                        <span class="hand-drawn text-2xl">Sudah Diantar</span>
                        <span class="font-heading font-black text-2xl text-[#366758]">{{ $items->where('status', 'delivered')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
