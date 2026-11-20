<x-app-layout title="Kategori - POS Barokah Mart">
    <x-slot name="header">
        <div class="row">
            <h2 style="margin:0;font-size:20px">Data Kategori</h2>
            <a href="{{ route('categories.create') }}" class="btn">+ Tambah Kategori</a>
        </div>
    </x-slot>

    <x-card>
        @if (session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-err">{{ session('error') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th style="text-align:center">Jumlah Produk</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td style="text-align:center">{{ $category->products_count }}</td>
                        <td style="text-align:center">
                            <a href="{{ route('categories.edit', $category) }}" class="link-edit">Ubah</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-del">Hapus</button> <a href="{{ route('categories.show', $category) }}">Detail</a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#6b7280">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
</x-app-layout>