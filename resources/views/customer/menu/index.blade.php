@extends('layouts.customer')

@section('content')
    <div x-data="menuPage()" x-init="init()" class="min-h-screen w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        
        <!-- Hero Title Section -->
        <section class="mb-20 text-center relative mt-10">
            <div class="inline-flex items-center gap-2 bg-[#f4a261] wobbly-border-extreme px-6 py-3 mb-8 transform -rotate-3 shadow-[4px_4px_0_#8e4e14]">
                <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span class="font-heading font-black text-white text-2xl tracking-wide uppercase">Menu Paling Rebutan! 🔥</span>
                <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">stars</span>
            </div>

            <div class="relative inline-block">
                <h1 class="hand-drawn text-[64px] leading-tight text-[#8e4e14] mb-6 wobbly-border inline-block p-8 bg-white relative shadow-[6px_6px_0_#8e4e14] transform rotate-1">
                    {{ isset($category) ? $category->name : 'Pilih Jajananmu!' }}
                    <span class="material-symbols-outlined absolute -bottom-8 -right-8 text-[60px] text-[#366758] transform rotate-12">edit</span>
                    <span class="material-symbols-outlined absolute -top-8 -left-8 text-[50px] text-[#725477] transform -rotate-12">auto_awesome</span>
                </h1>
            </div>
            
            @if(isset($category))
                <p class="hand-drawn text-[28px] text-[#534439] max-w-2xl mx-auto mt-6 wobbly-border-thin bg-white px-6 py-3 transform -rotate-1 inline-block">
                    Kategori: <span class="font-bold underline">{{ $category->name }}</span> ✨
                </p>
            @endif
        </section>

        <!-- Artisanal Category Filters -->
        <section class="flex flex-wrap justify-center gap-4 mb-20 px-2">
            @foreach($categories as $cat)
                <a href="{{ route('menu.index', array_merge(['category' => $cat->id, 'table' => session('table_number')], request()->query())) }}" 
                   class="{{ (isset($category) && $category->id == $cat->id) ? 'bg-[#f4a261] text-white wobbly-border-extreme' : 'bg-white text-[#534439] wobbly-border' }} px-8 py-3 hand-drawn text-2xl sketch-button transform {{ $loop->index % 2 == 0 ? '-rotate-2' : 'rotate-2' }} inline-block hover:text-[#366758] transition-all">
                    {{ $cat->name }}
                </a>
            @endforeach
        </section>

        <!-- Product Grid -->
        <section class="relative pb-32">
            <!-- Decorative line behind grid -->
            <div class="absolute top-1/2 left-0 w-full border-t-4 border-dashed border-[#8e4e14] opacity-10 -z-10"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @forelse($menus as $menu)
                    <article class="bg-white wobbly-border-extreme p-6 relative group hover:-translate-y-3 transition-all duration-300 transform {{ $loop->index % 2 == 0 ? '-rotate-2 hover:rotate-0' : 'rotate-2 hover:rotate-0' }} cursor-pointer"
                             @click="openItemModal({{ json_encode($menu) }})">
                        
                        @if($menu->badge === 'best_seller')
                            <span class="material-symbols-outlined absolute -top-4 -left-4 text-white z-10 bg-[#f4a261] rounded-full p-2 wobbly-border text-[32px] shadow-[2px_2px_0_#8e4e14]" style="font-variation-settings: 'FILL' 1;">stars</span>
                        @endif

                        <div class="aspect-[4/3] w-full overflow-hidden wobbly-border mb-6 bg-[#f5edde] relative">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                                 src="{{ $menu->image ? Storage::url($menu->image) : 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&q=80&w=1000' }}">
                            <div class="absolute inset-0 bg-[#8e4e14] opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        </div>

                        <div class="flex justify-between items-end">
                            <div class="bg-white wobbly-border-thin px-5 py-3 transform {{ $loop->index % 2 == 0 ? 'rotate-1' : '-rotate-1' }} flex-1 mr-4">
                                <h3 class="hand-drawn text-3xl text-[#1e1b13] mb-1 leading-tight">{{ $menu->name }}</h3>
                                <p class="font-heading font-black text-2xl text-[#8e4e14]">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            </div>
                            
                            <button @click.stop="openItemModal({{ json_encode($menu) }})" 
                                    class="w-16 h-16 bg-[#b6ebd8] text-[#1c4f41] wobbly-border flex items-center justify-center sketch-button hover:bg-[#366758] hover:text-white transition-colors shadow-[3px_3px_0_#8e4e14] transform {{ $loop->index % 2 == 0 ? '-rotate-3' : 'rotate-3' }} shrink-0">
                                <span class="material-symbols-outlined text-[36px] font-black">add</span>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="hand-drawn text-4xl text-[#8e4e14]/40 rotate-2">
                            Yah, jajanan di sini lagi habis... 🥺
                        </div>
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
            }
        }
    }
</script>
@endpush
