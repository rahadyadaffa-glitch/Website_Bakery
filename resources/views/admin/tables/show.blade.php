@extends('layouts.admin')
@section('title', 'QR Code Meja: ' . $tableNumber)

@section('content')
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.tables.index') }}" class="w-10 h-10 bg-white border border-border rounded-full flex items-center justify-center text-primary shadow-sm hover:bg-bg-secondary transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h3 class="font-heading font-black text-2xl text-primary">Hasil Generate QR</h3>
    </div>

    <div class="bg-white p-12 rounded-[40px] border border-border shadow-xl text-center max-w-xl mx-auto mt-8 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary-light rounded-full opacity-50 blur-xl"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-accent-light rounded-full opacity-50 blur-xl"></div>

        <div class="relative z-10">
            <h2 class="font-heading font-black text-4xl text-primary mb-2">Meja {{ $tableNumber }}</h2>
            <p class="text-text-secondary font-medium mb-8">Scan QR ini untuk memesan secara langsung!</p>

            <div class="inline-block p-4 bg-white border-4 border-primary rounded-3xl shadow-lg mb-8">
                {!! $qr !!}
            </div>

            <div class="bg-bg-secondary p-4 rounded-2xl border border-border mb-8 text-left break-all">
                <p class="text-xs font-bold text-text-muted uppercase tracking-wide mb-1">Direct URL (Testing)</p>
                <a href="{{ $url }}" target="_blank" class="text-primary font-medium hover:underline flex items-center gap-2">
                    {{ $url }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>

            <div class="flex gap-4 justify-center">
                <button onclick="window.print()" class="bg-primary text-white font-bold py-3 px-8 rounded-2xl hover:bg-primary-dark transition-all shadow-md flex items-center gap-2">
                    <span>🖨️</span> Print QR
                </button>
                <a href="{{ route('admin.tables.index') }}" class="bg-bg-secondary text-text-primary border border-border font-bold py-3 px-8 rounded-2xl hover:bg-border transition-all shadow-sm">
                    Buat Lagi
                </a>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-white.p-12, .bg-white.p-12 * {
                visibility: visible;
            }
            .bg-white.p-12 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
            button, a {
                display: none !important;
            }
        }
    </style>
@endsection
