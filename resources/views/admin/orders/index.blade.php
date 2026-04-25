@extends('layouts.admin')
@section('title', 'Kelola Pesanan (Real-time)')

@section('content')
    <div class="mb-8 flex justify-between items-end bg-white p-6 rounded-3xl shadow-sm border border-border">
        <div>
            <h3 class="font-heading font-black text-3xl text-primary flex items-center gap-3">
                Antrean Dapur 👨‍🍳
            </h3>
            <p class="text-text-secondary font-medium mt-1">Halaman ini diperbarui otomatis setiap 5 detik.</p>
        </div>
        <div class="flex items-center gap-3 text-sm font-bold text-primary bg-primary-light px-4 py-2 rounded-xl border border-primary/20">
            <span class="w-3 h-3 rounded-full bg-primary animate-pulse"></span> Live Polling
        </div>
    </div>

    <div x-data="orderPolling()" x-init="startPolling()" class="w-full">
        <div x-ref="orderList" class="w-full">
            @include('admin.orders.partials.list', ['orders' => $orders])
        </div>
    </div>

    <script>
        function orderPolling() {
            return {
                startPolling() {
                    setInterval(() => {
                        fetch('{{ route('admin.orders.index') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            this.$refs.orderList.innerHTML = html;
                        });
                    }, 5000);
                }
            }
        }
    </script>
@endsection
