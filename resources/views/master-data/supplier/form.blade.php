@php $edit = $supplier->exists; @endphp
<x-app-layout>
    <x-slot name="header">{{ $edit ? 'Edit Supplier' : 'Tambah Supplier' }}</x-slot>

    <style>
        .sf label{display:block;font-size:13px;margin:12px 0 4px}
        .sf input{width:100%;padding:9px;border:1px solid #d1d5db;border-radius:8px;box-sizing:border-box}
        .sf .err{color:#dc2626;font-size:12px}
        .sf button{margin-top:18px;background:#4f46e5;color:#fff;border:0;padding:10px 20px;border-radius:8px;cursor:pointer}
    </style>

    <div class="card sf" style="max-width:520px">
        <form method="POST" action="{{ $edit ? route('suppliers.update', $supplier) : route('suppliers.store') }}">
            @csrf
            @if ($edit) @method('PUT') @endif

            <label>Nama Supplier</label>
            <input type="text" name="name" value="{{ old('name', $supplier->name) }}">
            @error('name') <div class="err">{{ $message }}</div> @enderror

            <label>Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">
            @error('phone') <div class="err">{{ $message }}</div> @enderror

            <label>Alamat</label>
            <input type="text" name="address" value="{{ old('address', $supplier->address) }}">
            @error('address') <div class="err">{{ $message }}</div> @enderror

            <button type="submit">Simpan</button>
        </form>
    </div>
</x-app-layout>