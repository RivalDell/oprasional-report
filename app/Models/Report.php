<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'report_date',
        'shift',
        'weather',
        'sales_finance',
        'top_products',
        'is_stock_out',
        'low_stock_items',
        'attendances',
        'hygiene',
        'equipment',
        'marketing',
        'action_plans',
        'performance_rating',
        'key_achievement',
        'main_problem',
        'action_for_tomorrow',
        'prepared_by',
        'supervisor_name',
        'store_manager_name',
        'notes',
    ];

    protected $casts = [
        'report_date' => 'date',
        'sales_finance' => 'array',
        'top_products' => 'array',
        'attendances' => 'array',
        'hygiene' => 'array',
        'equipment' => 'array',
        'marketing' => 'array',
        'action_plans' => 'array',
        'is_stock_out' => 'boolean',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}