<x-app-layout>
    <x-slot name="header">Data Supplier</x-slot>

    <style>
        .btn-add{display:inline-block;background:#4f46e5;color:#fff;padding:9px 16px;border-radius:8px;text-decoration:none;margin-bottom:16px}
        .msg-error{background:#fee2e2;color:#991b1b;border:1px solid #fecaca;padding:12px 16px;border-radius:8px;margin-bottom:16px}
    </style>

    <div class="card">
        @if (session('error'))
            <div class="msg-error">{{ session('error') }}</div>
        @endif

        <a href="{{ route('suppliers.create') }}" class="btn-add">+ Tambah Supplier</a>

        <table>
            <thead><tr><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Jumlah PO</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($suppliers as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->phone ?? '-' }}</td>
                    <td>{{ $s->address ?? '-' }}</td>
                    <td>{{ $s->purchase_orders_count }}</td>
                    <td>
                        <a href="{{ route('suppliers.edit', $s) }}" class="link-edit">Edit</a>
                        <form method="POST" action="{{ route('suppliers.destroy', $s) }}" style="display:inline"
                              onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-del">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada supplier.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>