<x-app-layout title="Produk - POS Barokah Mart">
    <x-slot name="header">
        <div class="row">
            <h2 style="margin:0;font-size:20px">Data Produk</h2>
            <a href="{{ route('products.create') }}" class="btn">+ Tambah Produk</a>
        </div>
    </x-slot>

    <x-card>
        @if (session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('products.index') }}" class="filters">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau kode produk...">

            <select name="category_id">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="stock_status">
                <option value="">Semua Stok</option>
                <option value="menipis" @selected(request('stock_status') == 'menipis')>Menipis</option>
                <option value="habis" @selected(request('stock_status') == 'habis')>Habis</option>
            </select>

            <select name="per_page">
                @foreach ([10, 25, 50] as $n)
                    <option value="{{ $n }}" @selected(request('per_page', 10) == $n)>{{ $n }} / halaman</option>
                @endforeach
            </select>

            <button type="submit" class="btn">Cari</button>
            <a href="{{ route('products.index') }}" class="reset">Reset</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:center">Stok</th>
                    <th style="text-align:right">Total Nilai Stok</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="@if ($product->stock <= 0) row-out @elseif ($product->stock < config('pos.low_stock_threshold')) row-low @endif">
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td style="text-align:right">{{ $product->price_rupiah }}</td>
                        <td style="text-align:center">{{ $product->stock }} <x-badge :stock="$product->stock" /></td>
                        <td style="text-align:right">
                            Rp{{ number_format($product->stock * $product->price, 0, ',', '.') }}
                        </td>
                        <td style="text-align:center">
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-del">Hapus</button> <a href="{{ route('products.show', $product) }}">Detail</a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:#6b7280">Belum ada data produk.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($products->total() > 0)
            <p class="info">
                Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }}
                dari {{ $products->total() }} produk
            </p>
        @endif

        {{ $products->links('pagination.simple') }}
    </x-card>
</x-app-layout>