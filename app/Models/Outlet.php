<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'target_sales',
        'target_transactions',
        'target_sales_weekend',
        'target_transactions_weekend',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Helper untuk mengambil Target Sales sesuai Tanggal (Weekday / Weekend)
    public function getTargetSalesForDate($date = null)
    {
        $carbonDate = $date ? Carbon::parse($date) : Carbon::today();
        
        // Jika hari Sabtu (6) atau Minggu (0) dan target weekend diisi
        if ($carbonDate->isWeekend() && !empty($this->target_sales_weekend) && $this->target_sales_weekend > 0) {
            return floatval($this->target_sales_weekend);
        }

        return floatval($this->target_sales);
    }

    // Helper untuk mengambil Target Transaksi sesuai Tanggal (Weekday / Weekend)
    public function getTargetTransactionsForDate($date = null)
    {
        $carbonDate = $date ? Carbon::parse($date) : Carbon::today();

        if ($carbonDate->isWeekend() && !empty($this->target_transactions_weekend) && $this->target_transactions_weekend > 0) {
            return intval($this->target_transactions_weekend);
        }

        return intval($this->target_transactions);
    }
}