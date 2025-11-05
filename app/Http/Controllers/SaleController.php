<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Year;
use App\Models\Month;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // require auth, remove if not needed
    }

public function index(Request $request)
{
    // Validate optional filter input
    $request->validate([
        'year' => 'nullable|integer',
        'month' => 'nullable|integer|min:1|max:12',
    ]);

    // Base query with relationships - explicitly exclude soft-deleted records
    $query = Sale::with(['year', 'month', 'user'])
                 ->whereNull('deleted_at'); // Explicitly exclude soft-deleted records

    // Apply filters
    if ($request->filled('year')) {
        // Filter by selected year (matching Year model's year field)
        $query->whereHas('year', function ($q) use ($request) {
            $q->where('year', $request->input('year'));
        });
    }

    if ($request->filled('month')) {
        // Filter by selected month number (1–12)
        $query->whereHas('month', function ($q) use ($request) {
            $q->where('number', $request->input('month'));
        });
    }

    if ($request->filled('hub')) {
        $query->where('hub', $request->input('hub'));
    }

    // Sort newest first (by year then month)
    $sales = $query->orderByDesc('year_id')
                   ->orderByDesc('month_id')
                   ->paginate(20)
                   ->withQueryString();

    // Filter dropdowns
    $years = Year::orderByDesc('year')->pluck('year');
    $months = Month::orderBy('number')->pluck('name_en', 'number');
    $hubs = Sale::getHubs(); // Get from model

    return view('sales.index', compact('sales', 'years', 'months','hubs'));
}


    public function create()
    {
        // provide data for selects (years/months) in view
        $years = Year::orderByDesc('id')->get();
        $months = Month::orderBy('id')->get();
         $hubs = Sale::getHubs(); // Get from model

        return view('sales.create', compact('years','months','hubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year_id' => 'required|exists:years,id',
            'month_id' => 'required|exists:months,id',
            'hub' => 'required|in:amazon.ae,amazon.sa,noon,local,other',
            'file' => 'nullable|file|mimes:xlsx,xls,csv',
            'order_sold' => 'nullable|integer|min:0',
            'order_returned' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'total_profit' => 'nullable|numeric',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ ADD THIS
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('sales_uploads');
            $data['file_path'] = $path;
        }

        // ✅ Handle multiple photo uploads
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('sale_photos', 'public');
                $photoPaths[] = $path;
            }
            $data['photos'] = $photoPaths;
        }

        $data['user_id'] = auth()->id();
        $data['order_sold'] = $data['order_sold'] ?? 0;
        $data['order_returned'] = $data['order_returned'] ?? 0;
        $data['total_revenue'] = $data['total_revenue'] ?? 0;
        $data['total_cost'] = $data['total_cost'] ?? 0;
        // If profit not provided, compute it
        if (!isset($data['total_profit'])) {
            $data['total_profit'] = ($data['total_revenue'] ?? 0) - ($data['total_cost'] ?? 0);
        }

        Sale::create($data);

        return redirect()->route('sales.index')->with('success', 'Sale month record created');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale->load(['year','month','user'])]);
    }

    public function edit(Sale $sale)
    {
        $years = Year::orderByDesc('id')->get();
        $months = Month::orderBy('id')->get();
         $hubs = Sale::getHubs(); // Get from model

        return view('sales.edit', ['sale' => $sale, 'years' => $years, 'months' => $months, 'hubs' => $hubs]);
    }

        public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'year_id' => 'required|exists:years,id',
            'month_id' => 'required|exists:months,id',
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

        // Handle file upload
        if ($request->hasFile('file')) {
            if ($sale->file_path && Storage::disk('public')->exists($sale->file_path)) {
                Storage::disk('public')->delete($sale->file_path);
            }
            $data['file_path'] = $request->file('file')->store('sale_uploads', 'public');
        }

        // ✅ Handle photos properly
        $existingPhotos = $sale->photos ?? [];

        // Remove photos
        if ($request->has('remove_photos') && is_array($request->remove_photos)) {
            foreach ($request->remove_photos as $photoToRemove) {
                if (($key = array_search($photoToRemove, $existingPhotos)) !== false) {
                    Storage::disk('public')->delete($photoToRemove);
                    unset($existingPhotos[$key]);
                }
            }
            $existingPhotos = array_values($existingPhotos);
        }
 
        // Add new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('sales_photos', 'public');
                $existingPhotos[] = $path;
            }
        }

        $data['photos'] = $existingPhotos;

        // Calculate profit
        if (!isset($data['total_profit'])) {
            $data['total_profit'] = ($data['total_revenue'] ?? $sale->total_revenue ?? 0) 
                                - ($data['total_cost'] ?? $sale->total_cost ?? 0);
        }

        $sale->update($data); 

        return redirect()->route('sales.show', $sale)->with('success', 'Sales month updated');
    }

    public function destroy(Sale $sale)
    {

        // ✅ Delete associated file
        if ($sale->file_path && Storage::disk('public')->exists($sale->file_path)) {
            Storage::disk('public')->delete($sale->file_path);
        }

        // ✅ Delete associated photos
        if ($sale->photos) {
            foreach ($sale->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        // dd($sale);
        // soft delete
        $sale->delete();
        
        return redirect()->route('sales.index')->with('success','Sale record deleted');
    }
}
