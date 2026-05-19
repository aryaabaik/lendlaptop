<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use App\Models\LaptopReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    /**
     * Display a listing of returns.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = LaptopReturn::with(['borrowing.user', 'borrowing.laptop']);
        
        if ($search) {
            $query->where(function($mainQ) use ($search) {
                $mainQ->whereHas('borrowing', function ($bq) use ($search) {
                    $bq->where('borrower_name', 'like', '%' . $search . '%')
                       ->orWhereHas('user', function ($uq) use ($search) {
                           $uq->where('name', 'like', '%' . $search . '%');
                       });
                })->orWhereHas('borrowing.laptop', function ($lq) use ($search) {
                    $lq->where('model', 'like', '%' . $search . '%')
                       ->orWhere('brand', 'like', '%' . $search . '%')
                       ->orWhere('code', 'like', '%' . $search . '%');
                });
            });
        }
        
        $returns = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        
        // Ambil peminjaman aktif yang belum dikembalikan untuk modal pengembalian cepat
        $active_borrowings = \App\Models\Borrowing::whereIn('status', ['approved', 'borrowed'])
            ->with(['user', 'laptop'])
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.returns.index', compact('returns', 'search', 'active_borrowings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrowing_id'    => 'required|exists:borrowings,id',
            'condition_after' => 'required|in:baik,rusak_ringan,rusak_berat',
            'fine'            => 'nullable|numeric|min:0',
            'note'            => 'nullable|string|max:500',
        ]);

        $borrowing = Borrowing::findOrFail($validated['borrowing_id']);
        
        // Update borrowing
        $borrowing->update([
            'status'             => 'returned',
            'actual_return_date' => now(),
        ]);

        // Update laptop status based on condition
        $laptopStatus = 'tersedia';
        if ($validated['condition_after'] === 'rusak_berat') {
            $laptopStatus = 'rusak';
        } elseif ($validated['condition_after'] === 'rusak_ringan') {
            $laptopStatus = 'maintenance';
        }

        if ($borrowing->laptop) {
            $borrowing->laptop->update([
                'condition' => $validated['condition_after'],
                'status'    => $laptopStatus,
            ]);
        }

        // Create return record
        LaptopReturn::create([
            'borrowing_id'    => $borrowing->id,
            'condition_after' => $validated['condition_after'],
            'fine'            => $validated['fine'] ?? 0,
            'note'            => $validated['note'] ?? null,
        ]);

        // Log
        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => 'returned',
            'description'  => 'Laptop dikembalikan. Kondisi: ' . ucfirst(str_replace('_', ' ', $validated['condition_after'])),
            'user_id'      => Auth::id(),
        ]);

        return redirect()->route('admin.borrowings.show', $borrowing->id)
            ->with('success', 'Pengembalian laptop berhasil diproses!');
    }
}
