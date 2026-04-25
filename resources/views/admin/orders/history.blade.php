@extends('layouts.admin')
@section('title', 'Riwayat Pesanan Selesai')

@section('content')
    <div class="mb-8 bg-white p-6 rounded-3xl shadow-sm border border-border space-y-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h3 class="font-heading font-black text-3xl text-primary flex items-center gap-3">
                    Riwayat Pesanan ✅
                </h3>
                <p class="text-text-secondary font-medium mt-1">Semua pesanan yang sudah selesai.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="bg-primary-light text-primary font-bold px-4 py-2 rounded-xl border border-primary/20 hover:bg-primary hover:text-white transition-all text-sm">
                ← Antrean Dapur
            </a>
        </div>

        <!-- Filter Bar -->
        <form method="GET" class="flex flex-wrap items-center gap-3 pt-4 border-t border-border">
            <!-- Quick Date Buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.history', ['date' => now()->toDateString(), 'search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all border {{ ($selectedDate ?? '') === now()->toDateString() ? 'bg-primary text-white border-primary' : 'bg-white text-text-secondary border-border hover:bg-primary-light hover:text-primary hover:border-primary/20' }}">
                    Hari Ini
                </a>
                <a href="{{ route('admin.orders.history', ['date' => now()->subDay()->toDateString(), 'search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all border {{ ($selectedDate ?? '') === now()->subDay()->toDateString() ? 'bg-primary text-white border-primary' : 'bg-white text-text-secondary border-border hover:bg-primary-light hover:text-primary hover:border-primary/20' }}">
                    Kemarin
                </a>
                <a href="{{ route('admin.orders.history', ['search' => request('search')]) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition-all border {{ empty($selectedDate ?? '') ? 'bg-primary text-white border-primary' : 'bg-white text-text-secondary border-border hover:bg-primary-light hover:text-primary hover:border-primary/20' }}">
                    Semua
                </a>
            </div>

            <!-- Date Picker -->
            <input type="date" name="date" value="{{ $selectedDate ?? '' }}" 
                   onchange="this.form.submit()"
                   class="px-4 py-2 rounded-xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium text-sm">

            <!-- Search -->
            <div class="flex gap-2 ml-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari order/nama/meja..." 
                       class="px-4 py-2 rounded-xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-medium text-sm w-56">
                <button type="submit" class="bg-primary text-white font-bold px-4 py-2 rounded-xl hover:bg-primary-dark transition text-sm">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-border overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-bg-secondary text-text-primary font-bold border-b border-border">
                    <th class="p-5">Order #</th>
                    <th class="p-5">Meja</th>
                    <th class="p-5">Nama</th>
                    <th class="p-5">Item Pesanan</th>
                    <th class="p-5">Total</th>
                    <th class="p-5">Catatan</th>
                    <th class="p-5">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($orders as $order)
                    <tr class="hover:bg-bg-secondary/50 transition-colors">
                        <td class="p-5">
                            <span class="font-heading font-black text-primary text-sm">{{ $order->order_number }}</span>
                        </td>
                        <td class="p-5">
                            <span class="bg-accent text-primary font-black text-sm px-3 py-1.5 rounded-xl border border-accent-dark/20">
                                Meja {{ $order->table_number }}
                            </span>
                        </td>
                        <td class="p-5">
                            <span class="font-bold text-text-primary text-sm">{{ $order->customer_name ?: '-' }}</span>
                        </td>
                        <td class="p-5">
                            <div class="space-y-1 max-w-xs">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-text-secondary">{{ $item->qty }}x {{ $item->menu_name }}</span>
                                        <span class="font-bold text-text-primary ml-4">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="font-heading font-black text-primary text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="p-5">
                            @if($order->notes)
                                <div class="bg-accent-light text-text-primary text-xs font-medium px-3 py-2 rounded-xl max-w-[200px] border border-accent/30">
                                    📝 {{ $order->notes }}
                                </div>
                            @else
                                <span class="text-text-muted text-xs">—</span>
                            @endif
                        </td>
                        <td class="p-5">
                            <div class="text-xs text-text-secondary font-medium">
                                <div>{{ $order->updated_at->format('d M Y') }}</div>
                                <div class="text-text-muted">{{ $order->updated_at->format('H:i') }} WIB</div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center">
                            <div class="text-6xl mb-4 opacity-20">📋</div>
                            <p class="text-text-muted font-bold">Belum ada pesanan selesai.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
