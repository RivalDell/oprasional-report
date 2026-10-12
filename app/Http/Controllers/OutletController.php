<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::withCount('employees')->latest()->paginate(10);
        return view('outlets.index', compact('outlets'));
    }

    public function create()
    {
        return view('outlets.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50|unique:outlets,code',
        'target_sales' => 'required|numeric|min:0',
        'target_transactions' => 'required|integer|min:0',
        'target_sales_weekend' => 'nullable|numeric|min:0',
        'target_transactions_weekend' => 'nullable|integer|min:0',
        'employees' => 'nullable|array',
    ]);

    $code = $request->code ?: 'OUT-' . strtoupper(Str::random(5));

    $outlet = Outlet::create([
        'code' => $code,
        'name' => $request->name,
        'address' => $request->address,
        'target_sales' => $request->target_sales,
        'target_transactions' => $request->target_transactions,
        'target_sales_weekend' => $request->target_sales_weekend ?: $request->target_sales,
        'target_transactions_weekend' => $request->target_transactions_weekend ?: $request->target_transactions,
    ]);

    if ($request->has('employees')) {
        foreach ($request->employees as $empData) {
            if (!empty($empData['name'])) {
                $outlet->employees()->create([
                    'name' => $empData['name'],
                    'position' => $empData['position'] ?? 'Crew',
                ]);
            }
        }
    }

    return redirect()->route('outlets.index')->with('success', 'Outlet dan data karyawan berhasil ditambahkan!');
}

    public function edit($id)
    {
        $outlet = Outlet::with('employees')->findOrFail($id);
        return view('outlets.edit', compact('outlet'));
    }

    public function update(Request $request, $id)
{
    $outlet = Outlet::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50|unique:outlets,code,' . $outlet->id,
        'target_sales' => 'required|numeric|min:0',
        'target_transactions' => 'required|integer|min:0',
        'target_sales_weekend' => 'nullable|numeric|min:0',
        'target_transactions_weekend' => 'nullable|integer|min:0',
        'employees' => 'nullable|array',
    ]);

    $code = $request->code ?: ($outlet->code ?: 'OUT-' . strtoupper(Str::random(5)));

    $outlet->update([
        'code' => $code,
        'name' => $request->name,
        'address' => $request->address,
        'target_sales' => $request->target_sales,
        'target_transactions' => $request->target_transactions,
        'target_sales_weekend' => $request->target_sales_weekend ?: $request->target_sales,
        'target_transactions_weekend' => $request->target_transactions_weekend ?: $request->target_transactions,
    ]);

    $outlet->employees()->delete();
    if ($request->has('employees')) {
        foreach ($request->employees as $empData) {
            if (!empty($empData['name'])) {
                $outlet->employees()->create([
                    'name' => $empData['name'],
                    'position' => $empData['position'] ?? 'Crew',
                ]);
            }
        }
    }

    return redirect()->route('outlets.index')->with('success', 'Data outlet berhasil diperbarui!');
}

    public function destroy($id)
    {
        $outlet = Outlet::findOrFail($id);
        $outlet->delete();

        return redirect()->route('outlets.index')->with('success', 'Outlet berhasil dihapus!');
    }

    public function getOutletDetails(Request $request, $id)
{
    $outlet = Outlet::with('employees')->findOrFail($id);
    $date = $request->query('date', date('Y-m-d'));

    // Sertakan target dinamis berdasarkan tanggal
    $responseData = $outlet->toArray();
    $responseData['active_target_sales'] = $outlet->getTargetSalesForDate($date);
    $responseData['active_target_transactions'] = $outlet->getTargetTransactionsForDate($date);

    return response()->json($responseData);
}
}