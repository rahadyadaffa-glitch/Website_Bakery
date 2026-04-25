@if(session('last_order_id'))
    @php 
        $lastOrder = \App\Models\Order::find(session('last_order_id'));
    @endphp
    
    @if($lastOrder && in_array($lastOrder->status, ['new', 'processing', 'pending']))
        <div class="fixed bottom-6 left-6 z-[90] animate-in fade-in slide-in-from-left-4 duration-700">
            <a href="{{ $lastOrder->status === 'pending' ? route('payment.show', $lastOrder->id) : route('order.success', $lastOrder->id) }}" 
               class="group flex items-center gap-4 bg-white/90 backdrop-blur-xl border-2 border-primary/20 p-2 pr-6 rounded-full shadow-[0_20px_50px_rgba(0,0,0,0.1)] hover:shadow-2xl hover:scale-105 transition-all duration-500">
                
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-xl shadow-lg group-hover:rotate-12 transition-transform">
                        @if($lastOrder->status === 'pending')
                            💸
                        @elseif($lastOrder->status === 'new')
                            👨‍🍳
                        @else
                            🔥
                        @endif
                    </div>
                    <span class="absolute -top-1 -right-1 flex h-4 w-4">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-accent border-2 border-white"></span>
                    </span>
                </div>

                <div>
                    <p class="text-[10px] font-black text-text-muted uppercase tracking-[0.2em] leading-none mb-1">Status Pesanan</p>
                    <h4 class="font-heading font-black text-primary leading-none text-sm">
                        @if($lastOrder->status === 'pending')
                            Menunggu Pembayaran
                        @elseif($lastOrder->status === 'new')
                            Sedang Antre
                        @else
                            Sedang Disiapkan
                        @endif
                    </h4>
                </div>
                
                <div class="ml-2 text-primary opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
    @endif
@endif
