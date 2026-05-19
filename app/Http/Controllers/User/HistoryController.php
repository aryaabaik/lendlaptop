<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display listing of user's past borrowing history.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status', 'all');

        // Query dasar (Hanya memuat status riwayat: returned, rejected, cancelled)
        $query = Borrowing::with(['laptop'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['returned', 'rejected', 'cancelled']);

        // Search Filter
        if ($search) {
            $query->whereHas('laptop', function($q) use ($search) {
                $q->where('brand', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // Date range filter
        if ($startDate && $endDate) {
            $query->whereBetween('borrow_date', [$startDate, $endDate]);
        }

        // Status filter
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $histories = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // ─── SUMMARY METRICS ───
        // 1. Total Peminjaman (Semua pengajuan yang pernah diajukan, termasuk aktif & riwayat)
        $totalBorrowingsCount = Borrowing::where('user_id', $user->id)->count();

        // 2. Total Hari Pinjam (Akumulasi hari dari unit yang sudah dikembalikan)
        $returnedLoans = Borrowing::where('user_id', $user->id)->where('status', 'returned')->get();
        $totalDays = 0;
        foreach ($returnedLoans as $loan) {
            if ($loan->return_date && $loan->borrow_date) {
                $totalDays += $loan->borrow_date->diffInDays($loan->return_date) ?: 1;
            }
        }

        // 3. Total Denda Terbayar/Ditagih
        $totalFines = 0;

        return view('user.history.index', compact(
            'histories', 'search', 'startDate', 'endDate', 'status',
            'totalBorrowingsCount', 'totalDays', 'totalFines'
        ));
    }
}
