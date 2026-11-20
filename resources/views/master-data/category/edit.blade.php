<x-app-layout title="Ubah Kategori - POS Barokah Mart">
    <x-slot name="header">
        <h2 style="margin:0;font-size:20px">Ubah Kategori</h2>
    </x-slot>

    <x-card style="max-width:560px">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}">
            @error('name') <p class="err">{{ $message }}</p> @enderror

            <label>Deskripsi</label>
            <textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="err">{{ $message }}</p> @enderror

            <button type="submit" class="btn" style="margin-top:18px">Simpan Perubahan</button>
        </form>
    </x-card>
</x-app-layout>