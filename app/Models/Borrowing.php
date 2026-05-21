<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id','laptop_id','borrower_name',
        'borrow_date','return_date','purpose',
        'status','admin_note','fine','actual_return_date',
    ];

    protected $casts = [
        'borrow_date'        => 'date',
        'return_date'        => 'date',
        'actual_return_date' => 'date',
        'fine'               => 'integer',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function laptop() { return $this->belongsTo(Laptop::class); }
    public function logs()   { return $this->hasMany(BorrowingLog::class); }

    public function isLate(): bool
    {
        return $this->status === 'borrowed' && now()->gt($this->return_date);
    }

    /** Jumlah hari keterlambatan (0 jika belum terlambat). */
    public function getLateDaysAttribute(): int
    {
        if (! $this->isLate()) {
            return 0;
        }
        return (int) now()->startOfDay()->diffInDays($this->return_date->startOfDay());
    }

    /** Estimasi denda: Rp 10.000 per hari terlambat. */
    public function getFineEstimateAttribute(): int
    {
        return $this->late_days * 10000;
    }

    /** Denda yang diformat sebagai rupiah (estimasi jika masih dipinjam). */
    public function getFormattedFineAttribute(): string
    {
        $amount = $this->fine > 0 ? $this->fine : $this->fine_estimate;
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    // Scope: filter by day-of-week
    public function scopeOnDay($query, $date) {
        return $query->whereDate('borrow_date', $date)
                     ->orWhereDate('return_date', $date);
    }

    // Helper: group by day name (MySQL only_full_group_by compatible)
    public static function countByDay() {
        return static::selectRaw("DAYNAME(borrow_date) as day, COUNT(*) as total, DAYOFWEEK(borrow_date) as day_num")
            ->groupByRaw("DAYNAME(borrow_date), DAYOFWEEK(borrow_date)")
            ->orderBy("day_num")
            ->get();
    }
}
