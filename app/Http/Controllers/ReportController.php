<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('outlet');

        if ($request->filled('outlet_id')) {
            $query->where('outlet_id', $request->outlet_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('report_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->where('report_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->where('report_date', '<=', $request->end_date);
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->shift);
        }

        $reports = $query->latest('report_date')->paginate(10)->withQueryString();
        $outlets = Outlet::all();

        return view('reports.index', compact('reports', 'outlets'));
    }

    public function create()
    {
        $outlets = Outlet::all();
        return view('reports.create', compact('outlets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'outlet_id'          => 'required|exists:outlets,id',
            'report_date'        => 'required|date',
            'shift'              => 'required|string',
            'sales_finance'      => 'required|array',
            'top_products'       => 'nullable|array',
            'is_stock_out'       => 'required|boolean',
            'low_stock_items'    => 'nullable|string',
            'attendances'        => 'nullable|array',
            'action_plans'       => 'nullable|array',
            'performance_rating' => 'required|string',
            'prepared_by'        => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            Report::create([
                'outlet_id'           => $request->outlet_id,
                'report_date'         => $request->report_date,
                'shift'               => $request->shift,
                'sales_finance'       => $request->sales_finance,
                'top_products'        => $request->top_products,
                'is_stock_out'        => $request->is_stock_out,
                'low_stock_items'     => $request->low_stock_items,
                'attendances'         => $request->attendances,
                'action_plans'        => $request->action_plans,
                'performance_rating'  => $request->performance_rating,
                'key_achievement'     => $request->key_achievement,
                'main_problem'        => $request->main_problem,
                'action_for_tomorrow' => $request->action_for_tomorrow,
                'prepared_by'         => $request->prepared_by,
                'supervisor_name'     => $request->supervisor_name,
                'store_manager_name'  => $request->store_manager_name,
            ]);
        });

        return redirect()->route('reports.index')->with('success', 'Laporan harian berhasil disimpan!');
    }

    public function show($id)
    {
        $report = Report::with('outlet')->findOrFail($id);
        return view('reports.show', compact('report'));
    }

    public function edit($id)
{
    $report = Report::findOrFail($id);
    $outlets = Outlet::all();
    
    return view('reports.edit', compact('report', 'outlets'));
}

public function update(Request $request, $id)
{
    $report = Report::findOrFail($id);

    $validated = $request->validate([
        'outlet_id'           => 'required|exists:outlets,id',
        'report_date'         => 'required|date',
        'shift'               => 'required|string',
        'weather'             => 'nullable|string',
        'sales_finance'       => 'required|array',
        'sales_finance.actual_sales'     => 'required|numeric',
        'sales_finance.total_transactions' => 'required|integer',
        'top_products'        => 'nullable|array',
        'is_stock_out'        => 'nullable|boolean',
        'low_stock_items'     => 'nullable|string',
        'attendances'         => 'nullable|array',
        'hygiene'             => 'nullable|array',
        'equipment'           => 'nullable|array',
        'marketing'           => 'nullable|array',
        'action_plans'        => 'nullable|array',
        'performance_rating'  => 'required|string',
        'key_achievement'     => 'nullable|string',
        'main_problem'        => 'nullable|string',
        'action_for_tomorrow' => 'nullable|string',
        'prepared_by'         => 'required|string',
        'supervisor_name'     => 'nullable|string',
        'store_manager_name' => 'nullable|string',
        'notes'               => 'nullable|string',
    ]);

    // Update data laporan di database
    $report->update($validated);

    return redirect()->route('reports.index')->with('success', 'Laporan operasional berhasil diperbarui!');
}

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus!');
    }

    public function exportPdf($id)
{
    $report = Report::with('outlet')->findOrFail($id);

    // Format tanggal laporan secara aman
    $formattedDate = $report->report_date 
        ? Carbon::parse($report->report_date)->translatedFormat('d F Y') 
        : '-';

    $pdf = Pdf::loadView('reports.pdf', compact('report', 'formattedDate'))
        ->setPaper('a4', 'portrait');

    $filename = 'Laporan_Operasional_' . str_replace(' ', '_', $report->outlet->name ?? 'Momoyo') . '_' . date('Ymd_His') . '.pdf';

    return $pdf->download($filename);
}
public function print($id)
{
    $report = Report::with('outlet')->findOrFail($id);

    $formattedDate = $report->report_date 
        ? Carbon::parse($report->report_date)->translatedFormat('d F Y') 
        : '-';

    return view('reports.print', compact('report', 'formattedDate'));
}
}