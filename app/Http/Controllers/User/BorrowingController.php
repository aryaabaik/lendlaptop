<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Display listing of user's borrowings.
     */
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'active');
        $query = Borrowing::with('laptop')->where('user_id', Auth::id());

        if ($tab === 'active') {
            $query->whereIn('status', ['approved', 'borrowed']);
        } elseif ($tab === 'pending') {
            $query->where('status', 'pending');
        } // 'all' displays everything

        $borrowings = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('user.borrowings.index', compact('borrowings', 'tab'));
    }

    /**
     * Store a newly created borrowing request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'laptop_id'     => 'required|exists:laptops,id',
            'borrower_name' => 'required|string|max:255',
            'borrow_date'   => 'required|date|after_or_equal:today',
            'return_date'   => 'required|date|after:borrow_date',
            'purpose'       => 'required|string|max:500',
        ]);

        $laptop = Laptop::findOrFail($validated['laptop_id']);

        // Pastikan laptop tersedia
        if ($laptop->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Laptop tidak tersedia untuk dipinjam saat ini!');
        }

        // Buat data borrowing
        Borrowing::create([
            'user_id'       => Auth::id(),
            'laptop_id'     => $validated['laptop_id'],
            'borrower_name' => $validated['borrower_name'],
            'borrow_date'   => $validated['borrow_date'],
            'return_date'   => $validated['return_date'],
            'purpose'       => $validated['purpose'],
            'status'        => 'pending',
        ]);

        return redirect()->route('user.borrowings.index', ['tab' => 'pending'])
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin!');
    }

    /**
     * Display detailed borrowing info.
     */
    public function show(Borrowing $borrowing)
    {
        // Security check
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $borrowing->load(['laptop']);
        return view('user.borrowings.show', compact('borrowing'));
    }

    /**
     * Cancel a pending borrowing request.
     */
    public function destroy(Borrowing $borrowing)
    {
        // Security check
        if ($borrowing->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pengajuan berstatus PENDING yang dapat dibatalkan!');
        }

        $borrowing->delete();

        return redirect()->route('user.borrowings.index', ['tab' => 'pending'])
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }
}
