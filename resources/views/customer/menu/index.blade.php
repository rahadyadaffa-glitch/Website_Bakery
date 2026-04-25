@extends('layouts.customer')

@section('content')
    <div x-data="menuPage()" x-init="init()" class="min-h-screen">
        
        <!-- Categories Navigation (Bubbly Tabs) -->
        <section class="mx-6 mb-12 overflow-x-auto no-scrollbar py-6 sticky top-16 z-30">
            <div class="flex items-center justify-center gap-4">
                @foreach($categories as $cat)
                    <a href="{{ route('menu.index', $cat->id) }}" 
                       class="px-8 py-3 rounded-full font-heading font-black text-sm tracking-wide transition-all border-4 {{ (isset($category) && $category->id == $cat->id) ? 'bg-accent border-primary text-primary shadow-[4px_4px_0px_0px_#427AB5]' : 'bg-white border-border text-text-secondary hover:border-accent' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Clean Page Header -->
        <section class="mx-6 mb-12 text-center">
            <h1 class="font-heading text-6xl text-primary font-black tracking-tight mb-4 uppercase">
                {{ $category->name }}
            </h1>
            <div class="hand-drawn text-2xl text-secondary -rotate-2 mb-8">
                Pilih menu favoritmu di bawah ini! 👇
            </div>
            
            <!-- Star Legend (Gen Z style) -->
            <div class="flex items-center justify-center gap-3 text-sm font-black text-white bg-primary px-8 py-3 rounded-2xl border-4 border-white shadow-[8px_8px_0px_0px_#F7DD7D] w-max mx-auto -rotate-1">
                <span class="material-symbols-outlined text-2xl text-accent" style="font-variation-settings: 'FILL' 1, 'wght' 700;">stars</span>
                <span class="uppercase tracking-tight">Menu Paling Rebutan! 🔥</span>
            </div>
        </section>

        <!-- Menu Grid (Playful Cards) -->
        <section class="mx-6 pb-32">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-10">
                @forelse($menus as $menu)
                    <div class="flex flex-col group bg-white p-6 rounded-[2.5rem] border-4 border-border hover:border-primary transition-all duration-300 bubbly-shadow-hover cursor-pointer"
                         @click="openItemModal({{ json_encode($menu) }})">
                        <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] mb-6 bg-primary-light/30 border-2 border-border group-hover:border-primary/20 transition-colors">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                 src="{{ $menu->image ? Storage::url($menu->image) : 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&q=80&w=1000' }}">
                            
                            <!-- Best Seller Badge (High Contrast) -->
                            @if($menu->badge === 'best_seller')
                                <div class="absolute top-4 left-4 bg-primary border-4 border-white w-12 h-12 rounded-2xl flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)] z-20">
                                    <span class="material-symbols-outlined text-3xl text-accent" style="font-variation-settings: 'FILL' 1;">stars</span>
                                </div>
                            @endif

                            <!-- Always Visible Add Button (Bubbly Style) -->
                            <button @click="openItemModal({{ json_encode($menu) }})" 
                                    class="absolute bottom-3 right-3 bg-white border-4 border-primary text-primary w-14 h-14 rounded-2xl flex items-center justify-center shadow-[4px_4px_0px_0px_#427AB5] hover:bg-accent hover:scale-110 active:scale-90 transition-all z-20">
                                <span class="material-symbols-outlined text-3xl font-black">add</span>
                            </button>
                        </div>
                        
                        <div class="px-2">
                            <h3 class="font-heading font-black text-2xl text-primary leading-tight mb-2 group-hover:text-accent-dark transition-colors" x-text="'{{ $menu->name }}'"></h3>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="font-black text-xl text-primary bg-accent/20 px-3 py-1 rounded-xl">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <span class="material-symbols-outlined text-9xl text-border mb-4">sentiment_dissatisfied</span>
                        <h4 class="font-heading font-black text-3xl text-text-secondary opacity-50">Menu belum tersedia...</h4>
                    </div>
                @endforelse
            </div>
        </section>

        @include('customer.menu.partials.item_modal')
        @include('customer.menu.partials.cart_slide')
    </div>
@endsection

@push('scripts')
<script>
    function menuPage() {
        return {
            selectedItem: {
                id: null,
                name: '',
                price: 0,
                description: '',
                qty: 1,
                notes: ''
            },
            init() {
                // Initialize component
            },
            openItemModal(menu) {
                // Correctly initialize selectedItem with values to prevent NaN
                this.selectedItem = {
                    ...menu,
                    qty: 1,
                    notes: '',
                    image_url: menu.image ? '{{ Storage::url('') }}' + menu.image : 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&q=80&w=1000'
                };
                
                const global = Alpine.$data(document.body);
                global.itemModalOpen = true;
            },
            closeItemModal() {
                const global = Alpine.$data(document.body);
                global.itemModalOpen = false;
            },
            addToCartWithDetails() {
                if (!this.selectedItem.id) return;
                
                fetch('{{ route('cart.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        menu_id: this.selectedItem.id,
                        qty: this.selectedItem.qty,
                        notes: this.selectedItem.notes
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const global = Alpine.$data(document.body);
                        global.cartCount = Number(data.cart_count);
                        global.cartTotal = Number(data.cart_total);
                        global.cartItems = data.items;
                        
                        this.closeItemModal();
                    }
                });
            },
            clearCart() {
                fetch('{{ route('cart.clear') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const global = Alpine.$data(document.body);
                    global.cartCount = 0;
                    global.cartTotal = 0;
                    global.cartItems = {};
                });
            }
        }
    }
</script>
@endpush
