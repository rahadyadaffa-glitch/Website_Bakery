@extends('layouts.customer')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12">
        <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant font-bold hover:text-primary transition-colors mb-8 group">
            <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
            Kembali ke Menu
        </a>

        <div class="mb-12">
            <h1 class="font-heading font-black text-4xl text-primary mb-2">Final Check! 🚀</h1>
            <p class="text-on-surface-variant font-medium text-lg">Dikit lagi makanannya sampe ke kamu!</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Left: Order Summary -->
            <div class="bg-white rounded-xl p-8 border border-surface-container shadow-sm sticky top-32">
                <h4 class="font-heading font-black text-2xl text-on-surface mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl">shopping_basket</span> 
                    Ringkasan Pesanan
                </h4>
                
                <div class="space-y-6 mb-10">
                    @foreach($cart as $id => $item)
                        <div class="flex justify-between items-start">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-surface-container rounded-xl flex items-center justify-center font-black text-primary text-lg shrink-0">
                                    {{ $item['qty'] }}x
                                </div>
                                <div>
                                    <h5 class="font-bold text-on-surface leading-tight mb-1">{{ $item['name'] }}</h5>
                                    <p class="text-xs text-on-surface-variant font-medium">Rp {{ number_format($item['price'], 0, ',', '.') }} per item</p>
                                </div>
                            </div>
                            <span class="font-black text-primary text-lg">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-8 border-t-2 border-dashed border-surface-container flex justify-between items-end">
                    <div>
                        <span class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest block mb-1">Total yang harus dibayar</span>
                        <span class="font-heading font-black text-4xl text-primary tracking-tighter">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Details Form -->
            <div class="space-y-8">
                <form action="{{ route('order.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Table Number Section -->
                    <div class="bg-primary/5 rounded-xl p-8 border-2 border-primary/20">
                        <label class="block font-black text-primary text-sm uppercase tracking-widest mb-6 text-center">Nomor Meja Kamu 📍</label>
                        <input type="text" name="table_number" required placeholder="Contoh: 12" 
                               class="w-full px-8 py-6 rounded-xl border-4 border-white focus:border-primary focus:ring-8 focus:ring-primary/10 transition-all font-heading font-black text-4xl text-primary text-center bg-white shadow-xl shadow-primary/5">
                        <p class="text-xs text-primary/60 font-bold mt-4 text-center">Lihat nomor di kertas/stiker di meja kamu</p>
                        @error('table_number')
                            <p class="text-error text-xs font-black mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Other Info -->
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block font-black text-on-surface-variant text-[10px] uppercase tracking-widest ml-1">Nama Kamu (Opsional)</label>
                            <input type="text" name="customer_name" placeholder="Biar akrab pas manggil..." 
                                   class="w-full px-6 py-4 rounded-xl border-2 border-surface-container focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-lg bg-white">
                        </div>

                        <div class="space-y-2">
                            <label class="block font-black text-on-surface-variant text-[10px] uppercase tracking-widest ml-1">Catatan Tambahan</label>
                            <textarea name="notes" placeholder="Misal: Gak pake es, atau gulanya dikit aja..." rows="3"
                                      class="w-full px-6 py-4 rounded-xl border-2 border-surface-container focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-lg bg-white resize-none"></textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-primary text-white font-heading font-black text-2xl py-6 rounded-full shadow-[8px_8px_0px_0px_rgba(66,122,181,0.3)] hover:shadow-[12px_12px_0px_0px_rgba(66,122,181,0.4)] hover:translate-x-[-4px] hover:translate-y-[-4px] active:scale-95 transition-all duration-300 border-4 border-primary-dark">
                            Order Now! 🧁
                        </button>
                        <p class="text-[10px] text-on-surface-variant font-bold text-center mt-6 uppercase tracking-[0.2em] opacity-40">
                            By SweetBite Experience Studio
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
