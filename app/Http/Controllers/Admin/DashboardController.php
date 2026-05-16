<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use App\Models\Laptop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_laptops'    => Laptop::count(),
            'total_users'      => User::where('role', 'user')->count(),
            'pending_requests' => Borrowing::where('status', 'pending')->count(),
            'active_loans'     => Borrowing::where('status', 'borrowed')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function approve(Borrowing $borrowing)
    {
        $borrowing->update(['status' => 'approved']);
        $borrowing->laptop->update(['status' => 'dipinjam']);

        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => 'approved',
            'description'  => 'Peminjaman disetujui oleh admin',
            'user_id'      => Auth::id(),
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    public function reject(Borrowing $borrowing)
    {
        $borrowing->update([
            'status'     => 'rejected',
            'admin_note' => request('admin_note'),
        ]);

        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => 'rejected',
            'description'  => 'Peminjaman ditolak: ' . request('admin_note'),
            'user_id'      => Auth::id(),
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
