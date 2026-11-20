<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(protected $start, protected $end, protected $kasirId = null) {}

    public function collection(): Enumerable
    {
        return Transaction::with('user')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->when($this->kasirId, fn ($q) => $q->where('user_id', $this->kasirId))
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return ['No. Invoice', 'Tanggal', 'Kasir', 'Total', 'Bayar', 'Kembalian'];
    }

    public function map(mixed $row): array
    {
        return [
            $row->invoice_number,
            $row->created_at->format('d-m-Y H:i'),
            $row->user->name,
            $row->total,
            $row->pay,
            $row->change,
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }
}