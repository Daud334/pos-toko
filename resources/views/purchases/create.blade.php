<x-app-layout>
    <x-slot name="header">Pembelian Stok Baru</x-slot>

    <style>
        .pf{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
        .pf label{display:block;font-size:13px;margin-bottom:4px}
        .pf input,.pf select,.rowin{width:100%;padding:8px;border:1px solid #d1d5db;border-radius:8px;box-sizing:border-box}
        .btn-sec{background:#e5e7eb;border:0;padding:8px 14px;border-radius:8px;cursor:pointer;margin-top:10px}
        .btn-main{background:#4f46e5;color:#fff;border:0;padding:10px 20px;border-radius:8px;cursor:pointer;margin-top:16px}
        .btn-main:disabled{opacity:.5;cursor:not-allowed}
        .msg-error{background:#fee2e2;color:#991b1b;border:1px solid #fecaca;padding:12px 16px;border-radius:8px;margin-bottom:16px}
        .x{background:none;border:0;color:#dc2626;font-size:20px;cursor:pointer}
    </style>

    @if ($errors->any())
        <div class="msg-error">{{ $errors->first() }}</div>
    @endif

    <div class="card" x-data="poForm()">
        <form method="POST" action="{{ route('purchases.store') }}">
            @csrf
            <div class="pf">
                <div>
                    <label>Supplier</label>
                    <select name="supplier_id" required>
                        <option value="">- pilih supplier -</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}" @selected(old('supplier_id') == $s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="purchased_at" value="{{ old('purchased_at', now()->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="pf" style="grid-template-columns:1fr">
                <div>
                    <label>Catatan (opsional)</label>
                    <input type="text" name="note" value="{{ old('note') }}">
                </div>
            </div>

            <table>
                <thead><tr><th>Produk</th><th style="width:90px">Qty</th><th style="width:140px">Harga Beli</th><th>Subtotal</th><th></th></tr></thead>
                <tbody>
                    <template x-for="(row, index) in rows" :key="row.key">
                        <tr>
                            <td>
                                <select class="rowin" :name="'items[' + index + '][product_id]'" x-model="row.product_id">
                                    <option value="">- pilih produk -</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }} (stok {{ $p->stock }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" min="1" class="rowin" :name="'items[' + index + '][qty]'" x-model.number="row.qty"></td>
                            <td><input type="number" min="0" class="rowin" :name="'items[' + index + '][cost_price]'" x-model.number="row.cost_price"></td>
                            <td x-text="formatRupiah(sub(row))"></td>
                            <td><button type="button" class="x" @click="remove(index)">&times;</button></td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <button type="button" class="btn-sec" @click="add()">+ Tambah Baris</button>
            <p><b>Total: <span x-text="formatRupiah(total())"></span></b></p>
            <button type="submit" class="btn-main" :disabled="rows.some(r => !r.product_id || r.qty < 1)">Simpan Pembelian</button>
        </form>
    </div>

    <script>
        function poForm() {
            return {
                rows: [{ key: 1, product_id: '', qty: 1, cost_price: 0 }],
                next: 2,
                add() { this.rows.push({ key: this.next++, product_id: '', qty: 1, cost_price: 0 }); },
                remove(i) { if (this.rows.length > 1) this.rows.splice(i, 1); },
                sub(r) { return Number(r.qty || 0) * Number(r.cost_price || 0); },
                total() { return this.rows.reduce((s, r) => s + this.sub(r), 0); },
                formatRupiah(v) { return 'Rp' + Number(v || 0).toLocaleString('id-ID'); },
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
</x-app-layout>