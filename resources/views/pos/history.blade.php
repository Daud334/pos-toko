<x-app-layout>
    <x-slot name="header">Riwayat Transaksi Saya</x-slot>

    <div class="card">
        <table>
            <thead>
                <tr><th>No. Invoice</th><th>Tanggal</th><th>Item</th><th>Total</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ $trx->invoice_number }}</td>
                    <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $trx->details_count }}</td>
                    <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td><a href="{{ route('pos.struk', $trx) }}">Struk</a></td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada transaksi.</td></tr>
            @endforelse
            </tbody>
        </table>

        {{ $transactions->links('pagination.simple') }}
    </div>
</x-app-layout>