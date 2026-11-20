<?php

namespace App\Exports;

use App\Models\TransactionDetail;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TopProductsSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(protected $start, protected $end, protected $kasirId = null) {}

    public function collection(): Enumerable
    {
        return TransactionDetail::join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->whereBetween('transactions.created_at', [$this->start, $this->end])
            ->when($this->kasirId, fn ($q) => $q->where('transactions.user_id', $this->kasirId))
            ->selectRaw('products.code, products.name,
                         SUM(transaction_details.qty) as total_qty,
                         SUM(transaction_details.subtotal) as total_omzet')
            ->groupBy('products.id', 'products.code', 'products.name')
            ->orderByDesc('total_qty')
            ->get()
            ->map(fn ($r) => [$r->code, $r->name, (int) $r->total_qty, (int) $r->total_omzet]);
    }

    public function headings(): array
    {
        return ['Kode', 'Nama Produk', 'Total Terjual', 'Total Omzet'];
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }
}