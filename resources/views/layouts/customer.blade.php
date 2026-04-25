<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SweetBite 🍰 — Indulgent Dessert Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fredoka:wght@300;400;500;600;700&family=Gochi+Hand&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

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
            background-color: #FFFDF7;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body.modal-open {
            overflow: hidden;
        }

        /* ═══ Candy Pop Background ═══ */
        .page-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: #FFFDF7;
            overflow: hidden;
        }

        /* Bold candy circles — blue */
        .candy-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        /* Rounded candy squares — yellow */
        .candy-square {
            position: absolute;
            border-radius: 2.5rem;
            pointer-events: none;
        }

        /* Wavy bottom */
        .candy-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            pointer-events: none;
            animation: wave-slide 25s linear infinite;
        }

        @keyframes wave-slide {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Gentle bounce for shapes */
        @keyframes candy-bounce {
            0%, 100% { transform: translateY(0) rotate(var(--rot, 0deg)); }
            50%      { transform: translateY(-18px) rotate(var(--rot, 0deg)); }
        }

        .main-unit {
            position: relative;
            z-index: 10;
        }

        .bubbly-shadow {
            box-shadow: 8px 8px 0px 0px rgba(66, 122, 181, 0.2);
        }

        .bubbly-shadow-hover:hover {
            box-shadow: 12px 12px 0px 0px rgba(66, 122, 181, 0.3);
            transform: translate(-4px, -4px);
        }

        .hand-drawn {
            font-family: 'Gochi Hand', cursive;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: floating 4s infinite ease-in-out;
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

<body class="text-text-primary antialiased min-h-screen" :class="{ 'modal-open': cartOpen || itemModalOpen }" x-data="{ 
        cartOpen: false, 
        itemModalOpen: false, 
        cartCount: Number({{ session('cart') ? array_sum(array_column(session('cart'), 'qty')) : 0 }}),
        cartTotal: Number({{ session('cart') ? array_sum(array_map(fn($i) => $i['price'] * $i['qty'], session('cart'))) : 0 }}),
        cartItems: {{ json_encode(session('cart', [])) }},
        cartBouncing: false
      }">

    <div class="page-bg">
        <!-- Large blue circle — top right -->
        <div class="candy-circle" style="width:420px; height:420px; top:-120px; right:-80px; background:rgba(66,122,181,0.10); border:6px solid rgba(66,122,181,0.08);"></div>

        <!-- Medium yellow square — bottom left -->
        <div class="candy-square" style="width:300px; height:300px; bottom:-60px; left:-50px; background:rgba(247,221,125,0.18); border:6px solid rgba(247,221,125,0.12); --rot:12deg; animation: candy-bounce 6s ease-in-out infinite;"></div>

        <!-- Small blue circle — middle left -->
        <div class="candy-circle" style="width:180px; height:180px; top:35%; left:5%; background:rgba(66,122,181,0.08); border:4px solid rgba(66,122,181,0.06); --rot:-8deg; animation: candy-bounce 7s ease-in-out infinite; animation-delay:-2s;"></div>

        <!-- Small yellow circle — center right -->
        <div class="candy-circle" style="width:150px; height:150px; top:55%; right:10%; background:rgba(247,221,125,0.14); border:4px solid rgba(247,221,125,0.10); --rot:6deg; animation: candy-bounce 5s ease-in-out infinite; animation-delay:-1s;"></div>

        <!-- Tiny blue square — top center -->
        <div class="candy-square" style="width:100px; height:100px; top:12%; left:40%; background:rgba(66,122,181,0.06); border:3px solid rgba(66,122,181,0.05); --rot:-15deg; animation: candy-bounce 8s ease-in-out infinite; animation-delay:-3s;"></div>

        <!-- Wavy bottom edge -->
        <svg class="candy-wave" viewBox="0 0 2400 120" style="height:100px; opacity:0.06; fill:#427AB5;">
            <path d="M0,60 C200,120 400,0 600,60 C800,120 1000,0 1200,60 C1400,120 1600,0 1800,60 C2000,120 2200,0 2400,60 L2400,120 L0,120 Z"></path>
        </svg>
    </div>

    <!-- Dynamic Top Navigation (Shrinks on Desktop, Hides on Mobile) -->
    <header
        class="fixed top-0 left-0 z-50 transition-all duration-500 ease-in-out bg-white border-b-4 border-primary overflow-hidden shadow-sm"
        :class="cartOpen ? (window.innerWidth < 1024 ? '-translate-y-full' : '') : 'translate-y-0'"
        :style="cartOpen && window.innerWidth >= 1024 ? 'width: calc(100% - 28rem)' : 'width: 100%'">
        <div class="flex justify-between items-center px-6 py-4">
            <a href="{{ route('menu.index') }}"
                class="text-2xl font-heading font-black tracking-tight text-primary uppercase italic whitespace-nowrap">
                SweetBite 🧁
            </a>
        </div>
    </header>

    <main class="pt-24 pb-32 min-h-screen main-unit">
        @yield('content')
    </main>

    <!-- Bottom Cart Bar (Hidden when item modal is open) -->
    <div x-cloak
        x-show="cartCount > 0 && !itemModalOpen && !window.location.pathname.includes('/checkout') && !window.location.pathname.includes('/payment')"
        x-transition:enter="translate-y-full transition ease-out duration-500"
        x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="translate-y-full transition ease-in duration-500"
        class="fixed bottom-0 left-0 right-0 z-50 p-6 flex justify-center pointer-events-none">

        <div @click="cartOpen = true"
            class="w-full max-w-2xl bg-accent text-primary p-4 rounded-[2.5rem] shadow-[10px_10px_0px_0px_#427AB5] flex items-center justify-between cursor-pointer pointer-events-auto hover:scale-[1.02] active:scale-95 transition-all border-4 border-primary group">
            <div class="flex items-center gap-4">
                <div class="bg-white/50 p-3 rounded-2xl border-2 border-primary">
                    <span class="material-symbols-outlined text-primary text-3xl font-black">shopping_basket</span>
                </div>
                <div>
                    <p class="text-[10px] font-black text-primary/60 uppercase tracking-widest leading-none mb-1">
                        Pesanan Kamu ✨</p>
                    <h4 class="font-heading font-black text-2xl">
                        <span x-text="cartCount"></span> Item • <span
                            x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                    </h4>
                </div>
            </div>
            <div
                class="flex items-center justify-center w-14 h-14 bg-white border-4 border-primary rounded-2xl group-hover:bg-primary group-hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(66,122,181,0.2)]">
                <span class="material-symbols-outlined font-black">arrow_forward</span>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>