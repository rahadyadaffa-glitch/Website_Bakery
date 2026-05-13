<!-- Item Details Modal (Artisanal Hand-Drawn Style) -->
<div x-cloak
     x-show="itemModalOpen" 
     class="fixed inset-0 z-[110] overflow-y-auto" 
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="itemModalOpen" 
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-[#8e4e14]/40 backdrop-blur-sm transition-opacity" 
         @click="itemModalOpen = false"></div>

    <div class="flex min-h-full items-end sm:items-center justify-center p-4 text-center">
        <div x-show="itemModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-10 scale-95" 
             class="relative transform overflow-hidden bg-white text-left shadow-[12px_12px_0px_0px_rgba(142,78,20,0.3)] transition-all w-full sm:max-w-lg wobbly-border-extreme">
            
            <!-- Close Button -->
            <button @click="itemModalOpen = false" class="absolute top-4 right-4 z-30 w-12 h-12 bg-white wobbly-border-thin text-[#8e4e14] hover:bg-[#8e4e14] hover:text-white transition-all shadow-[3px_3px_0_#8e4e14] flex items-center justify-center">
                <span class="material-symbols-outlined font-black">close</span>
            </button>

            <!-- Image Section -->
            <div class="h-64 relative overflow-hidden bg-[#f5edde] border-b-2 border-dashed border-[#8e4e14]">
                <template x-if="selectedItem.image">
                    <img :src="selectedItem.image_url" class="w-full h-full object-cover">
                </template>
                <template x-if="!selectedItem.image">
                    <div class="w-full h-full flex items-center justify-center text-8xl opacity-20">🍰</div>
                </template>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>

            <div class="px-8 py-8 relative">
                <!-- Decorative doodle -->
                <span class="material-symbols-outlined absolute top-4 right-8 text-[#8e4e14]/10 text-6xl pointer-events-none">bakery_dining</span>

                <div class="mb-8 relative z-10">
                    <div class="flex flex-col gap-2 mb-4">
                        <h3 class="hand-drawn font-black text-5xl text-[#8e4e14] leading-tight" x-text="selectedItem.name"></h3>
                        <div class="bg-[#f4a261]/20 border-2 border-[#f4a261] text-[#8e4e14] px-5 py-2 wobbly-border-thin w-max font-black text-2xl transform -rotate-1">
                            Rp <span x-text="Number(selectedItem.price).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <p class="text-[#534439] font-bold text-base leading-relaxed hand-drawn text-2xl" x-text="selectedItem.description"></p>
                </div>

                <div class="space-y-8 relative z-10">
                    <!-- Notes -->
                    <div class="space-y-3">
                        <label class="flex items-center gap-2 font-black text-[#8e4e14] text-xs uppercase tracking-widest ml-1">
                            <span class="material-symbols-outlined text-sm">edit_note</span> Catatan Khusus
                        </label>
                        <textarea x-model="selectedItem.notes" 
                                  placeholder="Gak pake es, topping dobel ya! 🚀" 
                                  rows="2"
                                  class="w-full px-6 py-4 rounded-xl border-2 border-[#d8c2b5] focus:border-[#8e4e14] focus:ring-0 transition-all font-bold text-lg bg-[#fff8ef] resize-none placeholder:opacity-30 wobbly-border-thin"></textarea>
                    </div>

                    <!-- Quantity Control -->
                    <div class="flex items-center justify-between p-4 bg-[#fbf3e4] wobbly-border-thin">
                        <span class="font-black text-[#8e4e14] text-xs uppercase tracking-widest ml-2">Jumlah</span>
                        <div class="flex items-center bg-white rounded-xl p-1 wobbly-border-thin shadow-[3px_3px_0px_0px_rgba(142,78,20,0.1)]">
                            <button @click="if(selectedItem.qty > 1) selectedItem.qty--" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-500 font-black transition-colors text-2xl">-</button>
                            <span class="w-14 text-center font-heading font-black text-[#8e4e14] text-2xl" x-text="selectedItem.qty"></span>
                            <button @click="selectedItem.qty++" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-green-50 text-green-500 font-black transition-colors text-2xl">+</button>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button @click="addToCartWithDetails()" 
                            class="w-full bg-[#8e4e14] text-white font-heading font-black text-2xl py-6 wobbly-border shadow-[6px_6px_0px_0px_rgba(142,78,20,0.2)] hover:scale-[1.03] active:scale-95 transition-all duration-300 flex items-center justify-center gap-3">
                        Bungkus Sekarang! ✨
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
