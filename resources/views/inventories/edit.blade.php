@extends('layouts.fenex')
@section('title', 'Edit an Inventory')
@section('content')
<div class="container py-4">
    <h1>Edit Inventory Item</h1>
    <form action="{{ route('inventories.update', $inventory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="product_id" class="form-label">Product Name</label>
            <select class="form-select" id="product_id" name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $inventory->product_id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $inventory->quantity }}" required>
        </div>
        <div class="mb-3">
            <label for="condition" class="form-label">Condition</label>
            <select class="form-select" id="condition" name="condition" required>
                <option value="new" {{ $inventory->condition == 'new' ? 'selected' : '' }}>New</option>
                <option value="used in good condition" {{ $inventory->condition == 'used in good condition' ? 'selected' : '' }}>Used in Good Condition</option>
                <option value="damaged product" {{ $inventory->condition == 'damaged product' ? 'selected' : '' }}>Damaged Product</option>
                <option value="damaged bag" {{ $inventory->condition == 'damaged bag' ? 'selected' : '' }}>Damaged Bag</option>
                <option value="without bag" {{ $inventory->condition == 'without bag' ? 'selected' : '' }}>Without Bag</option>
                <option value="replaced" {{ $inventory->condition == 'replaced' ? 'selected' : '' }}>Replaced</option>
            </select>
        </div>

        
        <div class="mb-3">
            <label for="condition" class="form-label">Inventory Actions</label>
            <select class="form-select" id="inventory_actions" name="inventory_actions" required>
                <option value="add to inventory" {{ $inventory->inventory_actions == 'add to inventory' ? 'selected' : '' }}>Add to Inventory</option>
                <option value="ship to amazon" {{ $inventory->inventory_actions == 'ship to amazon' ? 'selected' : '' }}>Ship to Amazon</option>
            </select>
        </div>



        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3">{{ $inventory->details }}</textarea>
        </div>

        @include('components.photo-edit', ['photos' => $inventory->photos])
        @include('components.photo-upload', ['label' => 'Add More Photos'])

        <button type="submit" class="btn btn-primary">Update Inventory Item</button>
    </form>
</div>
@include('components.photo-modal')
@endsection
