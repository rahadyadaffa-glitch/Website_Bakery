<!-- Item Details Modal (Bubbly Gen Z Style) -->
<div x-cloak
     x-show="itemModalOpen" 
     class="fixed inset-0 z-[110] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="itemModalOpen" 
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" 
         @click="itemModalOpen = false"></div>

    <div class="flex min-h-full items-end sm:items-center justify-center p-4 text-center">
        <div x-show="itemModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-10 scale-95" 
             class="relative transform overflow-hidden rounded-[3rem] bg-white text-left shadow-[12px_12px_0px_0px_#427AB5] transition-all w-full sm:max-w-lg border-4 border-primary">
            
            <!-- Close Button -->
            <button @click="itemModalOpen = false" class="absolute top-4 right-4 z-30 p-3 bg-white border-4 border-primary rounded-2xl text-primary hover:bg-accent transition-all shadow-[4px_4px_0px_0px_#427AB5]">
                <span class="material-symbols-outlined font-black">close</span>
            </button>

            <!-- Image Section -->
            <div class="h-64 relative overflow-hidden bg-primary-light/20 border-b-4 border-primary">
                <template x-if="selectedItem.image">
                    <img :src="selectedItem.image_url" class="w-full h-full object-cover">
                </template>
                <template x-if="!selectedItem.image">
                    <div class="w-full h-full flex items-center justify-center text-8xl opacity-20">🍰</div>
                </template>
            </div>

            <div class="px-8 py-8">
                <div class="mb-8">
                    <div class="flex flex-col gap-1 mb-4">
                        <h3 class="font-heading font-black text-4xl text-primary leading-tight" x-text="selectedItem.name"></h3>
                        <div class="bg-accent-light border-2 border-accent text-primary px-4 py-1 rounded-xl w-max font-black text-xl">
                            Rp <span x-text="Number(selectedItem.price).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <p class="text-text-secondary font-bold text-sm leading-relaxed" x-text="selectedItem.description"></p>
                </div>

                <div class="space-y-8">
                    <!-- Notes -->
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 font-black text-primary text-xs uppercase tracking-widest ml-1">
                            <span class="material-symbols-outlined text-sm">edit_note</span> Ada catatan khusus?
                        </label>
                        <textarea x-model="selectedItem.notes" 
                                  placeholder="Contoh: Gak pake es, topping dobel ya! 🚀" 
                                  rows="2"
                                  class="w-full px-6 py-4 rounded-[1.5rem] border-4 border-border focus:border-primary focus:ring-0 transition-all font-bold text-sm bg-background resize-none placeholder:opacity-50"></textarea>
                    </div>

                    <!-- Quantity Control -->
                    <div class="flex items-center justify-between bg-bg-secondary p-4 rounded-[2rem] border-4 border-border">
                        <span class="font-black text-primary text-sm uppercase tracking-widest ml-2">Jumlah</span>
                        <div class="flex items-center bg-white rounded-2xl p-1 border-4 border-primary shadow-[4px_4px_0px_0px_#427AB5]">
                            <button @click="if(selectedItem.qty > 1) selectedItem.qty--" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-danger/10 hover:text-danger font-black transition-colors text-2xl">-</button>
                            <span class="w-14 text-center font-heading font-black text-primary text-2xl" x-text="selectedItem.qty"></span>
                            <button @click="selectedItem.qty++" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-success/10 hover:text-success font-black transition-colors text-2xl">+</button>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button @click="addToCartWithDetails()" 
                            class="w-full bg-primary text-white font-heading font-black text-2xl py-6 rounded-full shadow-[8px_8px_0px_0px_rgba(66,122,181,0.3)] hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-3 border-4 border-white/20">
                        Masukin Keranjang! ✨
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
