<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingLog;
use App\Models\Laptop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_laptops'        => Laptop::count(),
            'borrowed_count'       => Borrowing::where('status', 'borrowed')->count(),
            'returned_today_count' => Borrowing::where('status', 'returned')->whereDate('return_date', today())->count(),
            'pending_count'        => Borrowing::where('status', 'pending')->count(),
        ];

        // 2. Bar Chart Data (Peminjaman per Hari)
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
            'Sabtu'     => 'Sabtu',
            'Minggu'    => 'Minggu',
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

        // 3. Peminjaman Hari Ini + Overdue (untuk highlight amber)
        $todayBorrowings = Borrowing::with(['user', 'laptop'])
            ->where(function($query) {
                $query->whereDate('borrow_date', today())
                      ->orWhere(function($q) {
                          $q->where('status', 'borrowed')
                            ->whereDate('return_date', '<', today());
                      });
            })
            ->orderBy('return_date', 'asc')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'borrowingsByDay', 'todayBorrowings'));
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
