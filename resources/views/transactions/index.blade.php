@extends('layouts.fenex')

@section('title', 'Transactions')

@section('content')
    <div class="container-fluid py-4">
        <!-- ✅ Filter Form -->
        <div class="row">
                <form method="GET" action="{{ route('transactions.index') }}" class="mb-4 bg-light p-3 rounded">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Source</label>
                            <select name="source" class="form-select">
                                <option value="">All Sources</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source }}"
                                        {{ request('source') == $source ? 'selected' : '' }}>{{ $source }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                                <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Year</label>
                            <select id="yearFilter" name="year" class="form-select">
                                <option value="">All</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Month</label>
                            <select id="monthFilter" name="month" class="form-select">
                                <option value="">All</option>
                                @foreach ($months as $num => $name)
                                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 text-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Transactions ({{ $transactions->total() }})</h4>
            <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-success">
                <i class="bi bi-plus-circle"></i> Add Transaction
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-success mb-2">
                    <div class="card-body">
                        <h5>Total Credits</h5>
                        <h3>{{ number_format($totalCredits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-2">
                    <div class="card-body">
                        <h5>Total Debits</h5>
                        <h3>{{ number_format($totalDebits, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-2">
                    <div class="card-body">
                        <h5>Net</h5>
                        <h3>{{ number_format($net, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-light mb-2">
                    <div class="card-body">
                        <h5>Transactions Count</h5>
                        <h3>{{ $count }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Canvas -->
        <div class="card mb-4">
            <div class="card-body">
                <canvas id="transactionsChart" height="100"></canvas>
            </div>
        </div>




        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- ✅ Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Source</th>
                            <th>Type</th>
                            <th>Details</th>
                            <th>Amount (AED)</th>
                            <th>Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->source }}</td>
                                <td>
                                    <span class="badge {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $transaction->type }}
                                    </span>
                                </td>
                                <td>{{ $transaction->details }}</td>
                                <td>{{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('transactions.edit', $transaction) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this transaction?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $transactions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('transactionsChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(array_values($months)),
                    datasets: [{
                            label: 'Credits',
                            data: @json($dataCredits),
                            backgroundColor: 'rgba(75, 192, 192, 0.7)'
                        },
                        {
                            label: 'Debits',
                            data: @json($dataDebits),
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: false
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (AED)'
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection
