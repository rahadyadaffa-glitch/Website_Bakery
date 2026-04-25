@extends('layouts.customer')

@section('content')
    <div class="px-4 py-8 min-h-[85vh] flex flex-col items-center justify-center text-center">
        
        <!-- Big Celebration Emoji -->
        <div class="text-8xl mb-6 animate-bounce">🎉</div>
        
        <h1 class="font-heading font-black text-4xl text-primary mb-3">Pesanan Masuk!</h1>
        <p class="text-text-secondary font-medium text-lg mb-8 max-w-[300px]">
            Tunggu sebentar ya, chef kami lagi menyiapkan pesananmu dengan penuh cinta. 👨‍🍳✨
        </p>

        <!-- Order details card -->
        <div class="bg-white border-2 border-primary/20 rounded-3xl p-6 w-full shadow-lg mb-10">
            <p class="text-sm text-text-secondary mb-1">Nomor Pesanan</p>
            <p class="font-mono font-bold text-xl text-primary mb-4 bg-primary-light/50 py-2 rounded-xl border border-primary/20">{{ $order->order_number }}</p>
            
            <p class="text-sm text-text-secondary mb-1">Silakan tunggu di</p>
            <p class="font-heading font-black text-3xl text-accent-dark">Meja {{ $order->table_number }}</p>
        </div>

        <a href="{{ route('menu.index') }}" class="bg-accent text-primary font-heading font-bold text-lg px-8 py-4 rounded-2xl shadow-md hover:bg-accent-dark hover:scale-105 active:scale-95 transition">
            Pesan Lagi Nanti 🍰
        </a>

    </div>
@endsection
