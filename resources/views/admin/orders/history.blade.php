@extends('layouts.admin')
@section('title', 'Riwayat Jajan Selesai')

@section('content')
    <div class="mb-10 bg-white p-8 wobbly-border-extreme shadow-[6px_6px_0_rgba(142,78,20,0.1)] space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h3 class="hand-drawn font-black text-5xl text-[#8e4e14] flex items-center gap-4 transform -rotate-1">
                    Riwayat Jajan ✅
                </h3>
                <p class="hand-drawn text-2xl text-[#534439] mt-2 opacity-70">Semua pesanan yang sudah sukses tersaji.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="bg-white wobbly-border-thin text-[#8e4e14] font-heading font-black px-6 py-3 hover:bg-[#8e4e14] hover:text-white transition-all text-sm shadow-[3px_3px_0_#8e4e14] transform rotate-1">
                ← Antrean Monitor
            </a>
        </div>

        <!-- Artisanal Filter Bar -->
        <form method="GET" class="flex flex-wrap items-center gap-4 pt-6 border-t-2 border-dashed border-[#d8c2b5]">
            <!-- Quick Date Buttons -->
            <div class="flex items-center gap-3">
                @php
                    $dates = [
                        ['label' => 'Hari Ini', 'val' => now()->toDateString()],
                        ['label' => 'Kemarin', 'val' => now()->subDay()->toDateString()],
                        ['label' => 'Semua', 'val' => ''],
                    ];
                @endphp
                @foreach($dates as $d)
                    <a href="{{ route('admin.orders.history', array_merge(request()->query(), ['date' => $d['val']])) }}" 
                       class="px-5 py-2 wobbly-border-thin text-sm font-black transition-all transform {{ ($selectedDate ?? '') === $d['val'] ? 'bg-[#8e4e14] text-white rotate-2 shadow-[2px_2px_0_#000]' : 'bg-white text-[#534439] hover:bg-[#f5edde] -rotate-1' }}">
                        {{ $d['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Date Picker -->
            <input type="date" name="date" value="{{ $selectedDate ?? '' }}" 
                   onchange="this.form.submit()"
                   class="px-4 py-2 wobbly-border-thin focus:border-[#8e4e14] focus:ring-0 transition font-black text-sm bg-white">

            <!-- Search -->
            <div class="flex gap-2 ml-auto flex-1 md:flex-none">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari order/nama/meja..." 
                       class="px-6 py-2 wobbly-border-thin focus:border-[#8e4e14] focus:ring-0 transition font-black text-sm w-full md:w-64 bg-white">
                <button type="submit" class="bg-[#8e4e14] text-white font-heading font-black px-6 py-2 wobbly-border-thin hover:scale-105 transition shadow-[2px_2px_0_#000]">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white wobbly-border overflow-hidden shadow-[8px_8px_0_rgba(142,78,20,0.1)]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f5edde] text-[#8e4e14] font-black border-b-2 border-[#8e4e14]">
                        <th class="p-6 hand-drawn text-2xl">Order #</th>
                        <th class="p-6 hand-drawn text-2xl">Meja</th>
                        <th class="p-6 hand-drawn text-2xl">Nama</th>
                        <th class="p-6 hand-drawn text-2xl">Item Pesanan</th>
                        <th class="p-6 hand-drawn text-2xl">Total</th>
                        <th class="p-6 hand-drawn text-2xl">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-dashed divide-[#d8c2b5]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#fff8ef] transition-colors group">
                            <td class="p-6">
                                <span class="font-heading font-black text-[#8e4e14] text-sm bg-[#f5edde] px-2 py-1 wobbly-border-thin transform -rotate-1 inline-block">{{ $order->order_number }}</span>
                            </td>
                            <td class="p-6">
                                <span class="bg-[#f4a261] text-white font-black text-sm px-4 py-2 wobbly-border-thin transform rotate-2 inline-block">
                                    Meja {{ $order->table_number }}
                                </span>
                            </td>
                            <td class="p-6">
                                <span class="hand-drawn text-2xl text-[#1e1b13] font-bold">{{ $order->customer_name ?: '-' }}</span>
                            </td>
                            <td class="p-6">
                                <div class="space-y-2 max-w-xs">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between text-sm font-bold text-[#534439]">
                                            <span>{{ $item->qty }}x {{ $item->menu_name }}</span>
                                            <span class="text-[#8e4e14]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="font-heading font-black text-[#8e4e14] text-xl">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                            <td class="p-6">
                                <div class="text-xs text-[#534439] font-bold">
                                    <div class="hand-drawn text-xl">{{ $order->updated_at->format('d M Y') }}</div>
                                    <div class="opacity-50 uppercase tracking-widest">{{ $order->updated_at->format('H:i') }} WIB</div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center opacity-30">
                                <span class="material-symbols-outlined text-8xl mb-4">history_off</span>
                                <h4 class="hand-drawn text-4xl">Belum ada pesanan yang selesai hari ini.</h4>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($orders->hasPages())
        <div class="mt-12 flex justify-center artisanal-pagination">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
