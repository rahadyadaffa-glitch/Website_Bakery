@extends('layouts.customer')

@section('content')
    <div class="px-4 py-8 pb-24 text-center min-h-[80vh] flex flex-col justify-center items-center">
        
        <div class="bg-white p-8 rounded-[40px] border border-border shadow-xl w-full relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent-light rounded-full z-0"></div>
            
            <div class="relative z-10">
                <div class="text-6xl mb-4">💸</div>
                <h1 class="font-heading font-black text-2xl text-primary mb-2">Selesaikan Pembayaran</h1>
                <p class="text-text-secondary text-sm mb-6">Order ID: <span class="font-mono font-bold">{{ $order->order_number }}</span></p>

                <div class="bg-bg-secondary p-6 rounded-3xl mb-8 border border-border">
                    <p class="text-sm font-medium text-text-secondary mb-1">Total yang harus dibayar</p>
                    <p class="font-heading font-black text-4xl text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>

                <div class="bg-blue-50 text-blue-800 text-xs text-left p-4 rounded-2xl mb-8 border border-blue-200">
                    <p class="font-bold mb-1">ℹ️ Simulasi Dummy Payment</p>
                    <p>Karena ini adalah versi simulasi, silakan klik tombol di bawah untuk langsung mengonfirmasi pembayaran Anda.</p>
                </div>

                <form action="{{ route('payment.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-primary text-white text-center font-heading font-bold text-lg py-4 rounded-2xl shadow-md hover:bg-primary-dark hover:shadow-lg hover:-translate-y-1 active:scale-95 transition-all">
                        Konfirmasi Sudah Bayar ✅
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
