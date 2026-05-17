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

        $activeBorrowings = Borrowing::with('laptop')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved','borrowed'])
            ->latest()->take(5)->get();

        $recentBorrowings = Borrowing::with('laptop')
            ->where('user_id', $user->id)
            ->latest()->take(5)->get();

        return view('user.dashboard', compact('stats', 'activeBorrowings', 'recentBorrowings'));
    }
}
