@extends('layouts.fenex')

@section('title', 'Edit Transaction')

@section('content')
<div class="container py-4">
    <h4>Edit Transaction</h4>
    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="source" class="form-label fw-semibold">Sales Source</label>
            <select name="source" id="source" class="form-select" required>
                @foreach($sources as $key => $value)
                    <option value="{{ $key }}" {{ old('source', $transaction->source ?? '') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="credit" {{ $transaction->type == 'credit' ? 'selected' : '' }}>Credit</option>
                <option value="debit" {{ $transaction->type == 'debit' ? 'selected' : '' }}>Debit</option>
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
                required>{{ $transaction->details }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount (AED)</label>
            <input type="number" name="amount" class="form-control" value="{{ $transaction->amount }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ $transaction->date }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
