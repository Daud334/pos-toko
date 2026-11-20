<x-app-layout>
    <x-slot name="header">Riwayat Pembelian Stok</x-slot>

    <style>
        .btn-add{display:inline-block;background:#4f46e5;color:#fff;padding:9px 16px;border-radius:8px;text-decoration:none;margin-bottom:16px}
    </style>

    <div class="card">
        <a href="{{ route('purchases.create') }}" class="btn-add">+ Pembelian Baru</a>

        <table>
            <thead><tr><th>No. PO</th><th>Tanggal</th><th>Supplier</th><th>Item</th><th>Total</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($purchases as $p)
                <tr>
                    <td>{{ $p->po_number }}</td>
                    <td>{{ $p->purchased_at->format('d M Y') }}</td>
                    <td>{{ $p->supplier->name }}</td>
                    <td>{{ $p->items_count }}</td>
                    <td>Rp{{ number_format($p->total, 0, ',', '.') }}</td>
                    <td><a href="{{ route('purchases.show', $p) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada pembelian stok.</td></tr>
            @endforelse
            </tbody>
        </table>

        {{ $purchases->links('pagination.simple') }}
    </div>
</x-app-layout>