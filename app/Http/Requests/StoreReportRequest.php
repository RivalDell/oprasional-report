<?php

namespace App\Http/Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Main Report
            'outlet_id' => 'required|exists:outlets,id',
            'report_date' => 'required|date',
            'shift' => 'nullable|string',
            'is_stock_out' => 'required|boolean',
            'low_stock_items' => 'nullable|string',
            'operation_checks' => 'nullable|array',
            'customer_service' => 'nullable|array',
            'equipment_maintenance' => 'nullable|array',
            'cleaning_hygiene' => 'nullable|array',
            'performance_rating' => 'required|in:Excellent,Good,Average,Below Target',
            'key_achievement' => 'nullable|string',
            'main_problem' => 'nullable|string',
            'action_for_tomorrow' => 'nullable|string',
            'priorities' => 'nullable|array',
            'prepared_by' => 'required|string|max:255',
            'supervisor_name' => 'nullable|string|max:255',
            'store_manager_name' => 'nullable|string|max:255',

            // Sales Finance (One-to-One)
            'sales_finance' => 'required|array',
            'sales_finance.target_sales' => 'required|numeric|min:0',
            'sales_finance.actual_sales' => 'required|numeric|min:0',
            'sales_finance.cash_sales' => 'nullable|numeric|min:0',
            'sales_finance.qris_ewallet' => 'nullable|numeric|min:0',
            'sales_finance.debit_credit_card' => 'nullable|numeric|min:0',
            'sales_finance.online_delivery' => 'nullable|numeric|min:0',
            'sales_finance.transaction_count' => 'required|integer|min:0',
            'sales_finance.cash_in_drawer' => 'nullable|numeric|min:0',
            'sales_finance.cash_variance' => 'nullable|numeric',
            'sales_finance.cash_variance_status' => 'nullable|string',
            'sales_finance.variance_explanation' => 'nullable|string',

            // Dynamic Items Validation (One-to-Many)
            'top_products' => 'nullable|array',
            'top_products.*.product_category' => 'required|string',
            'top_products.*.qty_sold' => 'required|integer|min:0',
            'top_products.*.sales_amount' => 'required|numeric|min:0',

            'attendances' => 'nullable|array',
            'attendances.*.staff_name' => 'required|string',
            'attendances.*.schedule' => 'nullable|string',
            'attendances.*.attendance_status' => 'required|string',
            'attendances.*.late' => 'nullable|string',
            'attendances.*.remarks' => 'nullable|string',

            'action_plans' => 'nullable|array',
            'action_plans.*.issue' => 'required|string',
            'action_plans.*.root_cause' => 'nullable|string',
            'action_plans.*.corrective_action' => 'nullable|string',
            'action_plans.*.pic' => 'nullable|string',
            'action_plans.*.deadline' => 'nullable|date',
        ];
    }
}