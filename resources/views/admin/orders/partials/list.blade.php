@if($orders->isEmpty())
    <div class="bg-white rounded-[40px] border border-border p-16 text-center shadow-sm">
        <div class="text-7xl mb-6 opacity-40">📭</div>
        <h4 class="font-heading font-black text-2xl text-text-primary mb-2">Belum Ada Pesanan Aktif</h4>
        <p class="text-text-secondary font-medium">Antrean masih kosong, silakan tunggu customer memesan.</p>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($orders as $order)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border-2 {{ $order->status === 'new' ? 'border-primary shadow-[0_4px_15px_rgba(66,122,181,0.15)]' : 'border-warning shadow-[0_4px_15px_rgba(255,155,66,0.1)]' }} flex flex-col relative">
                
                <!-- Status Bar -->
                <div class="h-2 w-full {{ $order->status === 'new' ? 'bg-primary' : 'bg-warning' }}"></div>

                <!-- Card Header -->
                <div class="p-5 border-b border-border flex justify-between items-center bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-xl shadow-inner {{ $order->status === 'new' ? 'bg-primary text-white' : 'bg-warning text-white' }}">
                            {{ $order->table_number }}
                        </div>
                        <div>
                            <p class="font-mono font-bold text-xs text-text-muted mb-0.5">{{ $order->order_number }}</p>
                            <p class="text-xs font-bold text-text-secondary">{{ $order->created_at->format('H:i') }} <span class="font-normal">({{ $order->created_at->diffForHumans() }})</span></p>
                        </div>
                    </div>
                    
                    @if($order->status === 'new')
                        <span class="bg-[#D6E6F7] text-[#427AB5] text-xs font-black px-3 py-1.5 rounded-full border border-[#427AB5] tracking-wide uppercase">Masuk</span>
                    @else
                        <span class="bg-[#FFE8BE] text-[#E8860A] text-xs font-black px-3 py-1.5 rounded-full border border-[#FF9B42] tracking-wide uppercase">Diproses</span>
                    @endif
                </div>

                <!-- Items -->
                <div class="p-5 flex-grow bg-bg/30">
                    <ul class="space-y-4">
                        @foreach($order->items as $item)
                            <li class="flex items-start gap-3 text-sm">
                                <span class="font-black text-primary min-w-[28px] bg-primary-light/50 px-1 py-0.5 rounded text-center">{{ $item->quantity }}x</span>
                                <div>
                                    <p class="font-bold text-text-primary text-base leading-tight">{{ $item->menu_name }}</p>
                                    @if($item->notes)
                                        <p class="text-xs text-danger font-bold mt-1 bg-danger/10 inline-block px-2 py-0.5 rounded border border-danger/20">📝 {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Footer / Actions -->
                <div class="p-5 border-t border-border bg-white flex justify-between items-center mt-auto shrink-0">
                    <span class="font-heading font-black text-xl text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    
                    @if($order->status === 'new')
                        <form action="{{ route('admin.orders.process', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" 
                                    style="background-color: #00497e;"
                                    class="text-white font-bold py-2.5 px-6 rounded-xl hover:opacity-90 hover:scale-105 active:scale-95 transition-all shadow-md">
                                Proses 🚀
                            </button>
                        </form>
                    @elseif($order->status === 'processing')
                        <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" 
                                    style="background-color: #10b981;"
                                    class="text-white font-bold py-2.5 px-6 rounded-xl hover:opacity-90 hover:scale-105 active:scale-95 transition-all shadow-md">
                                Selesai ✅
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
