<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Outlet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $yesterday = Carbon::yesterday();

        // 1. Query Ringkasan Data Operasional Kemarin
        $yesterdayQuery = Report::with('outlet')
            ->whereDate('report_date', $yesterday->toDateString());

        if ($request->filled('outlet_id')) {
            $yesterdayQuery->where('outlet_id', $request->outlet_id);
        }

        $yesterdayReports = $yesterdayQuery->get();

        $totalActualSales = 0;
        $totalTransactions = 0;
        $yesterdayReportCount = $yesterdayReports->count();

        // Akumulasi Actual Sales & Transaksi dari Laporan Kemarin
        foreach ($yesterdayReports as $report) {
            $sales = $report->sales_finance ?? [];
            $totalActualSales += floatval($sales['actual_sales'] ?? 0);
            $totalTransactions += intval($sales['total_transactions'] ?? 0);
        }

        // 2. Hitung Total Target Sales langsung dari Master Data Outlet (dinamis Weekday / Weekend)
        if ($request->filled('outlet_id')) {
            $selectedOutlet = Outlet::find($request->outlet_id);
            $totalTargetSales = $selectedOutlet ? $selectedOutlet->getTargetSalesForDate($yesterday) : 0;
        } else {
            // Penjumlahan target seluruh outlet berdasarkan apakah kemarin hari biasa / akhir pekan
            $allOutlets = Outlet::all();
            $totalTargetSales = $allOutlets->sum(function($outlet) use ($yesterday) {
                return $outlet->getTargetSalesForDate($yesterday);
            });
        }

        // Hitung persentase pencapaian target sales
        $salesAchievementRate = $totalTargetSales > 0 
            ? round(($totalActualSales / $totalTargetSales) * 100, 1) 
            : 0;

        // 3. Query Tabel Rincian Laporan Terbaru (Semua Laporan, Urut Terbaru)
        $latestReportsQuery = Report::with('outlet')->latest();

        if ($request->filled('outlet_id')) {
            $latestReportsQuery->where('outlet_id', $request->outlet_id);
        }

        $latestReports = $latestReportsQuery->paginate(10)->withQueryString();

        // 4. Alert Operasional (Stock Out & Performa Below Target)
        $stockOutAlerts = Report::with('outlet')
            ->where('is_stock_out', true)
            ->latest()
            ->take(4)
            ->get();

        $belowTargetAlerts = Report::with('outlet')
            ->where('performance_rating', 'Below Target')
            ->latest()
            ->take(4)
            ->get();

        // 5. Data Master Outlet
        $outlets = Outlet::all();
        $totalOutlets = $outlets->count();

        return view('dashboard', compact(
            'yesterday',
            'totalActualSales',
            'totalTargetSales',
            'totalTransactions',
            'yesterdayReportCount',
            'salesAchievementRate',
            'latestReports',
            'stockOutAlerts',
            'belowTargetAlerts',
            'outlets',
            'totalOutlets'
        ));
    }
}