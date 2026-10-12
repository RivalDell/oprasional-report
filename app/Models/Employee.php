<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['outlet_id', 'name', 'position'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}