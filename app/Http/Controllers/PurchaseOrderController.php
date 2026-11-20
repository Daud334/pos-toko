<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchases = PurchaseOrder::with('supplier')->withCount('items')->latest()->paginate(10);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get(['id', 'code', 'name', 'unit', 'stock']);

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'        => 'required|exists:suppliers,id',
            'purchased_at'       => 'required|date',
            'note'               => 'nullable|string|max:255',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty'        => 'required|integer|min:1',
            'items.*.cost_price' => 'required|integer|min:0',
        ]);

        $purchase = DB::transaction(function () use ($data) {
            $total = 0;
            $rows = [];

            foreach ($data['items'] as $item) {
                $subtotal = $item['qty'] * $item['cost_price'];
                $total += $subtotal;

                $rows[] = [
                    'product_id' => $item['product_id'],
                    'qty'        => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'subtotal'   => $subtotal,
                ];

                Product::whereKey($item['product_id'])->increment('stock', $item['qty']);
            }

            $urut = PurchaseOrder::whereDate('created_at', now())->count() + 1;

            $po = PurchaseOrder::create([
                'po_number'    => 'PO-' . now()->format('Ymd') . '-' . str_pad($urut, 4, '0', STR_PAD_LEFT),
                'supplier_id'  => $data['supplier_id'],
                'user_id'      => auth()->id(),
                'purchased_at' => $data['purchased_at'],
                'note'         => $data['note'] ?? null,
                'total'        => $total,
            ]);

            $po->items()->createMany($rows);

            return $po;
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Pembelian stok berhasil disimpan.');
    }

    public function show(PurchaseOrder $purchase)
    {
        $purchase->load('supplier', 'user', 'items.product');

        return view('purchases.show', compact('purchase'));
    }
}