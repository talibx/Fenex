@extends('layouts.fenex')

@section('title', 'Analytics Overview')

@section('content')
<style>
    /* ===== KPI CARDS ===== */
    .stats-card {
        border-radius: 15px;
        padding: 1.2rem;
        color: white;
        position: relative;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .stats-card.revenue { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); }
    .stats-card.cost { background: linear-gradient(135deg,#f093fb 0%,#f5576c 100%); }
    .stats-card.profit { background: linear-gradient(135deg,#4facfe 0%,#00f2fe 100%); }
    .stats-card.deductions { background: linear-gradient(135deg,#43e97b 0%,#38f9d7 100%); }

    .stats-label { font-size: 0.9rem; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px; }
    .stats-value { font-size: 1.8rem; font-weight: 700; margin-top: 0.5rem; }

    /* ===== CHART CARDS ===== */
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .chart-card h5 { font-weight: 600; margin-bottom: 1rem; }
    .chart-card {
    position: relative;
    width: 100%;
    height: 350px; /* fixed height to prevent infinite resize */
    margin-bottom: 2rem;
}
@media (max-width: 768px) {
    .chart-card {
        height: 300px; /* slightly shorter for mobile */
    }
}
    
</style>

<div class="container-fluid py-4">

    <!-- HEADER + FILTERS -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <i class="fas fa-chart-line text-primary"></i> Business Analytics
        </h2>

        <form action="{{ route('analytics') }}" method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="hub" class="form-select form-select-sm" style="max-width: 120px;">
                <option value="">Hub</option>
                @foreach($hubs as $hub)
                    <option value="{{ $hub }}" {{ request('hub')==$hub?'selected':'' }}>{{ $hub }}</option>
                @endforeach
            </select>

            <select name="year" id="yearFilter" class="form-select form-select-sm" style="max-width:120px;">
                <option value="">All Years</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year')==$year?'selected':'' }}>{{ $year }}</option>
                @endforeach
            </select>

            <select name="month" id="monthFilter" class="form-select form-select-sm" style="max-width:120px;" {{ request('year')?'':'disabled' }}>
                <option value="">All Months</option>
                @foreach($months as $num=>$name)
                    <option value="{{ $num }}" {{ request('month')==$num?'selected':'' }}>{{ $name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>

            @if(request('hub') || request('year') || request('month'))
                <a href="{{ route('analytics') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    <!-- KPI CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stats-card revenue text-white text-center">
                <div class="stats-label">Total Revenue</div>
                <div class="stats-value">{{ number_format($totalRevenue,2) }} AED</div>
                <small>All hubs</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card cost text-white text-center">
                <div class="stats-label">Total Cost</div>
                <div class="stats-value">{{ number_format($totalCost,2) }} AED</div>
                <small>All products</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card profit text-white text-center">
                <div class="stats-label">Total Profit</div>
                <div class="stats-value">{{ number_format($totalProfit,2) }} AED</div>
                <small>Revenue - Cost</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card deductions text-white text-center">
                <div class="stats-label">Total Deductions</div>
                <div class="stats-value">{{ number_format($totalDeductions,2) }} AED</div>
                <small>Operational expenses</small>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="chart-card">
                <h5><i class="fas fa-chart-line text-primary"></i> Monthly Profit Trend</h5>
                <canvas id="profitChart" height="100"></canvas>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="chart-card">
                <h5><i class="fas fa-chart-pie text-primary"></i> Deductions Breakdown</h5>
                <canvas id="deductionsChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- INVENTORY OVERVIEW -->
    <div class="row mt-4 g-3">
        <div class="col-12 col-md-3">
            <div class="stats-card revenue text-center">
                <div class="stats-label">Total Products</div>
                <div class="stats-value">{{ $totalProducts }}</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stats-card profit text-center">
                <div class="stats-label">Total Stock</div>
                <div class="stats-value">{{ $totalStock }}</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stats-card cost text-center">
                <div class="stats-label">Low Stock</div>
                <div class="stats-value">{{ $lowStock }}</div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="stats-card deductions text-center">
                <div class="stats-label">Out of Stock</div>
                <div class="stats-value">{{ $outOfStock }}</div>
            </div>
        </div>
    </div>

</div>

<!-- CHARTS.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Profit Line Chart
    new Chart(document.getElementById('profitChart').getContext('2d'), {
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
            maintainAspectRatio: false,
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

    // Deductions Pie Chart
    new Chart(document.getElementById('deductionsChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: @json($deductionLabels),
            datasets: [{
                label: 'Deductions',
                data: @json($deductionAmounts),
                backgroundColor: [
                    '#FF6384','#36A2EB','#FFCE56','#8E44AD','#2ECC71',
                    '#E67E22','#F39C12','#D35400','#1ABC9C','#3498DB'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed} AED` } }
            }
        }
    });

    // Enable month filter only if year selected
    const yearFilter = document.getElementById('yearFilter');
    const monthFilter = document.getElementById('monthFilter');

    function updateMonthState() {
        if (!yearFilter.value) {
            monthFilter.disabled = true;
            monthFilter.value = '';
        } else {
            monthFilter.disabled = false;
        }
    }
    updateMonthState();
    yearFilter.addEventListener('change', updateMonthState);

});
</script>
@endsection
