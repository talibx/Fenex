<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Deduction;
use App\Models\Product;
use App\Models\Inventory;
use Carbon\Carbon;
use DB;

    class AnalyticsController extends Controller
    {
        public function index(Request $request)
        {
            // ===== Filters =====
            $yearFilter = $request->input('year');
            $monthFilter = $request->input('month');
            $hubFilter = $request->input('hub');
    
            // ===== Base Query for Sales =====
            $salesQuery = Sale::query();
            $deductionQuery = Deduction::query();
    
            if ($hubFilter) {
                $salesQuery->where('hub', $hubFilter);
                $deductionQuery->where('hub', $hubFilter);
            }
    
            if ($yearFilter) {
                $salesQuery->whereYear('date', $yearFilter);
                $deductionQuery->whereYear('date', $yearFilter);
            }
    
            if ($monthFilter) {
                $salesQuery->whereMonth('date', $monthFilter);
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
    
            // ===== Chart 1: Monthly Profit Line =====
            $salesByMonth = Sale::select(
                    DB::raw('MONTH(date) as month'),
                    DB::raw('SUM(total_profit) as total_profit')
                )
                ->when($yearFilter, fn($q) => $q->whereYear('date', $yearFilter))
                ->groupBy(DB::raw('MONTH(date)'))
                ->orderBy(DB::raw('MONTH(date)'))
                ->get();
    
            $chartMonths = $salesByMonth->pluck('month')->map(fn($m) => Carbon::create()->month($m)->format('M'));
            $chartProfits = $salesByMonth->pluck('total_profit');
    
            // ===== Chart 2: Deductions Breakdown (Pie) =====
            $deductionBreakdown = Deduction::select('type', DB::raw('SUM(amount) as total'))
                ->when($yearFilter, fn($q) => $q->whereYear('date', $yearFilter))
                ->when($monthFilter, fn($q) => $q->whereMonth('date', $monthFilter))
                ->groupBy('type')
                ->get();
    
            $deductionLabels = $deductionBreakdown->pluck('type')
                ->map(fn($t) => ucwords(str_replace('_', ' ', $t)));
            $deductionAmounts = $deductionBreakdown->pluck('total');
    
            // ===== Filters Data =====
            $years = Sale::selectRaw('DISTINCT YEAR(date) as year')
                ->orderByDesc('year')
                ->pluck('year');
    
            $months = collect(range(1, 12))->mapWithKeys(function ($num) {
                return [$num => Carbon::create()->month($num)->format('F')];
            });
    
            $hubs = Sale::select('hub')->distinct()->pluck('hub');
    
            // ===== Return View =====
            return view('analytics', [
                'years' => $years,
                'months' => $months,
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
    
