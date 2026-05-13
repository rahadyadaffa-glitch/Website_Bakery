@extends('layouts.customer')

@section('content')
    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop py-12 relative">
        <!-- Decorative doodle -->
        <span class="material-symbols-outlined absolute top-0 right-10 text-[#8e4e14]/5 text-[120px] pointer-events-none">shopping_cart_checkout</span>

        <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-3 bg-white wobbly-border-thin px-6 py-3 text-[#534439] font-bold hover:text-[#8e4e14] hover:bg-[#f5edde] transition-all mb-12 group hand-drawn text-2xl shadow-[3px_3px_0_#8e4e14] transform -rotate-1">
            <span class="material-symbols-outlined transition-transform group-hover:-translate-x-2">arrow_back</span>
            Kembali jajan menu lain
        </a>

        <div class="mb-12 relative">
            <h1 class="hand-drawn text-6xl text-[#8e4e14] mb-2 transform -rotate-1">Final Check! 🚀</h1>
            <p class="hand-drawn text-3xl text-[#534439] transform rotate-1">Dikit lagi makanannya sampe ke kamu!</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Left: Order Summary -->
            <div class="bg-white wobbly-border-extreme p-8 shadow-[8px_8px_0px_0px_rgba(142,78,20,0.2)] sticky top-32">
                <h4 class="hand-drawn text-4xl text-[#1e1b13] mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#8e4e14] text-4xl">shopping_basket</span> 
                    Keranjangmu ✨
                </h4>
                
                <div class="space-y-6 mb-10">
                    @foreach($cart as $id => $item)
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 bg-[#f5edde] wobbly-border-thin flex items-center justify-center font-black text-[#8e4e14] text-lg shrink-0 transform -rotate-3">
                                    {{ $item['qty'] }}x
                                </div>
                                <div>
                                    <h5 class="hand-drawn text-3xl text-[#1e1b13] leading-tight mb-1">{{ $item['name'] }}</h5>
                                    <p class="text-xs text-[#534439] font-bold uppercase tracking-widest opacity-60">Rp {{ number_format($item['price'], 0, ',', '.') }} / item</p>
                                </div>
                            </div>
                            <span class="font-heading font-black text-[#8e4e14] text-xl">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-8 border-t-2 border-dashed border-[#d8c2b5] flex justify-between items-end">
                    <div>
                        <span class="hand-drawn text-2xl text-[#534439]/60 block mb-1">Total yang harus dibayar:</span>
                        <span class="font-heading font-black text-5xl text-[#8e4e14] tracking-tighter">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right: Details Form -->
            <div class="space-y-8">
                <form action="{{ route('order.store') }}" method="POST" class="space-y-10">
                    @csrf
                    
                    <!-- Table Number Section -->
                    <div class="bg-[#f4a261]/10 wobbly-border-extreme p-8 shadow-[6px_6px_0px_0px_rgba(244,162,97,0.1)]">
                        <label class="hand-drawn text-2xl text-[#8e4e14] mb-6 text-center block">Kamu duduk di meja nomor: 📍</label>
                        
                        @if(session('table_number'))
                            <div class="font-heading font-black text-7xl text-[#8e4e14] text-center mb-2 transform -rotate-2">
                                {{ session('table_number') }}
                            </div>
                            <input type="hidden" name="table_number" value="{{ session('table_number') }}">
                            <p class="hand-drawn text-xl text-[#8e4e14]/60 mt-4 text-center">
                                Meja terdeteksi otomatis ✨
                            </p>
                        @else
                            <input type="text" name="table_number" required 
                                   placeholder="Contoh: 12" 
                                   class="w-full px-8 py-6 wobbly-border-thin focus:border-[#8e4e14] focus:ring-8 focus:ring-[#8e4e14]/5 transition-all font-heading font-black text-5xl text-[#8e4e14] text-center bg-white shadow-xl shadow-[#8e4e14]/5">
                            <p class="hand-drawn text-xl text-[#8e4e14]/60 mt-4 text-center italic">
                                Lihat nomor di meja kamu ya!
                            </p>
                        @endif

                        @error('table_number')
                            <p class="text-red-500 text-xs font-black mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Other Info -->
                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="hand-drawn text-2xl text-[#8e4e14] ml-1">Siapa namamu? <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" 
                                   value="{{ session('customer_name') }}"
                                   {{ session('customer_name') ? 'readonly' : 'required' }}
                                   placeholder="Biar akrab pas manggil..." 
                                   class="w-full px-6 py-4 wobbly-border-thin focus:border-[#8e4e14] focus:ring-0 transition-all font-bold text-xl bg-white {{ session('customer_name') ? 'bg-[#f5edde] opacity-70' : '' }}">
                            @if(session('customer_name'))
                                <p class="hand-drawn text-lg text-[#8e4e14] ml-1 italic">Nama kamu sudah dikunci ✨</p>
                            @endif
                            @error('customer_name')
                                <p class="text-red-500 text-sm font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="hand-drawn text-2xl text-[#8e4e14] ml-1">Ada catatan khusus?</label>
                            <textarea name="notes" placeholder="Misal: Gak pake es, atau gulanya dikit aja..." rows="3"
                                      class="w-full px-6 py-4 wobbly-border-thin focus:border-[#8e4e14] focus:ring-0 transition-all font-bold text-xl bg-white resize-none"></textarea>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-[#8e4e14] text-white hand-drawn text-4xl py-6 wobbly-border-extreme shadow-[8px_8px_0px_0px_rgba(142,78,20,0.3)] hover:scale-[1.03] hover:rotate-1 active:scale-95 transition-all duration-300">
                            Pesan Sekarang! 🧁
                        </button>
                        <p class="hand-drawn text-xl text-[#534439]/40 text-center mt-8 uppercase tracking-[0.2em]">
                            SweetBite Hand-Drawn Artisanal
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
