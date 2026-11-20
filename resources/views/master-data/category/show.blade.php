<x-app-layout>
    <x-slot name="header">Detail Kategori</x-slot>

    <div class="card">
        <h3>{{ $category->name }}</h3>
        <p style="color:#6b7280">{{ $products->count() }} produk &middot; Total stok: <b>{{ $totalStok }}</b></p>

        <table>
            <thead><tr><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th></tr></thead>
            <tbody>
            @forelse ($products as $p)
                <tr>
                    <td>{{ $p->code }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->priceRupiah }}</td>
                    <td>{{ $p->stock }} {{ $p->unit }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada produk.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>