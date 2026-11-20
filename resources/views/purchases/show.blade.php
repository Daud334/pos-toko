<x-app-layout>
    <x-slot name="header">Detail Pembelian Stok</x-slot>

    <div class="card">
        <h3>{{ $purchase->po_number }}</h3>
        <p style="color:#6b7280">
            {{ $purchase->purchased_at->format('d M Y') }} &middot; Supplier: {{ $purchase->supplier->name }}
            &middot; Dicatat oleh: {{ $purchase->user->name }}
        </p>
        @if ($purchase->note)
            <p>Catatan: {{ $purchase->note }}</p>
        @endif

        <table>
            <thead><tr><th>Produk</th><th>Qty</th><th>Harga Beli</th><th>Subtotal</th></tr></thead>
            <tbody>
            @foreach ($purchase->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp{{ number_format($item->cost_price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p style="margin-top:12px"><b>Total: Rp{{ number_format($purchase->total, 0, ',', '.') }}</b></p>
        <a href="{{ route('purchases.index') }}">&larr; Kembali ke daftar</a>
    </div>
</x-app-layout>