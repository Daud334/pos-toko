<x-app-layout title="Tambah Produk - POS Barokah Mart">
    <x-slot name="header">
        <h2 style="margin:0;font-size:20px">Tambah Produk</h2>
    </x-slot>

    <x-card style="max-width:640px">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <label>Kategori</label>
            <select name="category_id">
                <option value="" disabled selected>Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="err">{{ $message }}</p> @enderror

            <label>Kode Produk</label>
            <input type="text" name="code" value="{{ old('code') }}">
            @error('code') <p class="err">{{ $message }}</p> @enderror

            <label>Nama Produk</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <p class="err">{{ $message }}</p> @enderror

            <div class="grid3">
                <div>
                    <label>Satuan</label>
                    <input type="text" name="unit" value="{{ old('unit', 'pcs') }}">
                    @error('unit') <p class="err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label>Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}">
                    @error('price') <p class="err">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label>Stok Awal</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}">
                    @error('stock') <p class="err">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="btn" style="margin-top:18px">Simpan Produk</button>
        </form>
    </x-card>
</x-app-layout>