<x-app-layout title="Tambah Kategori - POS Barokah Mart">
    <x-slot name="header">
        <h2 style="margin:0;font-size:20px">Tambah Kategori</h2>
    </x-slot>

    <x-card style="max-width:560px">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <label>Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <p class="err">{{ $message }}</p> @enderror

            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description') }}</textarea>
            @error('description') <p class="err">{{ $message }}</p> @enderror

            <button type="submit" class="btn" style="margin-top:18px">Simpan</button>
        </form>
    </x-card>
</x-app-layout>