<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - Meja {{ $tableNumber }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Plus+Jakarta+Sans:wght@400;700&family=Courier+Prime&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier Prime', monospace;
            width: 80mm;
            padding: 5mm;
            margin: 0 auto;
            color: #000;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 5mm;
            margin-bottom: 5mm;
        }
        .logo {
            font-family: 'Caveat', cursive;
            font-size: 32px;
            font-weight: 900;
        }
        .info {
            font-size: 14px;
            margin-bottom: 5mm;
        }
        .info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }
        .items {
            border-bottom: 2px dashed #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2mm;
            font-weight: bold;
            font-size: 16px;
        }
        .total {
            text-align: right;
            font-size: 20px;
            font-weight: 900;
            margin-top: 3mm;
        }
        .footer {
            text-align: center;
            margin-top: 8mm;
            font-family: 'Caveat', cursive;
            font-size: 18px;
        }
        .no-print {
            display: block;
            text-align: center;
            margin-bottom: 10mm;
            background: #8e4e14;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: bold;
            border-radius: 8px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <a href="#" onclick="window.close()" class="no-print">Tutup Halaman Ini</a>

    <div class="header">
        <div class="logo">SweetBite</div>
        <div style="font-size: 12px; margin-top: 2mm;">Bakery & Restaurant Artisanal</div>
    </div>

    <div class="info">
        <div>
            <span>Meja:</span>
            <span style="font-weight: 900; font-size: 18px;">#{{ $tableNumber }}</span>
        </div>
        <div>
            <span>Waktu:</span>
            <span>{{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div>
            <span>Pelanggan:</span>
            <span>{{ $items->first()->order->customer_name }}</span>
        </div>
    </div>

    <div class="items">
        @foreach($items as $item)
            <div class="item">
                <span>{{ $item->menu_name }}</span>
                <span>x{{ $item->quantity }}</span>
            </div>
            @if($item->notes)
                <div style="font-size: 12px; font-style: italic; margin-top: -1mm; margin-bottom: 2mm;">
                    * {{ $item->notes }}
                </div>
            @endif
            <div style="text-align: right; font-size: 13px; margin-bottom: 3mm;">
                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
            </div>
        @endforeach
    </div>

    <div class="total">
        <span style="font-size: 14px; font-weight: normal;">Total Siap Antar:</span>
        Rp {{ number_format($items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
    </div>

    <div class="footer">
        Terima kasih sudah jajan!<br>
        Selamat Menikmati ✨
    </div>

    <script>
        // Auto-close after printing (optional)
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>
</html>
