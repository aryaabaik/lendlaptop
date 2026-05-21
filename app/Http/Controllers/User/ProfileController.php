<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.profile.index', [
            'totalBorrowings'  => $user->borrowings()->count(),
            'activeBorrowings' => $user->borrowings()->whereIn('status',['approved','borrowed'])->count(),
            'lateBorrowings'   => $user->borrowings()->where('status','late')->count(),
            'recentBorrowings' => $user->borrowings()->with('laptop')->latest()->take(5)->get(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'kelas' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ]);
        auth()->user()->update($request->only('name','kelas','phone'));
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
