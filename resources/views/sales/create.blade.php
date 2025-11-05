@extends('layouts.fenex')

@section('title', 'Add Sales Record')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Add Monthly Sales Record</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following issues:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="year_id" class="form-label fw-semibold">Year</label>
                <select name="year_id" id="year_id" class="form-select" required>
                    <option value="">-- Select Year --</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}" {{ old('year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="month_id" class="form-label fw-semibold">Month</label>
                <select name="month_id" id="month_id" class="form-select" required>
                    <option value="">-- Select Month --</option>
                    @foreach($months as $month)
                        <option value="{{ $month->id }}" {{ old('month_id') == $month->id ? 'selected' : '' }}>
                            {{ $month->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="hub" class="form-label fw-semibold">Sales Hub</label>
            <select name="hub" id="hub" class="form-select" required>
                @foreach($hubs as $key => $value)
                    <option value="{{ $key }}" {{ old('hub') == $key ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label fw-semibold">Upload Excel / CSV <small class="text-muted">(optional)</small></label>
            <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv">
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="order_sold" class="form-label">Orders Sold</label>
                <input type="number" class="form-control" id="order_sold" name="order_sold" value="{{ old('order_sold', 0) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="order_returned" class="form-label">Orders Returned</label>
                <input type="number" class="form-control" id="order_returned" name="order_returned" value="{{ old('order_returned', 0) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="total_revenue" class="form-label">Total Revenue (AED)</label>
                <input type="number" step="0.01" class="form-control" id="total_revenue" name="total_revenue" value="{{ old('total_revenue', 0) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="total_cost" class="form-label">Total Cost (AED)</label>
                <input type="number" step="0.01" class="form-control" id="total_cost" name="total_cost" value="{{ old('total_cost', 0) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="total_profit" class="form-label">Total Profit (AED)</label>
                <input type="number" step="0.01" class="form-control" id="total_profit" name="total_profit" value="{{ old('total_profit', 0) }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label fw-semibold">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3" placeholder="Optional details about this month's sales...">{{ old('details') }}</textarea>
        </div>

        {{-- Photo Upload --}}
            @include('components.photo-upload', ['label' => 'Upload Photos (Receipts, Invoices)'])

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Record
            </button>
        </div>
    </form>
</div>
@include('components.photo-modal')
@endsection
