@extends('layouts.admin')
@section('title', 'Monitor Jajan')

@section('content')
    <div x-data="orderPolling()" x-init="startPolling()" class="w-full">
        <!-- 1. Real-time Pesanan Masuk (Artisanal Style) -->
        <div class="mb-12 bg-white p-10 wobbly-border-extreme shadow-[10px_10px_0px_0px_rgba(142,78,20,0.2)] overflow-hidden relative">
            <!-- Watercolor texture -->
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#f4a261] rounded-full opacity-10 blur-3xl -z-10"></div>
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 relative z-10 gap-6">
                <div>
                    <h3 class="hand-drawn font-black text-5xl text-[#8e4e14] flex items-center gap-4">
                        <span class="w-16 h-16 bg-[#f4a261] text-white wobbly-border-thin flex items-center justify-center shadow-[4px_4px_0px_0px_#8e4e14] text-3xl">🛎️</span>
                        Pesanan Masuk
                    </h3>
                    <p class="hand-drawn text-2xl text-[#534439] mt-2 ml-1">Cek menu baru yang barusan dipesan pelanggan!</p>
                </div>
                <div class="flex items-center gap-3 text-xs font-black text-[#8e4e14] bg-[#f4a261]/10 px-6 py-3 wobbly-border-thin">
                    <span class="w-3 h-3 rounded-full bg-[#8e4e14] animate-ping"></span> LIVE MONITORING
                </div>
            </div>

            <div x-ref="incomingList" class="space-y-6">
                @include('admin.orders.partials.incoming_list', ['incomingItems' => $incomingItems])
            </div>
        </div>

        <div class="flex items-center gap-10 my-20">
            <div class="flex-1 h-2 bg-[#8e4e14] wobbly-border-thin opacity-20"></div>
            <div class="bg-[#8e4e14] text-white px-10 py-3 wobbly-border transform -rotate-1 shadow-[4px_4px_0_#000]">
                <span class="hand-drawn text-4xl font-black uppercase tracking-widest">Monitor Status Meja</span>
            </div>
            <div class="flex-1 h-2 bg-[#8e4e14] wobbly-border-thin opacity-20"></div>
        </div>

        <!-- 2. Grid Meja (High Contrast) -->
        <div class="mb-20">
            <div x-ref="tableGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                @include('admin.orders.partials.table_grid', ['tables' => $tables, 'tableStats' => $tableStats])
            </div>
        </div>
    </div>

    <!-- Audio for Notification (Looping) -->
    <audio id="notif-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto" loop></audio>

    <script>
        function orderPolling() {
            return {
                lastIncomingCount: {{ $incomingItems->count() }},
                startPolling() {
                    setInterval(() => {
                        fetch('{{ route('admin.orders.index') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const sound = document.getElementById('notif-sound');
                            
                            // Play sound if there are pending orders
                            if (data.pending_count > 0) {
                                sound.play().catch(e => console.log('Audio play blocked by browser. Please interact with the page first.'));
                            } else {
                                sound.pause();
                                sound.currentTime = 0; // Reset to start
                            }
                            
                            this.lastIncomingCount = data.pending_count;
                            this.$refs.incomingList.innerHTML = data.incoming_list;
                            this.$refs.tableGrid.innerHTML = data.table_grid;
                        });
                    }, 5000);
                }
            }
        }
    </script>
@endsection
