<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Soal 1: filter status stok
        $threshold = config('pos.low_stock_threshold');

        if ($request->stock_status === 'habis') {
            $query->where('stock', '<=', 0);
        } elseif ($request->stock_status === 'menipis') {
            $query->where('stock', '>', 0)->where('stock', '<', $threshold);
        }

        // Soal 2: jumlah data per halaman
        $perPage = in_array((int) $request->per_page, [10, 25, 50])
            ? (int) $request->per_page
            : 10;

        $products = $query->latest()->paginate($perPage)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('master-data.product.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
    public function show(Product $product)
    {
        $product->load('category');

        $totalTerjual = $product->transactionDetails()->sum('qty');

        $riwayat = $product->transactionDetails()
            ->with('transaction')
            ->latest('id')
            ->take(10)
            ->get();

        $hariTerbaik = $product->transactionDetails()
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->selectRaw('DATE(transactions.created_at) as tanggal,
                        SUM(transaction_details.qty) as total_qty,
                        SUM(transaction_details.subtotal) as total_omzet')
            ->groupBy('tanggal')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('master-data.product.show', compact('product', 'totalTerjual', 'riwayat', 'hariTerbaik'));
    }
}