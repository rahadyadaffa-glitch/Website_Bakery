@extends('layouts.admin')
@section('title', 'QR Code Meja')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <!-- Form Generator -->
        <div class="bg-white p-8 rounded-[40px] border border-border shadow-sm">
            <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-inner">
                🖨️
            </div>
            <h3 class="font-heading font-black text-2xl text-primary mb-2">Generate QR Code Meja</h3>
            <p class="text-text-secondary text-sm font-medium mb-8">Buat QR Code unik untuk setiap meja. Customer tinggal scan QR Code ini untuk langsung membuka menu tanpa antre!</p>
            
            <form action="{{ route('admin.tables.qr') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block font-bold text-text-primary text-base">Nomor Meja <span class="text-danger">*</span></label>
                    <input type="text" name="table_number" required placeholder="Contoh: 12, VIP-1, Outdoor-A" 
                           class="w-full px-5 py-4 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-heading font-bold text-xl text-primary text-center">
                </div>
                
                <button type="submit" class="w-full bg-accent text-primary font-heading font-black text-xl py-4 rounded-2xl hover:bg-accent-dark hover:scale-[1.02] active:scale-95 transition-all shadow-md">
                    Generate QR Code ✨
                </button>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-primary-light/30 p-8 rounded-[40px] border-2 border-primary border-dashed">
            <h4 class="font-heading font-bold text-xl text-primary mb-4">Cara Kerja QR Code</h4>
            <ul class="space-y-4">
                <li class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center shrink-0">1</div>
                    <p class="text-text-primary text-sm font-medium pt-1">Masukkan identitas meja (misal: "Meja 1").</p>
                </li>
                <li class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center shrink-0">2</div>
                    <p class="text-text-primary text-sm font-medium pt-1">Sistem akan men-generate gambar QR Code.</p>
                </li>
                <li class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-primary text-white font-bold flex items-center justify-center shrink-0">3</div>
                    <p class="text-text-primary text-sm font-medium pt-1">Cetak gambar tersebut dan tempel di meja. Customer tinggal scan untuk otomatis masuk ke sistem pesanan meja tersebut.</p>
                </li>
            </ul>
        </div>
    </div>
@endsection
