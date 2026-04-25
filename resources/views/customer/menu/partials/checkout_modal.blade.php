<!-- Checkout Modal -->
<div x-cloak
     x-show="checkoutOpen" 
     class="fixed inset-0 z-[110] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="checkoutOpen" 
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-on-surface/70 backdrop-blur-md transition-opacity" 
         @click="checkoutOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="checkoutOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="relative transform overflow-hidden rounded-xl bg-background text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-white/20">
            
            <!-- Close Button -->
            <button @click="checkoutOpen = false" class="absolute top-6 right-6 z-20 p-2 bg-surface-container rounded-full hover:bg-error hover:text-white transition-all duration-300 group">
                <span class="material-symbols-outlined transition-transform group-hover:rotate-90">close</span>
            </button>

            <!-- Decorative Blobs -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-accent/20 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl opacity-50"></div>

            <div class="px-8 pt-8 pb-4">
                <h3 class="font-heading font-black text-3xl text-primary flex items-center gap-3">
                    Final Check! 🚀
                </h3>
                <p class="text-on-surface-variant font-medium mt-1">Dikit lagi makanannya sampe ke kamu!</p>
            </div>

            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Order Summary -->
                    <div class="bg-white rounded-xl p-6 border border-surface-container shadow-sm">
                        <h4 class="font-heading font-black text-lg text-on-surface mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">shopping_bag</span> Ringkasan
                        </h4>
                        <div class="space-y-3 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
                            @if(!empty($cart))
                                @foreach($cart as $item)
                                    <div class="flex justify-between text-sm">
                                        <div class="flex items-start gap-2">
                                            <span class="font-black text-primary">{{ $item['qty'] }}x</span>
                                            <span class="font-bold text-on-surface leading-tight">{{ $item['name'] }}</span>
                                        </div>
                                        <span class="font-black text-secondary shrink-0 ml-4 text-xs">Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="mt-6 pt-4 border-t-2 border-dashed border-surface-container flex justify-between items-end">
                            <span class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Total Bayar</span>
                            <span class="font-heading font-black text-2xl text-primary tracking-tighter">
                                Rp {{ number_format($cartTotal ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Right: Customer Info -->
                    <div>
                        <form action="{{ route('order.store') }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <!-- Table Input -->
                            <div class="relative group">
                                <label class="block font-black text-primary text-[10px] uppercase tracking-widest mb-2 ml-1">Nomor Meja Kamu</label>
                                <input type="text" name="table_number" required placeholder="12" 
                                       class="w-full px-6 py-4 rounded-xl border-2 border-surface-container focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-heading font-black text-2xl text-primary text-center bg-white shadow-inner">
                                @error('table_number')
                                    <p class="text-error text-[10px] font-black mt-1 px-1 uppercase tracking-wider">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block font-black text-on-surface-variant text-[10px] uppercase tracking-widest mb-2 ml-1">Nama (Opsional)</label>
                                <input type="text" name="customer_name" placeholder="Biar akrab..." 
                                       class="w-full px-5 py-3.5 rounded-xl border-2 border-surface-container focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-sm bg-white">
                            </div>

                            <div class="space-y-1">
                                <label class="block font-black text-on-surface-variant text-[10px] uppercase tracking-widest mb-2 ml-1">Catatan</label>
                                <textarea name="notes" placeholder="Misal: Gak pake bawang..." rows="2"
                                          class="w-full px-5 py-3.5 rounded-xl border-2 border-surface-container focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all font-bold text-sm bg-white resize-none"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-primary text-white font-heading font-black text-xl py-5 rounded-full shadow-xl shadow-primary/30 hover:scale-[1.02] active:scale-95 transition-all duration-300 mt-2">
                                Order Now! 🧁
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
