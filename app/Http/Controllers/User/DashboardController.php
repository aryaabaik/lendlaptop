<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Laptop;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'active'    => Borrowing::where('user_id', $user->id)->whereIn('status', ['approved','borrowed'])->count(),
            'pending'   => Borrowing::where('user_id', $user->id)->where('status', 'pending')->count(),
            'returned'  => Borrowing::where('user_id', $user->id)->where('status', 'returned')->count(),
            'available' => Laptop::where('status', 'tersedia')->count(),
        ];

        // Ambil peminjaman aktif yang sedang dibawa (status 'borrowed' atau 'approved')
        $activeBorrowings = Borrowing::with('laptop')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved','borrowed'])
            ->latest()->get();

        // Riwayat peminjaman terbaru
        $recentBorrowings = Borrowing::with('laptop')
            ->where('user_id', $user->id)
            ->latest()->take(5)->get();

        // Ambil laptop preview (tersedia, 4 unit)
        $availableLaptops = Laptop::where('status', 'tersedia')
            ->latest()->take(4)->get();

        return view('user.dashboard.index', compact('user', 'stats', 'activeBorrowings', 'recentBorrowings', 'availableLaptops'));
    }
}
