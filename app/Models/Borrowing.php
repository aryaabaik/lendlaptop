<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id','laptop_id','borrower_name',
        'borrow_date','return_date','purpose',
        'status','admin_note'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function laptop() { return $this->belongsTo(Laptop::class); }
    public function logs()   { return $this->hasMany(BorrowingLog::class); }

    public function isLate() {
        return $this->status === 'borrowed' && now()->gt($this->return_date);
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
