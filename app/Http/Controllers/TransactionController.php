<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
   public function index(Request $request)
{
    $query = Transaction::query();

    if ($request->filled('source')) {
        $query->where('source', $request->source);
    }
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    if ($request->filled('month')) {
        $query->whereMonth('date', $request->month);
    }
    if ($request->filled('year')) {
        $query->whereYear('date', $request->year);
    }

    $transactions = $query->orderBy('date', 'desc')->paginate(10);

    // Summary values
    $totalCredits = (clone $query)->where('type', 'credit')->sum('amount');
    $totalDebits = (clone $query)->where('type', 'debit')->sum('amount');
    $net = $totalCredits - $totalDebits;
    $count = (clone $query)->count();

    // Chart data — e.g. monthly totals for current year (or filtered year)
    $year = $request->input('year') ?? date('Y');
    $months = collect(range(1,12))->mapWithKeys(function($m){
        return [ $m => 0 ];
    })->toArray();

    $chartData = Transaction::selectRaw('MONTH(date) as month, type, SUM(amount) as total')
        ->when($request->filled('source'), fn($q) => $q->where('source', $request->source))
        ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
        ->when($request->filled('year'), fn($q) => $q->whereYear('date', $request->year))
        ->groupBy('month', 'type')
        ->orderBy('month')
        ->get();

    $chartByMonth = [];
    foreach ($chartData as $row) {
        $m = (int)$row->month;
        $type = $row->type;
        $chartByMonth[$m][$type] = $row->total;
    }

    // Build arrays for Chart.js
    $dataCredits = [];
    $dataDebits = [];
    foreach (range(1,12) as $m) {
        $dataCredits[] = $chartByMonth[$m]['credit'] ?? 0;
        $dataDebits[] = $chartByMonth[$m]['debit'] ?? 0;
    }

    // Pass filter lists as before (sources, months, years)
    $sources = Transaction::select('source')->distinct()->pluck('source');
    $years = Transaction::selectRaw('YEAR(date) as year')->distinct()->pluck('year');
    $months = [
      1=>'January',2=>'February',3=>'March',4=>'April',
      5=>'May',6=>'June',7=>'July',8=>'August',
      9=>'September',10=>'October',11=>'November',12=>'December',
    ];

    return view('transactions.index', compact(
        'transactions', 'sources', 'years', 'months',
        'totalCredits', 'totalDebits', 'net', 'count',
        'dataCredits', 'dataDebits'
    ));
}


    public function create()
    {

        $sources = Transaction::getSources(); // Get from model
        return view('transactions.create', compact('sources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'details' => 'nullable',

        ]);

        $transaction = Transaction::create($validated);

        return redirect()->route('transactions.show', $transaction->id)
                         ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $sources = Transaction::getSources(); // Get from model
        return view('transactions.edit', compact('transaction','sources'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'details' => 'nullable',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.show', $transaction->id)
                         ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
