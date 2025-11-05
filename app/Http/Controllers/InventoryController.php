<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort') ?: 'created_at';
        $sortDirection = $request->get('direction') ?: 'desc';

        $inventories = Inventory::with('product')
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        $products = Product::with('inventories')->get();
        $total_inventory = 0;
        $total_cost = 0;

        foreach ($products as $product) {
            foreach ($product->inventories as $p_inventory) {
                $total_inventory += $p_inventory->quantity;
                $total_cost += $p_inventory->quantity * $p_inventory->product->cost_of_goods;
            }
        }

        return view('inventories.index', compact('inventories', 'sortBy', 'sortDirection', 'products', 'total_inventory', 'total_cost'));
    }

    public function create()
    {
        $products = Product::all();
        return view('inventories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'condition' => 'required|in:new,used in good condition,damaged product,damaged bag,without bag,replaced',
            'inventory_actions' => 'required|in:add to inventory,ship to amazon',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ✅ Handle photo uploads AFTER validation
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('inventory_photos', 'public');
                $photoPaths[] = $path;
            }
            $data['photos'] = $photoPaths;
        }

        // Modify the quantity if the action is 'ship to amazon'
        if ($request->inventory_actions == 'ship to amazon') {
            $data['quantity'] = $request->quantity * -1;
        }

        // Create the inventory record
        Inventory::create($data);

        return redirect()->route('inventories.index')->with('success', 'Inventory item added successfully.');
    }

    public function show(Inventory $inventory)
    {
        // Load the product relationship
        $inventory->load('product');
        
        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        return view('inventories.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'condition' => 'required|in:new,used in good condition,damaged product,damaged bag,without bag,replaced',
            'inventory_actions' => 'required|in:add to inventory,ship to amazon',
            'details' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // Modify quantity for ship to amazon
        if ($request->inventory_actions == 'ship to amazon') {
            $data['quantity'] = $request->quantity * -1;
        }

        // ✅ Handle photos properly
        $existingPhotos = $inventory->photos ?? [];

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
                $path = $photo->store('inventory_photos', 'public');
                $existingPhotos[] = $path;
            }
        }

        $data['photos'] = $existingPhotos;

        $inventory->update($data);

        return redirect()->route('inventories.index')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        // Delete associated photos
        if ($inventory->photos) {
            foreach ($inventory->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }
        
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Inventory item deleted successfully.');
    }
}