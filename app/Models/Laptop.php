<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $fillable = ['brand', 'model', 'status', 'category_id'];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isAvailable()
    {
        return $this->status === 'tersedia';
    }

    public function getFullNameAttribute()
    {
        return $this->brand . ' ' . $this->model;
    }

    public function getFormattedIdAttribute()
    {
        return 'LP' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
