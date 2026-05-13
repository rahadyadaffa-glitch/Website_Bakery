@if($orders->isEmpty())
    <div class="bg-white wobbly-border p-16 text-center shadow-sm">
        <div class="text-7xl mb-6 opacity-40">📭</div>
        <h4 class="hand-drawn font-black text-4xl text-[#8e4e14] mb-2">Belum Ada Pesanan Aktif</h4>
        <p class="hand-drawn text-2xl text-[#534439]/60">Antrean masih kosong, silakan tunggu customer memesan.</p>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($orders as $order)
            <div class="bg-white wobbly-border overflow-hidden shadow-sm hover:shadow-md transition-shadow border-[#8e4e14] flex flex-col relative group transform {{ $loop->index % 2 == 0 ? '-rotate-1' : 'rotate-1' }}">
                
                <!-- Status Bar -->
                <div class="h-3 w-full {{ $order->status === 'new' ? 'bg-[#f4a261]' : 'bg-[#8e4e14]' }}"></div>

                <!-- Card Header -->
                <div class="p-6 border-b-2 border-dashed border-[#8e4e14] flex justify-between items-center bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 wobbly-border-thin flex flex-col items-center justify-center font-black text-xl shadow-inner {{ $order->status === 'new' ? 'bg-[#f4a261] text-white' : 'bg-[#8e4e14] text-white' }}">
                            <span class="text-[8px] uppercase leading-none opacity-50">Meja</span>
                            <span class="leading-none text-2xl">{{ $order->table_number }}</span>
                        </div>
                        <div>
                            <p class="font-mono font-bold text-[10px] text-[#534439]/60 mb-0.5">{{ $order->order_number }}</p>
                            <p class="font-heading font-black text-[#8e4e14]">{{ $order->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($order->status === 'new')
                        <span class="bg-[#f4a261]/10 text-[#f4a261] text-[10px] font-black px-3 py-1 wobbly-border-thin tracking-wide uppercase">Masuk</span>
                    @else
                        <span class="bg-[#8e4e14]/10 text-[#8e4e14] text-[10px] font-black px-3 py-1 wobbly-border-thin tracking-wide uppercase">Dibuat</span>
                    @endif
                </div>

                <!-- Items -->
                <div class="p-6 flex-grow bg-[#fff8ef]/50">
                    <ul class="space-y-4">
                        @foreach($order->items as $item)
                            <li class="flex items-start gap-4">
                                <span class="font-heading font-black text-[#8e4e14] min-w-[32px] bg-[#f5edde] wobbly-border-thin text-center transform -rotate-3">{{ $item->quantity }}x</span>
                                <div>
                                    <p class="font-heading font-black text-[#1e1b13] text-lg leading-tight">{{ $item->menu_name }}</p>
                                    @if($item->notes)
                                        <p class="text-[10px] text-red-500 font-bold mt-1 bg-red-50 inline-block px-2 py-1 wobbly-border-thin italic">📝 {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Footer / Actions -->
                <div class="p-6 border-t-2 border-dashed border-[#8e4e14] bg-white flex justify-between items-center mt-auto shrink-0">
                    <span class="font-heading font-black text-2xl text-[#8e4e14]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    
                    @if($order->status === 'new')
                        <form action="{{ route('admin.orders.process', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" 
                                    class="bg-[#8e4e14] text-white font-heading font-black text-lg py-3 px-6 wobbly-border-thin hover:scale-105 active:scale-95 transition-all shadow-md">
                                PROSES 🚀
                            </button>
                        </form>
                    @elseif($order->status === 'processing')
                        <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" 
                                    class="bg-[#366758] text-white font-heading font-black text-lg py-3 px-6 wobbly-border-thin hover:scale-105 active:scale-95 transition-all shadow-md">
                                SELESAI ✅
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
