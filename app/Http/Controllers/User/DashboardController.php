<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Laptop;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.dashboard.index', [
            'activeBorrowings'  => $user->borrowings()->whereIn('status',['approved','borrowed'])->count(),
            'pendingBorrowings' => $user->borrowings()->where('status','pending')->count(),
            'totalBorrowings'   => $user->borrowings()->count(),
            'activeLoan'        => $user->borrowings()
                                        ->with('laptop')
                                        ->whereIn('status',['approved','borrowed'])
                                        ->latest()
                                        ->first(),
            'availableLaptops'  => Laptop::orderByRaw("status = 'tersedia' DESC")->take(6)->get(),
        ]);
    }
}
