<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <style>
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:20px}
        .stat-grid .card small{display:block;color:#6b7280;font-size:12px}
        .stat-grid .card b{font-size:22px}
        .dash-grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
        .dash-grid ol{padding-left:20px;margin:0}
        .dash-grid li{margin-bottom:8px;font-size:14px}
        .dash-grid li span{color:#6b7280}
    </style>

    <div class="stat-grid">
        <div class="card"><small>Omzet Hari Ini</small><b>Rp{{ number_format($omzetHariIni, 0, ',', '.') }}</b></div>
        <div class="card"><small>Omzet Kemarin</small><b>Rp{{ number_format($omzetKemarin, 0, ',', '.') }}</b></div>
        <div class="card"><small>Transaksi Hari Ini</small><b>{{ $transaksiHariIni }}</b></div>
        <div class="card"><small>Produk Stok Menipis</small><b style="color:#ca8a04">{{ $produkMenipis }}</b></div>
    </div>

    <div class="dash-grid">
        <div class="card">
            <h3>Tren Penjualan 7 Hari Terakhir</h3>
            <canvas id="chartTren" height="120"></canvas>
        </div>
        <div class="card">
            <h3>Produk Terlaris</h3>
            <ol>
                @forelse ($produkTerlaris as $produk)
                    <li>{{ $produk->name }} <span>({{ $produk->total_qty }} terjual)</span></li>
                @empty
                    <li>Belum ada penjualan.</li>
                @endforelse
            </ol>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelTren),
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: @json($dataTren),
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,.1)',
                    fill: true,
                    tension: 0.3,
                }],
            },
        });
    </script>
</x-app-layout>