<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Laptop;
use App\Models\LaptopReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(29)->format('Y-m-d'));
        $endDate   = $request->input('end_date',   now()->format('Y-m-d'));

        // ── 1. STAT SUMMARY ──────────────────────────────────────────────
        $totalBorrowings = Borrowing::whereBetween('borrow_date', [$startDate, $endDate])->count();

        $totalReturns = Borrowing::where('status', 'returned')
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->count();

        $stillBorrowed = Borrowing::where('status', 'borrowed')
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->count();

        $lateBorrowings = Borrowing::where('status', 'borrowed')
            ->where('return_date', '<', now())
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->count();

        // ── 2. CHART: Peminjaman per Hari ────────────────────────────────
        $rawDaily = Borrowing::select(
                DB::raw("DATE(borrow_date) as day"),
                DB::raw("COUNT(id) as total")
            )
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->groupBy(DB::raw("DATE(borrow_date)"))
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        // Fill every date in range (so no gaps in chart)
        $period     = CarbonPeriod::create($startDate, $endDate);
        $dayLabels  = [];
        $dayValues  = [];
        $dayFull    = [];   // full date string for tooltip
        $hariId     = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $bulanId    = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        foreach ($period as $date) {
            $key        = $date->format('Y-m-d');
            $dayNum     = (int)$date->format('w');           // 0=Sun … 6=Sat
            $bulanNum   = (int)$date->format('n') - 1;      // 0-based
            $dayLabels[] = $hariId[$dayNum] . ', ' . $date->format('d') . ' ' . $bulanId[$bulanNum];
            $dayValues[] = $rawDaily->has($key) ? (int)$rawDaily[$key]->total : 0;
        }

        // ── 3. TOP LAPTOP PALING SERING DIPINJAM ─────────────────────────
        $topLaptops = Laptop::withCount(['borrowings' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('borrow_date', [$startDate, $endDate]);
            }])
            ->orderBy('borrowings_count', 'desc')
            ->limit(10)
            ->get();

        // ── 4. TABEL DETAIL PEMINJAMAN ────────────────────────────────────
        $detailBorrowings = Borrowing::with(['user', 'laptop'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->orderBy('borrow_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.index', compact(
            'startDate', 'endDate',
            'totalBorrowings', 'totalReturns', 'stillBorrowed', 'lateBorrowings',
            'dayLabels', 'dayValues',
            'topLaptops',
            'detailBorrowings'
        ));
    }
}
