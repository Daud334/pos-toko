<x-app-layout>
    <x-slot name="header">Transaksi Penjualan</x-slot>

    <style>
        .pos{display:grid;grid-template-columns:2fr 1fr;gap:20px}
        .pos-search{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:8px;margin-bottom:14px;box-sizing:border-box}
        .pos-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;max-height:440px;overflow-y:auto}
        .pos-item{border:1px solid #e5e7eb;border-radius:8px;padding:10px;text-align:left;background:#fff;cursor:pointer}
        .pos-item:hover{background:#eef2ff}
        .pos-item b{display:block;font-size:14px}
        .pos-item small{color:#6b7280;display:block}
        .pos-item span{color:#4f46e5;font-weight:600;font-size:14px}
        .cart-row{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-bottom:10px;font-size:14px}
        .cart-row input{width:60px;text-align:center;padding:4px}
        .cart-row small{color:#6b7280}
        .x{background:none;border:0;color:#dc2626;font-size:20px;cursor:pointer}
        .sum{border-top:1px solid #e5e7eb;margin-top:12px;padding-top:12px}
        .sum div{display:flex;justify-content:space-between;margin-bottom:6px}
        .sum input{width:100%;padding:8px;border:1px solid #d1d5db;border-radius:8px;box-sizing:border-box;margin-bottom:6px}
        .btn-pay{width:100%;margin-top:12px;background:#4f46e5;color:#fff;border:0;padding:11px;border-radius:8px;cursor:pointer;font-size:15px}
        .btn-pay:disabled{opacity:.5;cursor:not-allowed}
    </style>
    @if (session('error'))
        <div style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;padding:12px 16px;border-radius:8px;margin-bottom:16px">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;padding:12px 16px;border-radius:8px;margin-bottom:16px">
            {{ $errors->first() }}
        </div>
    @endif
    <div class="pos" x-data="posCart({{ $products->toJson() }})">

        <div class="card">
            <input type="text" class="pos-search" x-model="keyword" placeholder="Cari nama atau kode produk...">
            <div class="pos-grid">
                <template x-for="product in filteredProducts()" :key="product.id">
                    <button type="button" class="pos-item" @click="addItem(product)">
                        <b x-text="product.name"></b>
                        <small x-text="'Stok: ' + product.stock"></small>
                        <span x-text="formatRupiah(product.price)"></span>
                    </button>
                </template>
            </div>
        </div>

        <div class="card">
            <h3>Keranjang</h3>
            <form action="{{ route('pos.store') }}" method="POST">
                @csrf
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="cart-row">
                        <div>
                            <div x-text="item.name"></div>
                            <small x-text="formatRupiah(item.price) + ' x'"></small>
                        </div>
                        <input type="number" min="1" :max="item.stock" x-model.number="item.qty" @input="clampQty(item)">
                        <button type="button" class="x" @click="removeItem(index)">&times;</button>
                        <input type="hidden" :name="'items[' + index + '][product_id]'" :value="item.id">
                        <input type="hidden" :name="'items[' + index + '][qty]'" :value="item.qty">
                    </div>
                </template>

                <div class="sum">
                    <div><b>Total</b><b x-text="formatRupiah(total())"></b></div>
                    <label>Bayar</label>
                    <input type="number" name="pay" x-model.number="pay" min="0">
                    <div><span>Kembalian</span><span x-text="formatRupiah(change())"></span></div>
                </div>

                <button type="submit" class="btn-pay" :disabled="cart.length === 0 || pay < total()">Simpan Transaksi</button>
            </form>
        </div>
    </div>

    <script>
        function posCart(products) {
            return {
                products: products,
                cart: [],
                keyword: '',
                pay: 0,
                filteredProducts() {
                    if (!this.keyword) return this.products;
                    const k = this.keyword.toLowerCase();
                    return this.products.filter(p =>
                        p.name.toLowerCase().includes(k) || p.code.toLowerCase().includes(k)
                    );
                },
                addItem(product) {
                    const existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        if (existing.qty < product.stock) existing.qty++;
                        return;
                    }
                    this.cart.push({ ...product, qty: 1 });
                },
                clampQty(item) {
                    if (item.qty < 1) item.qty = 1;
                    if (item.qty > item.stock) item.qty = item.stock;
                },
                removeItem(index) { this.cart.splice(index, 1); },
                total() { return this.cart.reduce((s, i) => s + (i.price * i.qty), 0); },
                change() { return Math.max(this.pay - this.total(), 0); },
                formatRupiah(v) { return 'Rp' + Number(v || 0).toLocaleString('id-ID'); },
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
</x-app-layout>