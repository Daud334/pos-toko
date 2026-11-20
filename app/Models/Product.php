<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'code', 'name', 'unit', 'price', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected function priceRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp' . number_format($this->price, 0, ',', '.'),
        );
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

        return view('products.show', compact('product', 'totalTerjual', 'riwayat', 'hariTerbaik'));
    }
}