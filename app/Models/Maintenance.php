<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['laptop_id', 'issue', 'repair_cost', 'status'];

    public function laptop() { return $this->belongsTo(Laptop::class); }
}
