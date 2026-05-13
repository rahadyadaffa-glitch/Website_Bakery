@extends('layouts.admin')
@section('title', 'Manajemen QR Meja')

@section('content')
    <!-- Status Meja Grid -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-heading font-black text-2xl text-primary">Klik Meja untuk Lihat QR Code</h3>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($tables as $table)
                <a href="{{ route('admin.tables.show_qr', $table->id) }}" class="relative group">
                    <div class="aspect-square rounded-3xl border-2 border-border bg-white flex flex-col items-center justify-center p-4 transition-all duration-300 shadow-sm group-hover:border-primary group-hover:shadow-md group-hover:scale-105">
                        <span class="text-4xl mb-2">🖼️</span>
                        <span class="font-heading font-black text-3xl text-primary">{{ $table->number }}</span>
                        <div class="mt-4 px-4 py-1 bg-primary/10 rounded-full text-[10px] font-bold text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                            Get QR Code
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <hr class="my-12 border-border">

    <!-- Form Generator -->
    <div class="max-w-2xl">
        <div class="bg-white p-8 rounded-[40px] border border-border shadow-sm">
            <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-inner">
                🖨️
            </div>
            <h3 class="font-heading font-black text-2xl text-primary mb-2">Generate QR Manual</h3>
            <p class="text-text-secondary text-sm font-medium mb-8">Gunakan ini jika ingin membuat QR untuk label khusus atau area di luar meja standar.</p>
            
            <form action="{{ route('admin.tables.qr') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block font-bold text-text-primary text-base">ID / Nomor Meja <span class="text-danger">*</span></label>
                    <input type="text" name="table_number" required placeholder="Contoh: Meja-VVIP" 
                           class="w-full px-5 py-4 rounded-2xl border-2 border-border focus:border-primary focus:ring-2 focus:ring-primary/20 transition font-heading font-bold text-xl text-primary text-center">
                </div>
                
                <button type="submit" class="w-full bg-accent text-primary font-heading font-black text-xl py-4 rounded-2xl hover:bg-accent-dark hover:scale-[1.02] active:scale-95 transition-all shadow-md">
                    Generate QR Code ✨
                </button>
            </form>
        </div>
    </div>
@endsection
