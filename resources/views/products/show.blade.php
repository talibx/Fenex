@extends('layouts.fenex')

@section('title', $product->name ?? 'Product Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $product->name }}</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <div class="row">
        {{-- Left Column: Product Summary & Photos --}}
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Product Summary</h5>
                    
                    {{-- Main Photo --}}
                    @if($product->main_photo)
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/app/public/' . $product->main_photo) }}"
                                alt="{{ $product->name }}"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 300px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <strong>Cost of Goods:</strong>
                                <span>{{ number_format($product->cost_of_goods, 2) }} AED</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <strong>Weight:</strong>
                                <span>{{ number_format($product->weight, 2) }} KG</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2 {{ ($totalQuantity < 0) ? 'text-danger' : '' }}">
                                <strong>Total Inventory:</strong>
                                <span class="fw-bold">{{ $totalQuantity }} units</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <strong>Total Value:</strong>
                                <span class="fw-bold text-primary">{{ number_format($totalValue, 2) }} AED</span>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory by Condition --}}
                    <div class="mt-4">
                        <h6 class="card-title">Inventory by Condition</h6>
                        @if($totalQuantity > 0)
                            <div class="list-group list-group-flush small">
                                @foreach($inventoryQuantities as $condition => $quantity)
                                    @if($quantity > 0)
                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-capitalize">{{ $condition }}</span>
                                            <span class="badge bg-primary rounded-pill">{{ $quantity }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @elseif($totalQuantity < 0)
                            <p class="mb-0 text-danger">The inventory is Negative, There is an Error.</p>
                        @else
                            <p class="text-muted mb-0">No inventory available.</p>
                        @endif
                    </div>

                    {{-- Additional Photos --}}
                    @if($product->photos && count($product->photos) > 0)
                        <div class="mt-4">
                            <h6 class="card-title">Additional Photos</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->photos as $photo)
                                    <img src="{{ asset('storage/app/public/' . $photo) }}"
                                         alt="Product Photo"
                                         class="img-thumbnail"
                                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                         onclick="showPhotoModal('{{ asset('storage/app/public/' . $photo) }}')">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Product
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product? This will remove all its photos from storage.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="bi bi-trash"></i> Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Inventory Records --}}
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Inventory Records</h5>
                    <p class="text-muted small mb-0"><b>Total:</b> {{ $product->inventories->count() }} records | <b class="text-success">Total Addedd : </b> {{ $totalAdded }} | <b class="text-danger"> Total Shipped : </b> {{ $totalShipped }} </p>
                </div>
                <div class="card-body">
                    @if($product->inventories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Photos</th>
                                        <th width="120">Action</th>
                                        <th width="100">Condition</th>
                                        <th width="80">Qty</th>
                                        <th width="100">Value</th>
                                        <th>Details</th>
                                        <th width="140">Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->inventories as $inventory)
                                        <tr class="{{ $inventory->inventory_actions == 'add to inventory' ? 'table-success' : 'table-danger' }}">
                                            <td>
                                                @include('components.photo-display', ['photos' => $inventory->photos])
                                            </td>
                                            <td>
                                                <small class="fw-bold text-capitalize">
                                                    {{ str_replace('_', ' ', $inventory->inventory_actions ?? 'other') }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary text-capitalize">
                                                    {{ $inventory->condition }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">{{ $inventory->quantity }}</td>
                                            <td class="text-nowrap">
                                                {{ number_format($inventory->quantity * $product->cost_of_goods, 0) }} AED
                                            </td>
                                            <td>
                                                @if($inventory->details)
                                                    <span class="small" data-bs-toggle="tooltip" title="{{ $inventory->details }}">
                                                        {{ Str::limit($inventory->details, 30) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="small text-muted">
                                                {{ $inventory->updated_at->format('M j, Y') }}<br>
                                                <small>{{ $inventory->updated_at->format('H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">No inventory records found for this product.</p>
                            <a href="#" class="btn btn-primary">Add First Inventory</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.photo-modal')

<style>
    .card {
        border: none;
        border-radius: 12px;
    }
    .table td {
        vertical-align: middle;
    }
    .list-group-item {
        border: none;
        padding-left: 0;
        padding-right: 0;
    }
    .img-thumbnail {
        transition: transform 0.2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.05);
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection