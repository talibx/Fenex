@extends('layouts.fenex')

@section('title', 'Sales Details')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sales Record Details</h1>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to List
        </a>
    </div>

    {{-- Photos --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <strong>Photos:</strong>
            @if($sale->photos && count($sale->photos) > 0)
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($sale->photos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" 
                             alt="Photo" 
                             class="img-thumbnail" 
                             style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                             onclick="showPhotoModal('{{ asset('storage/' . $photo) }}')">
                    @endforeach
                </div>
            @else
                <p class="text-muted">No photos available</p>
            @endif
        </div>
    </div>

    @include('components.photo-modal')

    {{-- Main Details Card --}}
    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- Date & Hub --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Date</h6>
                    <p class="fs-6">{{ \Carbon\Carbon::parse($sale->date)->format('F d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Hub</h6>
                    <p class="fs-6">{{ $sale->hub }}</p>
                </div>
            </div>

            {{-- Orders / Revenue --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <h6 class="fw-bold text-muted mb-1">Orders Sold</h6>
                    <p class="fs-6 text-success fw-semibold">{{ $sale->order_sold }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold text-muted mb-1">Orders Returned</h6>
                    <p class="fs-6 text-danger fw-semibold">{{ $sale->order_returned }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold text-muted mb-1">Total Revenue (AED)</h6>
                    <p class="fs-6">{{ number_format($sale->total_revenue, 2) }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold text-muted mb-1">Total Cost (AED)</h6>
                    <p class="fs-6">{{ number_format($sale->total_cost, 2) }}</p>
                </div>
            </div>

            {{-- Profit & File --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <h6 class="fw-bold text-muted mb-1">Total Profit (AED)</h6>
                    <p class="fs-5 {{ $sale->total_profit >= 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                        {{ number_format($sale->total_profit, 2) }}
                    </p>
                </div>
                <div class="col-md-8">
                    <h6 class="fw-bold text-muted mb-1">Uploaded File</h6>
                    @if($sale->file_path)
                        <a href="{{ asset('storage/' . $sale->file_path) }}" 
                           target="_blank" 
                           class="text-decoration-none">
                            <i class="bi bi-file-earmark-arrow-down"></i> View or Download File
                        </a>
                    @else
                        <p class="text-muted">No file uploaded.</p>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="mb-3">
                <h6 class="fw-bold text-muted mb-1">Details</h6>
                <div class="border rounded p-3 bg-light">
                    @if($sale->details)
                        <p class="mb-0">{{ $sale->details }}</p>
                    @else
                        <p class="text-muted mb-0">No details available for this record.</p>
                    @endif
                </div>
            </div>

            <hr>

            {{-- Meta Info --}}
            <div class="row text-muted small mt-3">
                <div class="col-md-6">
                    <p class="mb-0">Created: {{ $sale->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Last Updated: {{ $sale->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>

        <form action="{{ route('sales.destroy', $sale) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this record?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection
