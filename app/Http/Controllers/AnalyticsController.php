<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Deduction;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Month;
use App\Models\Year;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // ===== Filters =====
        $yearFilter = $request->input('year');
        $monthFilter = $request->input('month');

        // ===== Base Query for Sales =====
        $salesQuery = Sale::query();
        $deductionQuery = Deduction::query();

        if ($request->filled('hub')) {
            $salesQuery->where('hub', $request->input('hub'));
            $deductionQuery->where('hub', $request->input('hub'));
        }

        // Apply filters if selected
        if ($yearFilter) {
            $salesQuery->whereHas('year', fn($q) => $q->where('year', $yearFilter));
            $deductionQuery->whereYear('date', $yearFilter);
        }
        if ($monthFilter) {
            $salesQuery->whereHas('month', fn($q) => $q->where('number', $monthFilter));
            $deductionQuery->whereMonth('date', $monthFilter);
        }

        // ===== Totals =====
        $totalRevenue = $salesQuery->sum('total_revenue');
        $totalCost = $salesQuery->sum('total_cost');
        $totalProfit = $salesQuery->sum('total_profit');
        $totalDeductions = $deductionQuery->sum('amount');

            

        // ===== Inventory Stats =====
        $totalProducts = Product::count();
        $totalStock = Inventory::sum('quantity');
        $lowStock = Inventory::where('quantity', '<=', 5)->count();
        $outOfStock = Inventory::where('quantity', '<=', 0)->count();

        // ===== Chart: Monthly Profit Line =====
        $months = Month::orderBy('number')->pluck('name_en', 'number');
        $chartMonths = [];
        $chartProfits = [];

        foreach ($months as $num => $name) {
            $profit = Sale::whereHas('month', fn($q) => $q->where('number', $num))
                ->when($yearFilter, fn($q) => $q->whereHas('year', fn($y) => $y->where('year', $yearFilter)))
                ->sum('total_profit');

            $chartMonths[] = substr($name, 0, 3);
            $chartProfits[] = $profit;
        }

        // ===== Chart: Deductions Breakdown (Pie Chart) =====
        $deductionBreakdown = Deduction::select('type', DB::raw('SUM(amount) as total'))
            ->when($yearFilter, fn($q) => $q->whereYear('date', $yearFilter))
            ->when($monthFilter, fn($q) => $q->whereMonth('date', $monthFilter))
            ->groupBy('type')
            ->get();

        $deductionLabels = $deductionBreakdown->pluck('type')->map(fn($t) => ucwords(str_replace('_', ' ', $t)));
        $deductionAmounts = $deductionBreakdown->pluck('total');

        // ===== Year & Month Filter Options =====
        $years = Year::orderByDesc('year')->pluck('year');
        $monthsArray = $months;

        $hubs = Sale::getHubs(); // Get from model
        

        // ===== Return View =====
        return view('analytics', [
            'years' => $years,
            'months' => $monthsArray,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit,
            'totalDeductions' => $totalDeductions,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
            'chartMonths' => $chartMonths,
            'chartProfits' => $chartProfits,
            'deductionLabels' => $deductionLabels,
            'deductionAmounts' => $deductionAmounts,
            'hubs' => $hubs,
        ]);
    }
}
