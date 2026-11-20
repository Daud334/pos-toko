<x-app-layout>
    <x-slot name="header">Struk Transaksi</x-slot>

    <style>
        .struk-row{display:flex;justify-content:space-between;font-size:14px;margin-bottom:4px}
        .struk-btn{display:block;width:100%;text-align:center;margin-top:10px;padding:10px;border-radius:8px;border:0;cursor:pointer;font-size:14px;text-decoration:none;box-sizing:border-box}
        .btn-print{background:#059669;color:#fff}
        .btn-new{background:#4f46e5;color:#fff}
        @media print {
            @page { size: 58mm auto; margin: 2mm; }
            body * { visibility: hidden; }
            #struk, #struk * { visibility: visible; }
            #struk {
                position: absolute; left: 0; top: 0;
                width: 54mm !important; max-width: 54mm !important; margin: 0 !important;
                padding: 0 !important; border: 0; box-shadow: none;
                font-family: 'Courier New', monospace; font-size: 10px; color: #000;
            }
            #struk .struk-row { font-size: 10px; }
            #struk hr { border: 0; border-top: 1px dashed #000; }
            .no-print { display: none !important; }
        }
    </style>

    <div class="card" id="struk" style="max-width:420px;margin:0 auto">
        <p style="text-align:center;font-weight:600;margin:0">POS Barokah Mart</p>
        <p style="text-align:center;color:#6b7280;font-size:12px;margin:2px 0 10px">{{ $transaction->invoice_number }}</p>
        <p style="color:#6b7280;font-size:12px">
            {{ $transaction->created_at->format('d M Y H:i') }} &middot; Kasir: {{ $transaction->user->name }}
        </p>
        <hr>
        @foreach ($transaction->details as $detail)
            <div class="struk-row">
                <span>{{ $detail->product->name }} x{{ $detail->qty }}</span>
                <span>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
        <hr>
        <div class="struk-row"><b>Total</b><b>Rp{{ number_format($transaction->total, 0, ',', '.') }}</b></div>
        <div class="struk-row"><span>Bayar</span><span>Rp{{ number_format($transaction->pay, 0, ',', '.') }}</span></div>
        <div class="struk-row"><span>Kembali</span><span>Rp{{ number_format($transaction->change, 0, ',', '.') }}</span></div>
        <p style="text-align:center;font-size:12px;margin-top:10px">Terima kasih</p>

        <button type="button" class="struk-btn btn-print no-print" onclick="window.print()">Cetak Struk</button>
        <a href="{{ route('pos.index') }}" class="struk-btn btn-new no-print">Transaksi Baru</a>
    </div>
</x-app-layout>