<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Month;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Support\Facades\Storage;


class DeductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

public function index(Request $request)
{
    // Build base query
    $query = Deduction::query();

    // Apply filters when provided
    // 'year' is expected like 2024, 'month' as number 1..12 (string from select)
    if ($request->filled('year')) {
        // Where the YEAR part of `date` equals selected year
        $query->whereYear('date', $request->input('year'));
    }

    if ($request->filled('month')) {
        // Where the MONTH part of `date` equals selected month number
        $query->whereMonth('date', $request->input('month'));
    }

    if ($request->filled('type')) {
        $query->where('type', $request->input('type'));
    }

    if ($request->filled('hub')) {
        $query->where('hub', $request->input('hub'));
    }

    // ordering + pagination
    $deductions = $query->orderByDesc('date')->paginate(20)->withQueryString();

    // ===== Year & Month Filter Options =====
    $years = Year::orderByDesc('year')->pluck('year');

    // ===== Month lookup (number => name) =====
    $months = Month::orderBy('number')->pluck('name_en', 'number');

    $types = Deduction::getTypes(); // Get from model
    $hubs = Deduction::getHubs(); // Get from model

    return view('deductions.index', compact('deductions','years','months','types','hubs'));
}

    public function create()
    {
        $types = Deduction::getTypes(); // Get from model
    $hubs = Deduction::getHubs(); // Get from model

        return view('deductions.create', compact('types','hubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'nullable|in:shipping,vat,printing,packaging,domain_hosting,license_fees,bank_fees,purchases,returns,refund,tools_materials,operation,misc',
            'hub' => 'required|in:amazon.ae,amazon.sa,noon,local,other',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
            'date' => 'required|date',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ ADD THIS
        ]);

        // ✅ Handle multiple photo uploads
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('deduction_photos', 'public');
                $photoPaths[] = $path;
            }
            $data['photos'] = $photoPaths;
        }

        Deduction::create($data);

        return redirect()->route('deductions.index')->with('success', 'Deduction added successfully.');
    }

    public function show(Deduction $deduction)
    {
        return view('deductions.show', compact('deduction'));
    }

    public function edit(Deduction $deduction)
    {
        
        $types = Deduction::getTypes(); // Get from model
        $hubs = Deduction::getHubs(); // Get from model



        return view('deductions.edit', compact('deduction', 'types','hubs'));
    }
 
        public function update(Request $request, Deduction $deduction)
    {
        $data = $request->validate([
            'hub' => 'required|in:amazon.ae,amazon.sa,noon,local,other',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
            'date' => 'required|date',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // Start with existing photos
        $existingPhotos = $deduction->photos ?? [];

        // ✅ STEP 1: Handle photo removal FIRST
        if ($request->has('remove_photos') && is_array($request->remove_photos)) {
            foreach ($request->remove_photos as $photoToRemove) {
                // Find and remove from array
                if (($key = array_search($photoToRemove, $existingPhotos)) !== false) {
                    Storage::disk('public')->delete($photoToRemove);
                    unset($existingPhotos[$key]);
                }
            }
            // Re-index array to remove gaps
            $existingPhotos = array_values($existingPhotos);
        }

        // ✅ STEP 2: Add new photos to the existing array
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('deduction_photos', 'public');
                $existingPhotos[] = $path; // Add to array
            }
        }

        // ✅ STEP 3: Set the final photos array
        $data['photos'] = $existingPhotos;

        // Update the deduction
        $deduction->update($data);

        return redirect()->route('deductions.index')->with('success', 'Deduction updated successfully');
    }

    public function destroy(Deduction $deduction)
    {
        // dd($deduction);

         // ✅ Delete associated photos
        if ($deduction->photos) {
            foreach ($deduction->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $deduction->delete();
        return redirect()->route('deductions.index')->with('success', 'Deduction deleted.');
    }
}
