@extends('layouts.fenex')

@section('title', 'Analytics Overview')

@section('content')
<div class="container-fluid py-4">

    {{-- ======= HEADER & FILTERS ======= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-3 mb-md-0">📊 Business Analytics</h3>

        <div class="text-center mb-2 mb-md-0">
            <form action="{{ route('analytics') }}" method="GET" class="d-flex gap-2 align-items-center mb-3">

                 <select name="hub" id="hubFilter" class="form-select form-select-sm" style="max-width: 120px;">
                    <option value="">Hub</option>
                    @foreach($hubs as $hub)
                        <option value="{{ $hub }}" {{ request('hub') == $hub ? 'selected' : '' }}>
                            {{ $hub }}
                        </option>
                    @endforeach
                </select>


                <select name="year" id="yearFilter" class="form-select form-select-sm" style="max-width: 120px;">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <select name="month" id="monthFilter" class="form-select form-select-sm" style="max-width: 120px;" {{ request('year') ? '' : 'disabled' }}>
                    <option value="">All Months</option>
                    @foreach($months as $index => $name)
                        <option value="{{ $index }}" {{ request('month') == $index ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-filter"></i> Filter
                </button>
                
                @if(request('year') || request('month'))
                    <a href="{{ route('analytics') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                @endif
            </form>

        </div>
    </div>

    {{-- ======= KPI CARDS ======= --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted fw-semibold">Total Revenue</h6>
                    <h4 class="text-success fw-bold mt-2">{{ number_format($totalRevenue, 2) }} AED</h4>
                    <small class="text-muted">Sales across all hubs</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted fw-semibold">Total Cost</h6>
                    <h4 class="text-danger fw-bold mt-2">{{ number_format($totalCost, 2) }} AED</h4>
                    <small class="text-muted">All product costs</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted fw-semibold">Total Profit</h6>
                    <h4 class="{{ $totalProfit >= 0 ? 'text-success' : 'text-danger' }} fw-bold mt-2">
                        {{ number_format($totalProfit, 2) }} AED
                    </h4>
                    <small class="text-muted">Net result (Revenue - Cost)</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted fw-semibold">Total Deductions</h6>
                    <h4 class="text-danger fw-bold mt-2">{{ number_format($totalDeductions, 2) }} AED</h4>
                    <small class="text-muted">Operational expenses</small>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= CHARTS SECTION ======= --}}
    <div class="row g-4">
        {{-- SALES PROFIT LINE CHART --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow"></i> Monthly Profit Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- DEDUCTIONS PIE CHART --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart"></i> Deductions Breakdown</h6>
                </div>
                <div class="card-body">
                    <canvas id="deductionsChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= INVENTORY STATUS ======= --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Inventory Overview</h6>
            <a href="{{ route('inventories.index') }}" class="btn btn-sm btn-outline-secondary">
                View Inventory
            </a>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold text-primary">{{ $totalProducts }}</h5>
                    <small class="text-muted">Total Products</small>
                </div>
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold text-success">{{ $totalStock }}</h5>
                    <small class="text-muted">Total Stock</small>
                </div>
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold text-warning">{{ $lowStock }}</h5>
                    <small class="text-muted">Low Stock</small>
                </div>
                <div class="col-6 col-md-3">
                    <h5 class="fw-bold text-danger">{{ $outOfStock }}</h5>
                    <small class="text-muted">Out of Stock</small>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ======= CHART.JS SCRIPTS ======= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    // ===== SALES PROFIT LINE CHART =====
    const ctx1 = document.getElementById('salesChart');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($chartMonths),
            datasets: [{
                label: 'Profit (AED)',
                data: @json($chartProfits),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40,167,69,0.15)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'AED' } },
                x: { title: { display: true, text: 'Month' } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => `${ctx.parsed.y.toLocaleString()} AED` } }
            }
        }
    });

    // ===== DEDUCTIONS PIE CHART =====
    const ctx2 = document.getElementById('deductionsChart');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: @json($deductionLabels),
            datasets: [{
                label: 'Deductions',
                data: @json($deductionAmounts),
                backgroundColor: [
                    '#ff6384','#36a2eb','#ffce56','#8e44ad','#2ecc71',
                    '#e67e22','#f39c12','#d35400','#1abc9c','#3498db'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed} AED` } }
            }
        }
    });


     // Year-Month filter dependency
    const yearFilter = document.getElementById('yearFilter');
    const monthFilter = document.getElementById('monthFilter');

    // Function to update month filter state
    function updateMonthFilterState() {
        const yearValue = yearFilter.value;
        
        if (!yearValue || yearValue === '') {
            // Disable month filter if year is not selected
            monthFilter.disabled = true;
            monthFilter.value = ''; // Reset month selection
            monthFilter.classList.add('text-muted');
        } else {
            // Enable month filter if year is selected
            monthFilter.disabled = false;
            monthFilter.classList.remove('text-muted');
        }
    }

    // Initialize on page load
    updateMonthFilterState();

    // Update when year changes
    yearFilter.addEventListener('change', function() {
        updateMonthFilterState();
    });

});
</script>
@endsection
