@extends('layouts.fenex')

@section('title', 'Add Transaction')

@section('content')
<div class="container py-4">
    <h4>Add New Transaction</h4>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="source" class="form-label fw-semibold">Sales Source</label>
            <select name="source" id="source" class="form-select" required>
                @foreach($sources as $key => $value)
                    <option value="{{ $key }}" {{ old('source') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="">Select Type</option>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label fw-semibold">Details</label>
            <textarea
                class="form-control"
                id="details"s
                name="details"
                rows="5"
                placeholder="Write your details here..."
                required>{{ old('details') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (AED)</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save Transaction</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection