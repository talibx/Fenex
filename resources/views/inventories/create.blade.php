@extends('layouts.fenex')
@section('title', 'Add an Inventory')
@section('content')
<div class="container py-4">
    <h1>Add New Inventory Item</h1>
    <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product Name</label>
            <select class="form-select" id="product_id" name="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="mb-3">
            <label for="condition" class="form-label">Condition</label>
            <select class="form-select" id="condition" name="condition" required>
                <option value="new">New</option>
                <option value="used in good condition">Used in Good Condition</option>
                <option value="damaged product">Damaged Product</option>
                <option value="damaged bag">Damaged Bag</option>
                <option value="without bag">Without Bag</option>
                <option value="replaced">Replaced</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="condition" class="form-label">Inventory Actions</label>
            <select class="form-select" id="inventory_actions" name="inventory_actions" required>
                <option value="add to inventory">Add to Inventory</option>
                <option value="ship to amazon">Ship to Amazon</option>
            </select>
        </div>

        @include('components.photo-upload', ['label' => 'Upload Photos (Receipts, Bills)'])

        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3" placeholder="Type the details"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Inventory Item</button>
    </form>
</div>
@include('components.photo-modal')
@endsection
