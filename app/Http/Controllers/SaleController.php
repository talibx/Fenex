<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Validate filters
        $request->validate([
            'year' => 'nullable|integer',
            'month' => 'nullable|integer|min:1|max:12',
            'hub' => 'nullable|string',
        ]);

        $query = Sale::with('user')->whereNull('deleted_at');

        // ✅ Filter by year (derived from date)
        if ($request->filled('year')) {
            $query->whereYear('date', $request->input('year'));
        }

        // ✅ Filter by month (derived from date)
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->input('month'));
        }

        // ✅ Filter by hub if provided
        if ($request->filled('hub')) {
            $query->where('hub', $request->input('hub'));
        }

        // ✅ Order by date (newest first)
        $sales = $query->orderByDesc('date')
                       ->paginate(20)
                       ->withQueryString();

        $years = Sale::getYears();
        $months = Sale::getMonths();
        $hubs = Sale::getHubs();

        return view('sales.index', compact('sales', 'years', 'months', 'hubs'));
    }

    public function create()
    {
        $hubs = Sale::getHubs();
        return view('sales.create', compact('hubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'hub' => 'required|in:amazon.ae,amazon.sa,noon,local,other',
            'file' => 'nullable|file|mimes:xlsx,xls,csv',
            'order_sold' => 'nullable|integer|min:0',
            'order_returned' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'total_profit' => 'nullable|numeric',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('sales_uploads', 'public');
        }

        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $photoPaths[] = $photo->store('sale_photos', 'public');
            }
            $data['photos'] = $photoPaths;
        }

        $data['user_id'] = auth()->id();
        $data['order_sold'] = $data['order_sold'] ?? 0;
        $data['order_returned'] = $data['order_returned'] ?? 0;
        $data['total_revenue'] = $data['total_revenue'] ?? 0;
        $data['total_cost'] = $data['total_cost'] ?? 0;
        $data['total_profit'] = $data['total_profit'] ?? ($data['total_revenue'] - $data['total_cost']);

        Sale::create($data);

        return redirect()->route('sales.index')->with('success', 'Sale record created successfully.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $hubs = Sale::getHubs();
        return view('sales.edit', compact('sale', 'hubs'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'hub' => 'required|in:amazon.ae,amazon.sa,noon,local,other',
            'file' => 'nullable|file|mimes:xlsx,xls,csv',
            'order_sold' => 'nullable|integer|min:0',
            'order_returned' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'total_profit' => 'nullable|numeric',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // Handle file replacement
        if ($request->hasFile('file')) {
            if ($sale->file_path && Storage::disk('public')->exists($sale->file_path)) {
                Storage::disk('public')->delete($sale->file_path);
            }
            $data['file_path'] = $request->file('file')->store('sales_uploads', 'public');
        }

        // Handle photos
        $existingPhotos = $sale->photos ?? [];

        if ($request->filled('remove_photos')) {
            foreach ($request->remove_photos as $photo) {
                if (in_array($photo, $existingPhotos)) {
                    Storage::disk('public')->delete($photo);
                    $existingPhotos = array_diff($existingPhotos, [$photo]);
                }
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $existingPhotos[] = $photo->store('sale_photos', 'public');
            }
        }

        $data['photos'] = array_values($existingPhotos);

        // Recalculate profit if missing
        $data['total_profit'] = $data['total_profit']
            ?? ($data['total_revenue'] ?? $sale->total_revenue ?? 0)
             - ($data['total_cost'] ?? $sale->total_cost ?? 0);

        $sale->update($data);

        return redirect()->route('sales.show', $sale)->with('success', 'Sale record updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->file_path && Storage::disk('public')->exists($sale->file_path)) {
            Storage::disk('public')->delete($sale->file_path);
        }

        if ($sale->photos) {
            foreach ($sale->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale record deleted successfully.');
    }
}
