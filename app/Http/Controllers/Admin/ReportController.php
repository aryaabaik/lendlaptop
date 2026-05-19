<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Laptop;
use App\Models\LaptopReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonths(6)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // 1. STAT SUMMARY GRID
        $totalBorrowings = Borrowing::whereBetween('borrow_date', [$startDate, $endDate])->count();
        $totalReturns = Borrowing::where('status', 'returned')
            ->whereBetween('actual_return_date', [$startDate, $endDate])
            ->count();
        $totalFines = LaptopReturn::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('fine');
        $damagedLaptops = Laptop::whereIn('status', ['rusak', 'maintenance'])->count();

        // 2. GRAFIK BATANG: Peminjaman per Bulan (Teal)
        $monthlyData = Borrowing::select(
                DB::raw("DATE_FORMAT(borrow_date, '%M %Y') as month"),
                DB::raw("COUNT(id) as count")
            )
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->groupBy(DB::raw("DATE_FORMAT(borrow_date, '%M %Y')"), DB::raw("MONTH(borrow_date)"))
            ->orderBy(DB::raw("MONTH(borrow_date)"), 'asc')
            ->get();

        $monthlyLabels = $monthlyData->pluck('month')->toArray();
        $monthlyValues = $monthlyData->pluck('count')->toArray();

        // 3. GRAFIK PIE/DONUT: Distribusi Status Laptop
        $laptopStats = Laptop::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        
        $laptopStatuses = ['tersedia', 'dipinjam', 'maintenance', 'rusak'];
        $laptopCounts = [0, 0, 0, 0];
        foreach ($laptopStats as $stat) {
            $idx = array_search($stat->status, $laptopStatuses);
            if ($idx !== false) {
                $laptopCounts[$idx] = $stat->count;
            }
        }

        // 4. TOP 5 LAPTOP PALING SERING DIPINJAM
        $topLaptops = Laptop::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->limit(5)
            ->get();

        // 5. TOP 5 PEMINJAM PALING AKTIF
        $topBorrowers = User::where('role', 'user')
            ->withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->limit(5)
            ->get();

        // 6. TABEL DETAIL SEMUA PEMINJAMAN PERIODE
        $detailBorrowings = Borrowing::with(['user', 'laptop'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->orderBy('borrow_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reports.index', compact(
            'startDate', 'endDate',
            'totalBorrowings', 'totalReturns', 'totalFines', 'damagedLaptops',
            'monthlyLabels', 'monthlyValues',
            'laptopCounts',
            'topLaptops', 'topBorrowers',
            'detailBorrowings'
        ));
    }
}
