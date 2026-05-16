<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
    'user_id','laptop_id','borrow_date','return_date',
    'actual_return_date','purpose','status','admin_note'
    ];

    protected $casts = [
        'borrow_date'        => 'date',
        'return_date'        => 'date',
        'actual_return_date' => 'date',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function laptop()  { return $this->belongsTo(Laptop::class); }
    public function logs()    { return $this->hasMany(BorrowingLog::class); }
    public function return()  { return $this->hasOne(LaptopReturn::class); }

    public function isLate()
    {
        return $this->status === 'borrowed' && now()->gt($this->return_date);
    }
}
