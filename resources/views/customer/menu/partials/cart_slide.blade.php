<!-- Slide-in Cart Panel (Artisanal Hand-Drawn Style) -->
<div x-cloak x-show="cartOpen" class="relative z-[100]" aria-labelledby="slide-over-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div x-show="cartOpen" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-[#8e4e14]/40 backdrop-blur-sm transition-opacity" @click="cartOpen = false"></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-auto">

                <!-- Panel -->
                <div x-show="cartOpen" x-transition:enter="transform transition ease-in-out duration-500"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md">

                    <div
                        class="flex h-full flex-col overflow-y-scroll bg-[#fff8ef] shadow-2xl wobbly-border-extreme !rounded-none !border-y-0 !border-r-0 border-l-8 border-[#8e4e14] relative">

                        <!-- Header -->
                        <div
                            class="px-8 py-10 flex flex-col gap-4 sticky top-0 bg-[#fff8ef]/90 backdrop-blur-md z-10 border-b-2 border-dashed border-[#8e4e14]">
                            <div class="flex items-center justify-between">
                                <h2 class="hand-drawn font-black text-4xl text-[#8e4e14] flex items-center gap-3"
                                    id="slide-over-title">
                                    <span class="material-symbols-outlined text-4xl">shopping_basket</span> Jajananku ✨
                                </h2>
                                <button @click="cartOpen = false"
                                    class="w-12 h-12 bg-white wobbly-border-thin text-[#8e4e14] hover:bg-[#8e4e14] hover:text-white transition-all shadow-[3px_3px_0_#8e4e14] flex items-center justify-center">
                                    <span class="material-symbols-outlined font-black">close</span>
                                </button>
                            </div>
                            <template x-if="Object.keys(cartItems).length > 0">
                                <button @click="clearCart()"
                                    class="group flex items-center gap-3 px-6 py-3 bg-red-50 text-red-500 wobbly-border-thin font-bold text-sm uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all w-full justify-center">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:rotate-12 transition-transform">delete_sweep</span>
                                    Hapus Semua 🗑️
                                </button>
                            </template>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 px-8 py-8 relative">
                            <!-- Background doodles -->
                            <span class="material-symbols-outlined absolute top-20 right-10 text-[#8e4e14]/5 text-9xl pointer-events-none">bakery_dining</span>

                            <template x-if="Object.keys(cartItems).length === 0">
                                <div class="h-full flex flex-col items-center justify-center text-center py-20 relative z-10">
                                    <div class="text-9xl mb-8 opacity-20">🍦</div>
                                    <h4 class="hand-drawn text-4xl text-[#8e4e14] mb-4">Yah, masih sepi! 🥺</h4>
                                    <p class="text-[#534439] font-bold px-8 hand-drawn text-2xl">Ayo jajan dulu biar hari kamu makin manis! ✨</p>
                                    <button @click="cartOpen = false"
                                        class="mt-10 px-10 py-5 bg-[#f4a261] text-white hand-drawn text-3xl wobbly-border shadow-[4px_4px_0_#8e4e14] hover:scale-105 active:scale-95 transition-all">
                                        GAS PESAN! 🚀
                                    </button>
                                </div>
                            </template>

                            <template x-if="Object.keys(cartItems).length > 0">
                                <div class="space-y-8 relative z-10">
                                    <template x-for="(item, id) in cartItems" :key="id">
                                        <div
                                            class="group flex flex-col gap-4 p-6 bg-white wobbly-border-thin hover:border-[#8e4e14] transition-all duration-300 shadow-[4px_4px_0_rgba(142,78,20,0.1)] hover:shadow-[6px_6px_0_rgba(142,78,20,0.2)]">
                                            <div class="flex justify-between items-start gap-4">
                                                <div class="flex-1">
                                                    <h4 class="hand-drawn text-3xl text-[#1e1b13] leading-tight group-hover:text-[#8e4e14] transition-colors"
                                                        x-text="item.name"></h4>
                                                    <p class="text-sm font-bold text-[#534439] mt-1"
                                                        x-text="'@ Rp ' + Number(item.price).toLocaleString('id-ID')">
                                                    </p>
                                                </div>
                                                <p class="font-heading font-black text-[#8e4e14] text-xl whitespace-nowrap"
                                                    x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')">
                                                </p>
                                            </div>

                                            <template x-if="item.notes">
                                                <div
                                                    class="text-xs font-bold text-[#366758] bg-[#b6ebd8]/30 px-3 py-2 wobbly-border-thin flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-sm">edit_note</span>
                                                    <span x-text="item.notes"></span>
                                                </div>
                                            </template>

                                            <div class="flex items-center justify-between mt-2">
                                                <div
                                                    class="flex items-center bg-[#fff8ef] wobbly-border-thin p-1">
                                                    <button @click="updateQty(id, Number(item.qty) - 1)"
                                                        class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-500 font-black transition-colors text-2xl">-</button>
                                                    <span
                                                        class="w-12 text-center font-heading font-black text-[#8e4e14] text-xl"
                                                        x-text="item.qty"></span>
                                                    <button @click="updateQty(id, Number(item.qty) + 1)"
                                                        class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-green-50 text-green-500 font-black transition-colors text-2xl">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div x-show="Object.keys(cartItems).length > 0"
                            class="p-8 bg-white border-t-4 border-[#8e4e14] sticky bottom-0 z-10">
                            <div class="space-y-4 mb-8">
                                <div class="flex flex-col gap-1">
                                    <span class="hand-drawn text-2xl text-[#8e4e14]/60 leading-none">Total Jajanan Kamu ✨</span>
                                    <span class="font-heading font-black text-5xl text-[#8e4e14] tracking-tighter"
                                        x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                            <a href="{{ route('order.checkout') }}"
                                class="block w-full bg-[#f4a261] text-white text-center hand-drawn text-3xl py-5 wobbly-border shadow-[6px_6px_0_#8e4e14] hover:scale-[1.03] active:scale-95 transition-all duration-300">
                                BAYAR SEKARANG! ⚡
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQty(menuId, qty) {
        if (qty < 0) return;
        
        const formData = new FormData();
        formData.append('menu_id', menuId);
        formData.append('qty', qty);
        formData.append('_method', 'PATCH');
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('cart.update') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const global = Alpine.$data(document.body);
                    global.cartItems = data.items;
                    global.cartCount = data.cart_count;
                    global.cartTotal = data.cart_total;
                    
                    if (data.cart_count === 0) {
                        global.cartOpen = false;
                    }
                }
            });
    }

    function clearCart() {
        if (!confirm('Beneran mau ngosongin keranjang? 🥺')) return;

        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route('cart.clear') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(() => {
                const global = Alpine.$data(document.body);
                global.cartItems = {};
                global.cartCount = 0;
                global.cartTotal = 0;
                global.cartOpen = false;
            });
    }
</script>