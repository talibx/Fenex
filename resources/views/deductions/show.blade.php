@extends('layouts.fenex')

@section('title', 'Deduction Details')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Deduction Details</h1>
        <a href="{{ route('deductions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Back to List
        </a>
    </div>
 
    <div class="row mb-3">
        <div class="col-md-12">
            <strong>Photos:</strong>
            @if($deduction->photos && count($deduction->photos) > 0)
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($deduction->photos as $photo)
                        <img src="{{ asset('storage/app/public/' . $photo) }}" 
                            alt="Photo" 
                            class="img-thumbnail" 
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                            onclick="showPhotoModal('{{ asset('storage/app/public/' . $photo) }}')">
                    @endforeach
                </div>
            @else
                <p class="text-muted">No photos available</p>
            @endif
        </div>
    </div>

@include('components.photo-modal')

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Type</h6>
                    <p class="fs-6">{{ ucwords(str_replace('_', ' ', $deduction->type ?? '—')) }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold text-muted mb-1">Amount (AED)</h6>
                    <p class="fs-5 text-danger fw-bold">
                        -{{ number_format($deduction->amount, 2) }}
                    </p>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold text-muted mb-1">Hub</h6>
                    <p class="fs-6">{{ $deduction->hub }}</p>
                </div>
            </div>

            

            <div class="mb-3">
                <h6 class="fw-bold text-muted mb-1">Date</h6>
                <p class="fs-6">{{ \Carbon\Carbon::parse($deduction->date)->format('M d, Y') }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-muted mb-1">Details</h6>
                <div class="border rounded p-3 bg-light">
                    @if($deduction->details)
                        <p class="mb-0">{{ $deduction->details }}</p>
                    @else
                        <p class="text-muted mb-0">No details provided.</p>
                    @endif
                </div>
            </div>

            <hr>

            <div class="row text-muted small mt-3">
                <div class="col-md-6">
                    <p class="mb-0">Created: {{ $deduction->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Last Updated: {{ $deduction->updated_at->diffForHumans() }}</p>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('deductions.edit', $deduction) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>

        <form action="{{ route('deductions.destroy', $deduction) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this deduction?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection
