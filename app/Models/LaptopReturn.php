<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopReturn extends Model
{
    protected $table = 'returns';
    protected $fillable = ['borrowing_id', 'condition_after', 'fine', 'note'];
    public function borrowing() { return $this->belongsTo(Borrowing::class); }
}
