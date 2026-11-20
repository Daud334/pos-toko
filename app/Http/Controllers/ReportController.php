<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->subDays(6)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->end)->endOfDay() : now()->endOfDay();

        $transactions = Transaction::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->when($request->filled('kasir_id'), fn ($q) => $q->where('user_id', $request->kasir_id))
            ->latest()
            ->get();

        $kasirs = User::where('role', 'kasir')->orderBy('name')->get();
        $totalPenjualan = $transactions->sum('total');
        $jumlahTransaksi = $transactions->count();

        return view('reports.sales', compact('transactions', 'kasirs', 'totalPenjualan', 'jumlahTransaksi', 'start', 'end'));
    }

    public function export(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->subDays(6)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->end)->endOfDay() : now()->endOfDay();

        $filename = 'laporan-penjualan-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.xlsx';

        return Excel::download(new SalesExport($start, $end, $request->kasir_id), $filename);
    }
}