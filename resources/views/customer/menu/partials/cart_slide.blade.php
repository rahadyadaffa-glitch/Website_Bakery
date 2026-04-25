<!-- Slide-in Cart Panel (Gen Z Style) -->
<div x-cloak x-show="cartOpen" class="relative z-[100]" aria-labelledby="slide-over-title" role="dialog"
    aria-modal="true">

    <!-- Backdrop -->
    <div x-show="cartOpen" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" @click="cartOpen = false"></div>

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
                        class="flex h-full flex-col overflow-y-scroll bg-background shadow-2xl rounded-l-[3rem] border-l-8 border-primary relative">

                        <!-- Header -->
                        <div
                            class="px-8 py-10 flex flex-col gap-4 sticky top-0 bg-background/90 backdrop-blur-md z-10 border-b-4 border-border">
                            <div class="flex items-center justify-between">
                                <h2 class="font-heading font-black text-3xl text-primary flex items-center gap-2"
                                    id="slide-over-title">
                                    <span class="material-symbols-outlined text-4xl">shopping_basket</span> PESANAN KAMU
                                </h2>
                                <button @click="cartOpen = false"
                                    class="p-3 bg-white border-4 border-primary rounded-2xl text-primary hover:bg-accent transition-all shadow-[4px_4px_0px_0px_#427AB5]">
                                    <span class="material-symbols-outlined font-black">close</span>
                                </button>
                            </div>
                            <template x-if="Object.keys(cartItems).length > 0">
                                <button @click="clearCart()"
                                    class="group flex items-center gap-3 px-6 py-4 bg-danger text-white border-4 border-primary rounded-[2rem] font-heading font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all w-full shadow-[8px_8px_0px_0px_rgba(242,92,92,0.3)] justify-center mb-4">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:rotate-12 transition-transform">delete_forever</span>
                                    Duh, hapus semua aja! 🗑️
                                </button>
                            </template>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 px-8 py-8 relative">
                            <template x-if="Object.keys(cartItems).length === 0">
                                <div class="h-full flex flex-col items-center justify-center text-center py-20">
                                    <div class="text-9xl mb-8 floating">🍦</div>
                                    <h4 class="font-heading font-black text-3xl text-primary mb-4 uppercase">Wah, masih
                                        sepi!</h4>
                                    <p class="text-text-secondary font-bold px-8 opacity-70">Ayo jajan dulu biar hari
                                        kamu makin manis! ✨</p>
                                    <button @click="cartOpen = false"
                                        class="mt-10 px-10 py-5 bg-accent border-4 border-primary text-primary font-heading font-black text-xl rounded-full shadow-[6px_6px_0px_0px_#427AB5] hover:scale-105 active:scale-95 transition-all">
                                        GAS PESAN SEKARANG! 🚀
                                    </button>
                                </div>
                            </template>

                            <template x-if="Object.keys(cartItems).length > 0">
                                <div class="space-y-8">
                                    <template x-for="(item, id) in cartItems" :key="id">
                                        <div
                                            class="group flex flex-col gap-4 p-6 bg-white rounded-[2rem] border-4 border-border hover:border-primary transition-all duration-300 shadow-[6px_6px_0px_0px_rgba(0,0,0,0.05)] hover:shadow-[8px_8px_0px_0px_rgba(66,122,181,0.2)]">
                                            <div class="flex justify-between items-start gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-heading font-black text-2xl text-primary leading-tight group-hover:text-accent-dark transition-colors"
                                                        x-text="item.name"></h4>
                                                    <p class="text-sm font-bold text-text-secondary mt-1"
                                                        x-text="'@ Rp ' + Number(item.price).toLocaleString('id-ID')">
                                                    </p>
                                                </div>
                                                <p class="font-heading font-black text-primary text-xl whitespace-nowrap"
                                                    x-text="'Rp ' + (item.price * item.qty).toLocaleString('id-ID')">
                                                </p>
                                            </div>

                                            @if($item['notes'] ?? true)
                                                <template x-if="item.notes">
                                                    <div
                                                        class="text-xs font-bold text-secondary bg-accent-light px-3 py-2 rounded-xl border-2 border-accent flex items-center gap-2">
                                                        <span>📝</span>
                                                        <span x-text="item.notes"></span>
                                                    </div>
                                                </template>
                                            @endif

                                            <div class="flex items-center justify-between mt-2">
                                                <div
                                                    class="flex items-center bg-background rounded-2xl p-1 border-4 border-border group-hover:border-primary transition-colors">
                                                    <button @click="updateQty(id, Number(item.qty) - 1)"
                                                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-danger/10 hover:text-danger font-black transition-colors text-2xl">-</button>
                                                    <span
                                                        class="w-12 text-center font-heading font-black text-primary text-xl"
                                                        x-text="item.qty"></span>
                                                    <button @click="updateQty(id, Number(item.qty) + 1)"
                                                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-success/10 hover:text-success font-black transition-colors text-2xl">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <!-- Footer -->
                        <div x-show="Object.keys(cartItems).length > 0"
                            class="p-8 bg-white border-t-8 border-primary sticky bottom-0 z-10">
                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between items-center text-text-secondary">
                                    <span class="font-black uppercase tracking-widest text-xs">Subtotal (<span
                                            x-text="cartCount"></span> item)</span>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="font-black text-primary text-sm uppercase tracking-widest opacity-50">Total
                                        Bayar</span>
                                    <span class="font-heading font-black text-5xl text-primary tracking-tighter"
                                        x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                            <a href="{{ route('order.checkout') }}"
                                class="block w-full bg-accent text-primary text-center font-heading font-black text-2xl py-6 rounded-full border-4 border-primary shadow-[8px_8px_0px_0px_#427AB5] hover:scale-[1.02] active:scale-95 transition-all duration-300">
                                CHECKOUT SEKARANG! ⚡
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
            });
    }
</script>