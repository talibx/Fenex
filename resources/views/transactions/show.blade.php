@extends('layouts.fenex')

@section('title', 'Transaction Details')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">Transaction Details</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Transaction ID</th>
                    <td>{{ $transaction->id }}</td>
                </tr>
                <tr>
                    <th>Hub</th>
                    <td>{{ $transaction->source }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <span class="badge {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                            {{ $transaction->type }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Amount (AED)</th>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Details</th>
                    <td>{{ $transaction->details }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $transaction->date }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $transaction->updated_at->diffForHumans() }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
