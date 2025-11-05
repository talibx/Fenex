<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * style photo support added:
     * - Store multiple photos (array) under 'product_photos' on the public disk.
     * - On update: support removing photos (remove_photos array) and appending new uploads.
     * - On delete: remove all stored photos from public disk.
     *
     * Keep the rest of your product business logic (inventory agg, sorting, pagination).
     */

    public function index(Request $request)
    {
        // Sorting defaults
        $sortBy = $request->get('sort') ?: 'created_at';
        $sortDirection = $request->get('direction') ?: 'asc';

        // Eager load inventories and paginate
        $products = Product::with('inventories')->orderBy($sortBy, $sortDirection)->paginate(100);

        $total_inventory = 0;
        $total_cost = 0;

        foreach ($products as $product) {
            $product_inventory = [
                'new' => 0,
                'used in good condition' => 0,
                'damaged bag' => 0,
                'damaged product' => 0,
                'without bag' => 0,
                'replaced' => 0
            ];

            foreach ($product->inventories as $inventory) {
                // Ensure condition key exists to avoid undefined index errors
                if (!isset($product_inventory[$inventory->condition])) {
                    $product_inventory[$inventory->condition] = 0;
                }
                $product_inventory[$inventory->condition] += $inventory->quantity;

                $total_inventory += $inventory->quantity;
                $total_cost += $inventory->quantity * $inventory->product->cost_of_goods;
            }

            // Attach calculated inventory info for display
            $product->inventory_quantities = $product_inventory;
        }

        return view('products.index', compact('products', 'sortBy', 'sortDirection', 'total_inventory', 'total_cost'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validate inputs and multiple photos (photos.*)
        $request->validate([
            'name' => 'required|string|max:255',
            'cost_of_goods' => 'required|numeric',
            'weight' => 'required|numeric',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->weight = $request->weight;
        $product->cost_of_goods = $request->cost_of_goods;

        // 👇 Handle main photo
        if ($request->hasFile('main_photo')) {
            $product->main_photo = $request->file('main_photo')->store('product_main_photos', 'public');
        }

        // Handle multiple photo uploads (store paths in array)
        if ($request->hasFile('photos')) {
            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('product_photos', 'public'); // stored in storage/app/public/product_photos
                $photoPaths[] = $path;
            }
            // assign photos array to model attribute
            $product->photos = $photoPaths;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        // Load inventories with their hub information
        $product->load('inventories');
        
        // Calculate inventory summary by condition
        $inventoryQuantities = [
            'new' => 0,
            'used in good condition' => 0,
            'damaged bag' => 0,
            'damaged product' => 0,
            'without bag' => 0,
            'replaced' => 0
        ];

        $totalQuantity = 0;
        $totalValue = 0;
        $totalAdded = 0;
        $totalShipped = 0;

        foreach ($product->inventories as $inventory) {
            // Ensure condition key exists to avoid undefined index errors
            if (!isset($inventoryQuantities[$inventory->condition])) {
                $inventoryQuantities[$inventory->condition] = 0;
            }

            $inventoryQuantities[$inventory->condition] += $inventory->quantity;
            
            $totalQuantity += $inventory->quantity;
            $totalValue += $inventory->quantity * $product->cost_of_goods;

            // Count sum of add and shipped 
            if ($inventory->inventory_actions == 'add to inventory') {
                $totalAdded += $inventory->quantity;
            } elseif ($inventory->inventory_actions == 'ship to amazon') {
                $totalShipped +=  $inventory->quantity;
            }



        }

        return view('products.show', compact(
            'product', 
            'inventoryQuantities', 
            'totalQuantity', 
            'totalValue',
            'totalAdded',
            'totalShipped',
        ));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validate new uploads and optional remove_photos array
        $request->validate([
            'name' => 'required|string|max:255',
            'cost_of_goods' => 'required|numeric',
            'weight' => 'required|numeric',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 👈 new
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photos' => 'nullable|array',
        ]);

        // Handle main photo update
        if ($request->hasFile('main_photo')) {
            // Delete old main photo if exists
            if ($product->main_photo) {
                Storage::disk('public')->delete($product->main_photo);
            }
            // Store new one
            $product->main_photo = $request->file('main_photo')->store('product_main_photos', 'public');
        }

        // Start from existing photos (array) or empty array
        $existingPhotos = $product->photos ?? [];

        // Remove photos requested by user
        if ($request->has('remove_photos') && is_array($request->remove_photos)) {
            foreach ($request->remove_photos as $photoToRemove) {
                // photoToRemove expected to be the storage path (e.g. product_photos/xxxxx.jpg)
                if (($key = array_search($photoToRemove, $existingPhotos)) !== false) {
                    // delete file from storage/public
                    Storage::disk('public')->delete($photoToRemove);
                    unset($existingPhotos[$key]);
                }
            }
            // reindex array
            $existingPhotos = array_values($existingPhotos);
        }

        // Add newly uploaded photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('product_photos', 'public');
                $existingPhotos[] = $path;
            }
        }

        // assign updated photos array to product
        $product->photos = $existingPhotos;

        // Update other fields
        $product->name = $request->name;
        $product->weight = $request->weight;
        $product->cost_of_goods = $request->cost_of_goods;

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete all product photos from storage (if any)
        if ($product->photos && is_array($product->photos)) {
            foreach ($product->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        if ($product->main_photo) {
            Storage::disk('public')->delete($product->main_photo);
    }

        // Delete product record
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
