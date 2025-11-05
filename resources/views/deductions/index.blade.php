@extends('layouts.fenex')

@section('title', 'Deductions')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="mb-2 mb-md-0">Deductions ({{ $deductions->total() }})</h4>

        <form action="{{ route('deductions.index') }}" method="GET" class="d-flex gap-2 align-items-center mb-2 mb-md-0">

            <select name="hub" id="hubFilter" class="form-select form-select-sm" style="max-width: 120px;">
                <option value="">Hub</option>
                @foreach($hubs as $key => $value)
                    <option value="{{ $key }}" {{ request('hub') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <select name="type" id="typeFilter" class="form-select form-select-sm" style="max-width: 120px;">
                <option value="">Type</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            <select name="year" id="yearFilter" class="form-select form-select-sm" style="max-width: 120px;">
                <option value="">Year</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>

            <select name="month" id="monthFilter" class="form-select form-select-sm" style="max-width: 120px;">
                <option value="">Month</option>
                @foreach($months as $index => $name)
                    <option value="{{ $index }}" {{ request('month') == $index ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
        </form>

        <a href="{{ route('deductions.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-plus-circle"></i> Add New Deduction
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
 
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Photos</th>
                            <th>Hub</th>
                            <th>Type</th>
                            <th>Amount (AED)</th>
                            <th>Details</th>
                            <th>Date</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th class="text-center" style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deductions as $deduction)
                            <tr>
                                <td>
                                    @include('components.photo-display', ['photos' => $deduction->photos])
                                </td>
                                <td>{{ $deduction->hub }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $deduction->type ?? '—')) }}</td>

                                <td class="fw-semibold text-danger">
                                    -{{ number_format($deduction->amount, 2) }}
                                </td>

                                <td>
                                    <span class="details-text" data-fulltext="{{ $deduction->details }}">
                                        {{ Str::limit($deduction->details, 60) }}
                                    </span>
                                    @if(strlen($deduction->details) > 60)
                                        <a href="javascript:void(0);" class="read-more text-primary text-decoration-none ms-1">
                                            Read More
                                        </a>
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($deduction->date)->format('M d, Y') }}</td>
                                <td>{{ $deduction->created_at->format('M d, Y') }}</td>
                                <td>{{ $deduction->updated_at->diffForHumans() }}</td>

                                <td class="text-center">

                                <a href="{{ route('deductions.show', $deduction) }}" class="btn btn-success btn-sm me-1">
                                        <i class="bi bi-eye"></i> Show
                                    </a>

                                    <a href="{{ route('deductions.edit', $deduction) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    

                                    <form action="{{ route('deductions.destroy', $deduction) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this deduction?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No deductions found. <a href="{{ route('deductions.create') }}">Add one now</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $deductions->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
    </div>
</div>

@include('components.photo-modal')
@endsection
