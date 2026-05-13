<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SweetBite 🍰 — Indulgent Dessert Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .hand-drawn {
            font-family: 'Caveat', cursive;
        }

        body.modal-open {
            overflow: hidden;
        }

        /* ═══ Background Textures ═══ */
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        @keyframes wave-slide {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="antialiased min-h-screen" :class="{ 'modal-open': cartOpen || itemModalOpen }" x-data="{ 
        cartOpen: false, 
        itemModalOpen: false, 
        cartCount: Number({{ session('cart') ? array_sum(array_column(session('cart'), 'qty')) : 0 }}),
        cartTotal: Number({{ session('cart') ? array_sum(array_map(fn($i) => $i['price'] * $i['qty'], session('cart'))) : 0 }}),
        cartItems: {{ json_encode(session('cart', [])) }},
        cartBouncing: false
      }">

    <div class="page-bg">
        <!-- Watercolor blobs -->
        <div class="watercolor-blob w-[500px] h-[500px] top-[-50px] left-[-150px] opacity-70"></div>
        <div class="watercolor-blob w-[600px] h-[600px] top-[30%] right-[-200px] opacity-60 bg-[#b6ebd8]"></div>
        <div class="watercolor-blob w-[450px] h-[450px] bottom-[10%] left-[10%] opacity-50 bg-[#dfbbe4]"></div>

        <!-- Decorative Doodles -->
        <span class="doodle-accent text-[60px] top-32 left-10 transform -rotate-12">stylus_note</span>
        <span class="doodle-accent text-[80px] top-64 right-20 transform rotate-45 opacity-40">gesture</span>
        <span class="doodle-accent text-[50px] bottom-40 left-1/4 transform rotate-180 opacity-50">arrow_warm_up</span>
        <span class="doodle-accent text-[70px] top-1/2 right-1/4 transform -rotate-45 opacity-30">draw</span>
    </div>

    <!-- Artisanal Header -->
    <header class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-3rem)] max-w-container-max px-6 py-4 bg-white/90 backdrop-blur-sm wobbly-border-thin shadow-sm transform transition-all duration-500"
            :class="cartOpen ? '-translate-y-[150%] opacity-0' : '-rotate-1 translate-y-0 opacity-100'">
        <div class="flex justify-between items-center mx-auto">
            <a href="{{ route('menu.index', ['table' => session('table_number')]) }}"
                class="hand-drawn font-black text-4xl text-[#8e4e14] italic transform -rotate-2 px-4 py-1 bg-white wobbly-border-thin shadow-[2px_2px_0_#8e4e14] flex items-center gap-2">
                SweetBite <span class="material-symbols-outlined text-[32px]">cake</span>
            </a>
            
            <div class="flex items-center gap-4">
                @if(session('table_number'))
                    <div class="bg-[#f4a261] text-white wobbly-border-thin px-4 py-1 transform rotate-2 hidden md:block">
                        <span class="text-xs font-black uppercase tracking-widest">Meja</span>
                        <span class="font-heading font-black text-xl ml-1">{{ session('table_number') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main class="pt-32 pb-32 min-h-screen relative z-10">
        @yield('content')
    </main>

    <!-- Artisanal Bottom Cart Bar -->
    <div x-cloak
        x-show="cartCount > 0 && !itemModalOpen && !window.location.pathname.includes('/checkout') && !window.location.pathname.includes('/payment')"
        x-transition:enter="translate-y-full transition ease-out duration-500"
        x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="translate-y-full transition ease-in duration-500"
        class="fixed bottom-0 left-0 right-0 z-50 p-6 flex justify-center pointer-events-none">

        <div @click="cartOpen = true"
            class="w-full max-w-2xl bg-[#8e4e14] text-white p-5 wobbly-border-extreme shadow-[6px_6px_0px_0px_rgba(142,78,20,0.3)] flex items-center justify-between cursor-pointer pointer-events-auto hover:scale-[1.05] hover:rotate-1 active:scale-95 transition-all group">
            <div class="flex items-center gap-5">
                <div class="bg-white/20 p-3 wobbly-border-thin">
                    <span class="material-symbols-outlined text-white text-3xl font-black">shopping_basket</span>
                </div>
                <div>
                    <p class="hand-drawn text-lg text-white/80 leading-none mb-1">Daftar Jajan Kamu ✨</p>
                    <h4 class="font-heading font-black text-2xl">
                        <span x-text="cartCount"></span> Item • <span x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                    </h4>
                </div>
            </div>
            <div class="flex items-center justify-center w-14 h-14 bg-white text-[#8e4e14] wobbly-border-thin group-hover:rotate-12 transition-all shadow-[3px_3px_0px_0px_rgba(0,0,0,0.1)]">
                <span class="material-symbols-outlined font-black">arrow_forward</span>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>