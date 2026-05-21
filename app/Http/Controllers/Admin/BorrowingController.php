<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $day = $request->input('day');

        // Query Utama
        $query = Borrowing::with(['user', 'laptop']);

        // Filter Pencarian (Nama Peminjam / Merk / Model)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%');
                  })->orWhereHas('laptop', function ($lq) use ($search) {
                      $lq->where('model', 'like', '%' . $search . '%')
                         ->orWhere('brand', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter Date Range
        if ($startDate && $endDate) {
            $query->whereBetween('borrow_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('borrow_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('borrow_date', '<=', $endDate);
        }

        // Filter Weekday (Senin-Jumat)
        if ($day && $day !== 'all') {
            $dayNumbers = [
                'Senin'  => 2,
                'Selasa' => 3,
                'Rabu'   => 4,
                'Kamis'  => 5,
                'Jumat'  => 6,
            ];
            if (isset($dayNumbers[$day])) {
                $query->whereRaw("DAYOFWEEK(borrow_date) = ?", [$dayNumbers[$day]]);
            }
        }

        // Hitung count untuk tab status sebelum memfilter status query utama
        $counts = [
            'all'      => (clone $query)->count(),
            'pending'  => (clone $query)->where('status', 'pending')->count(),
            'approved' => (clone $query)->where('status', 'approved')->count(),
            'borrowed' => (clone $query)->where('status', 'borrowed')->count(),
            'returned' => (clone $query)->where('status', 'returned')->count(),
            'rejected' => (clone $query)->where('status', 'rejected')->count(),
            'late'     => (clone $query)->where('status', 'borrowed')->where('return_date', '<', now())->count(),
        ];

        // Terapkan filter status pada query utama
        if ($status && $status !== 'all') {
            if ($status === 'late') {
                $query->where('status', 'borrowed')->where('return_date', '<', now());
            } else {
                $query->where('status', $status);
            }
        }

        $borrowings = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // 3. Peminjaman per Hari untuk Info Ringkas (Pills)
        $rawByDay = Borrowing::countByDay();
        $dayMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
            'Senin'     => 'Senin',
            'Selasa'    => 'Selasa',
            'Rabu'      => 'Rabu',
            'Kamis'     => 'Kamis',
            'Jumat'     => 'Jumat',
        ];
        
        $weekdays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $borrowingsByDay = collect();
        foreach ($weekdays as $wday) {
            $found = $rawByDay->first(function ($item) use ($wday, $dayMap) {
                $mappedName = $dayMap[$item->day] ?? $item->day;
                return strtolower($mappedName) === strtolower($wday);
            });
            $borrowingsByDay->push((object)[
                'day' => $wday,
                'total' => $found ? (int)$found->total : 0
            ]);
        }

        return view('admin.borrowings.index', compact(
            'borrowings', 'counts', 'status', 'search', 'startDate', 'endDate', 'day', 'borrowingsByDay'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya tampilkan status=tersedia
        $laptops = \App\Models\Laptop::where('status', 'tersedia')->get();
        return view('admin.borrowings.create', compact('laptops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'laptop_id'     => 'required|exists:laptops,id',
            'purpose'       => 'required|string|max:255',
            'borrow_date'   => 'required|date',
            'return_date'   => 'required|date|after:borrow_date',
            'status'        => 'required|in:pending,approved,borrowed',
            'admin_note'    => 'nullable|string|max:1000',
        ], [
            'return_date.after' => 'Tanggal kembali harus setelah tanggal pinjam.',
        ]);

        // Validasi tambahan: pastikan laptop masih tersedia
        $laptop = \App\Models\Laptop::findOrFail($request->laptop_id);
        if ($laptop->status !== 'tersedia') {
            return back()->withInput()->with('error', 'Laptop yang dipilih sedang tidak tersedia.');
        }

        // Simpan Peminjaman
        $borrowing = Borrowing::create([
            'user_id'       => null, // admin input langsung
            'laptop_id'     => $request->laptop_id,
            'borrower_name' => $request->borrower_name,
            'borrow_date'   => $request->borrow_date,
            'return_date'   => $request->return_date,
            'purpose'       => $request->purpose,
            'status'        => $request->status,
            'admin_note'    => $request->admin_note,
        ]);

        // Saat status diset 'borrowed'/'approved', otomatis update laptop.status = 'dipinjam'
        if (in_array($request->status, ['approved', 'borrowed'])) {
            $laptop->update(['status' => 'dipinjam']);
        }

        // Catat Log
        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => $request->status,
            'description'  => 'Peminjaman diinput langsung oleh admin dengan status ' . ucfirst($request->status),
            'user_id'      => Auth::id(),
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Transaksi peminjaman berhasil disimpan!');
    }

    /**
     * Setujui peminjaman laptop.
     */
    public function approve(Borrowing $borrowing)
    {
        $borrowing->update(['status' => 'approved']);
        
        // Tandai laptop sebagai dipinjam
        if ($borrowing->laptop) {
            $borrowing->laptop->update(['status' => 'dipinjam']);
        }

        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => 'approved',
            'description'  => 'Peminjaman disetujui oleh admin',
            'user_id'      => Auth::id(),
        ]);

        if ($borrowing->user_id) {
            \App\Helpers\NotificationHelper::send(
                $borrowing->user_id,
                'Peminjaman Disetujui ✓',
                'Laptop ' . $borrowing->laptop->brand . ' ' . $borrowing->laptop->model . ' siap diambil.',
                'success',
                route('user.borrowings.index')
            );
        }

        return back()->with('success', 'Peminjaman berhasil disetujui!');
    }

    /**
     * Tolak peminjaman laptop.
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500'
        ]);

        $borrowing->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        // Kembalikan status laptop ke tersedia
        if ($borrowing->laptop) {
            $borrowing->laptop->update(['status' => 'tersedia']);
        }

        BorrowingLog::create([
            'borrowing_id' => $borrowing->id,
            'activity'     => 'rejected',
            'description'  => 'Peminjaman ditolak: ' . $request->admin_note,
            'user_id'      => Auth::id(),
        ]);

        if ($borrowing->user_id) {
            \App\Helpers\NotificationHelper::send(
                $borrowing->user_id,
                'Peminjaman Ditolak',
                'Pengajuan Anda ditolak. Alasan: ' . $borrowing->admin_note,
                'warning',
                route('user.borrowings.index')
            );
        }

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'laptop', 'logs.user']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('admin.borrowings.index')->with('success', 'Data transaksi peminjaman berhasil dihapus!');
    }
}
