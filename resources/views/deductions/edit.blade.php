@extends('layouts.fenex')

@section('title', 'Edit Deduction')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Edit Deduction</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <form action="{{ route('deductions.update', $deduction) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="type" class="form-label fw-semibold">Deduction Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="">-- Select Type --</option>
                    @foreach([
                        'shipping',
                        'vat',
                        'printing',
                        'packaging',
                        'domain_hosting',
                        'license_fees',
                        'bank_fees',
                        'purchases',
                        'returns',
                        'refund',
                        'tools_materials',
                        'operation',
                        'misc'
                    ] as $option)
                        <option value="{{ $option }}" 
                            {{ old('type', $deduction->type) == $option ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $option)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="amount" class="form-label fw-semibold">Amount (AED)</label>
                <input 
                    type="number" 
                    step="0.01" 
                    class="form-control" 
                    id="amount" 
                    name="amount" 
                    value="{{ old('amount', $deduction->amount) }}" 
                    required>
            </div>
        </div>

         <div class="mb-3">
            <label for="hub" class="form-label fw-semibold">Deduction Hub</label>
            <select name="hub" id="hub" class="form-select" required>
                @foreach($hubs as $key => $value)
                    <option value="{{ $key }}" {{ old('hub', $deduction->hub ?? '') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label fw-semibold">Date</label>
            <input 
                type="date" 
                class="form-control" 
                id="date" 
                name="date" 
                value="{{ old('date', $deduction->date->format('Y-m-d')) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label fw-semibold">details <small class="text-muted">(optional)</small></label>
            <textarea 
                class="form-control" 
                id="details" 
                name="details" 
                rows="3">{{ old('details', $deduction->details) }}</textarea>
        </div>

        @include('components.photo-edit', ['photos' => $deduction->photos])
        @include('components.photo-upload', ['label' => 'Add More Photos'])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('deductions.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Deduction
            </button>
        </div>
    </form>
</div>
@include('components.photo-modal')
@endsection
