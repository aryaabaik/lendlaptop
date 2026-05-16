<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $fillable = [
    'category_id','code','brand','model','processor',
    'ram','storage','vga','serial_number',
    'condition','status','image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function isAvailable()
    {
        return $this->status === 'tersedia';
    }
}
