<x-app-layout>
    <x-slot name="header">Laporan Penjualan</x-slot>

    <style>
        .filter{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;margin-bottom:18px}
        .filter label{display:block;font-size:13px;color:#374151;margin-bottom:4px}
        .filter input,.filter select{padding:8px;border:1px solid #d1d5db;border-radius:8px}
        .btn-show{background:#4f46e5;color:#fff;border:0;padding:9px 16px;border-radius:8px;cursor:pointer}
        .btn-xls{background:#059669;color:#fff;padding:9px 16px;border-radius:8px;text-decoration:none}
        .sum{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px}
        .sum div{background:#f9fafb;border-radius:8px;padding:14px}
        .sum small{display:block;color:#6b7280;font-size:12px}
        .sum b{font-size:20px}
    </style>

    <div class="card">
        <form method="GET" class="filter">
            <div><label>Dari Tanggal</label>
                <input type="date" name="start" value="{{ $start->format('Y-m-d') }}"></div>
            <div><label>Sampai Tanggal</label>
                <input type="date" name="end" value="{{ $end->format('Y-m-d') }}"></div>
            <div><label>Kasir</label>
                <select name="kasir_id">
                    <option value="">Semua Kasir</option>
                    @foreach ($kasirs as $k)
                        <option value="{{ $k->id }}" @selected(request('kasir_id') == $k->id)>{{ $k->name }}</option>
                    @endforeach
                </select></div>
            <button type="submit" class="btn-show">Tampilkan</button>
            <a href="{{ route('report.export', request()->query()) }}" class="btn-xls">Export Excel</a>
        </form>

        <div class="sum">
            <div><small>Total Penjualan</small><b>Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</b></div>
            <div><small>Jumlah Transaksi</small><b>{{ $jumlahTransaksi }}</b></div>
        </div>

        <table>
            <thead><tr><th>No. Invoice</th><th>Tanggal</th><th>Kasir</th><th>Total</th></tr></thead>
            <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ $trx->invoice_number }}</td>
                    <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $trx->user->name }}</td>
                    <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada transaksi pada rentang ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>