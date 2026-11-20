<x-app-layout>
    <x-slot name="header">Detail Produk</x-slot>

    <style>
        .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin:16px 0 24px}
        .stats div{background:#f9fafb;border-radius:8px;padding:14px;text-align:center}
        .stats small{display:block;color:#6b7280;font-size:12px}
        .stats b{font-size:18px}
        .muted{color:#6b7280;margin:0}
    </style>

    <div class="card">
        <h3>{{ $product->name }}</h3>
        <p class="muted">{{ $product->code }} &middot; {{ $product->category->name }}</p>

        <div class="stats">
            <div><small>Harga</small><b>{{ $product->priceRupiah }}</b></div>
            <div><small>Stok Saat Ini</small><b>{{ $product->stock }} {{ $product->unit }}</b></div>
            <div><small>Total Terjual</small><b>{{ $totalTerjual }} {{ $product->unit }}</b></div>
        </div>

        <h4>Riwayat Penjualan Terakhir</h4>
        <table>
            <thead><tr><th>No. Invoice</th><th>Tanggal</th><th>Qty</th><th>Subtotal</th></tr></thead>
            <tbody>
            @forelse ($riwayat as $item)
                <tr>
                    <td>{{ $item->transaction->invoice_number }}</td>
                    <td>{{ $item->transaction->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum pernah terjual.</td></tr>
            @endforelse
            </tbody>
        </table>

        <h4 style="margin-top:24px">5 Hari dengan Penjualan Tertinggi</h4>
        <table>
            <thead><tr><th>Peringkat</th><th>Tanggal</th><th>Qty</th><th>Omzet</th></tr></thead>
            <tbody>
            @forelse ($hariTerbaik as $i => $h)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->tanggal)->format('d M Y') }}</td>
                    <td>{{ $h->total_qty }}</td>
                    <td>Rp{{ number_format($h->total_omzet, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada data penjualan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>