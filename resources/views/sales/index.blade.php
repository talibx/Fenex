<!-- resources/views/sales/index.blade.php -->
@extends('layouts.fenex')

@section('title', 'Sales Dashboard')

@section('content')
<style>
    /* Mobile-first base styles */
    :root {
        --card-radius: 12px;
        --card-padding: 1rem;
        --muted: #6c757d;
    }

    .stats-card {
        border-radius: var(--card-radius);
        padding: var(--card-padding);
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .stats-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }

    .stats-card.revenue { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); }
    .stats-card.profit  { background: linear-gradient(135deg,#f093fb 0%,#f5576c 100%); }
    .stats-card.orders  { background: linear-gradient(135deg,#4facfe 0%,#00f2fe 100%); color:#042a3a; }
    .stats-card.returns { background: linear-gradient(135deg,#43e97b 0%,#38f9d7 100%); color:#042a3a; }

    .stats-label { font-size: .7rem; text-transform:uppercase; opacity:.95; letter-spacing:.6px; }
    .stats-value { font-size: 1.5rem; font-weight:700; margin-top:.3rem; }

    .stats-icon { position:absolute; right:12px; top:12px; font-size:2.2rem; opacity:.18; }

    .filter-card, .chart-container, .table-card {
        background: #fff;
        border-radius: var(--card-radius);
        padding: var(--card-padding);
        box-shadow: 0 6px 18px rgba(15, 15, 15, 0.06);
        margin-bottom: 1rem;
    }

    /* Table header style */
    .table thead th {
        background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
        color: #fff;
        font-weight:600;
        border: none;
        font-size:.78rem;
        letter-spacing:.4px;
    }

    .badge-hub {
        padding: .35rem .7rem;
        border-radius: 999px;
        font-weight:600;
        font-size:.78rem;
        display:inline-block;
    }
    .hub-amazon-ae { background: #FF9900; color: white; }
    .hub-amazon-sa { background: #146eb4; color: white; }
    .hub-noon      { background: #fed402; color: #333; }
    .hub-local     { background: #28a745; color: white; }
    .hub-other     { background: #6c757d; color: white; }

    .view-toggle { display:flex; gap:.4rem; align-items:center; }
    .view-toggle .btn { border-radius:10px; padding:.4rem .9rem; font-weight:600; font-size:.85rem; }
    .view-toggle .btn.active { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:#fff; }

    /* read-more */
    .read-more { cursor:pointer; margin-left:.35rem; font-weight:700; font-size:.9rem; }

    /* responsive layout tweaks */
    @media (min-width: 768px) {
        .stats-card { margin-bottom: 0; }
    }

    /* Chart containers - ensure mobile-friendly heights */
    canvas { max-width:100%; }

    /* small utilities */
    .muted-small { color: var(--muted); font-size:.85rem; }
    .ellipsis { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display:inline-block; max-width:200px; vertical-align: middle; }

    /* ensure table on small screens is easy to read */
    .table-responsive { overflow-x:auto; -webkit-overflow-scrolling: touch; }

    /* pagination center */
    .pagination { justify-content:center; }

    /* action buttons spacing on small screens */
    .action-btn { margin-right:.25rem; }

    /* placeholder when no records */
    .no-records { padding:2.5rem 0; color: var(--muted); text-align:center; }
    .chart-container {
    position: relative;
    width: 100%;
    height: 350px; /* fixed height to prevent infinite resize */
    margin-bottom: 2rem;
}
@media (max-width: 768px) {
    .chart-container {
        height: 300px; /* slightly shorter for mobile */
    }
}
</style>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-column flex-md-row">
        <div>
            <h2 class="mb-1 fw-bold"><i class="fas fa-chart-line text-primary"></i> Sales Dashboard</h2>
            <p class="muted-small mb-0">Overview of sales, profits and orders. Choose a date to show monthly or daily records.</p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <div class="view-toggle" role="tablist" aria-label="Toggle view">
                <button id="chartViewBtn" class="btn active" type="button" onclick="toggleView('chart')" aria-pressed="true">
                    <i class="fas fa-chart-bar"></i> Charts
                </button>
                <button id="tableViewBtn" class="btn" type="button" onclick="toggleView('table')" aria-pressed="false">
                    <i class="fas fa-table"></i> Table
                </button>
            </div>

            <a href="{{ route('sales.create') }}" class="btn btn-success d-flex align-items-center">
                <i class="fas fa-plus-circle me-2"></i> Add Record
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="filter-card">
        <form action="{{ route('sales.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-sm-6 col-md-3">
                <label class="form-label fw-semibold"><i class="fas fa-store"></i> Hub</label>
                <select name="hub" class="form-select" aria-label="Filter by hub">
                    <option value="">All Hubs</option>
                    @foreach($hubs as $key => $value)
                        <option value="{{ $key }}" {{ request('hub') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-sm-4 col-md-3">
                <label class="form-label fw-semibold"><i class="fas fa-calendar-alt"></i> Year</label>
                <select name="year" id="yearFilter" class="form-select" aria-label="Filter by year">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ (string)request('year') === (string)$year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-sm-4 col-md-2">
                <label class="form-label fw-semibold"><i class="fas fa-calendar"></i> Month</label>
                <select name="month" id="monthFilter" class="form-select" aria-label="Filter by month" {{ request('year') ? '' : 'disabled' }}>
                    <option value="">All Months</option>
                    @foreach($months as $index => $name)
                        <option value="{{ $index }}" {{ (string)request('month') === (string)$index ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-sm-6 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Apply Filters
                </button>
                @if(request('year') || request('month') || request('hub'))
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Chart View -->
    <div id="chartView">
        <!-- Stats cards -->
        <div class="row g-3 mb-3">
            <div class="col-6 col-sm-6 col-md-3">
                <div class="stats-card revenue">
                    <div class="stats-label">Total Revenue</div>
                    <div class="stats-value">{{ number_format($sales->sum('total_revenue') ?? 0, 2) }} AED</div>
                    <div class="stats-icon"><i class="fas fa-dollar-sign"></i></div>
                </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
                <div class="stats-card profit">
                    <div class="stats-label">Total Profit</div>
                    <div class="stats-value">{{ number_format($sales->sum('total_profit') ?? 0, 2) }} AED</div>
                    <div class="stats-icon"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
                <div class="stats-card orders">
                    <div class="stats-label">Orders Sold</div>
                    <div class="stats-value">{{ number_format($sales->sum('order_sold') ?? 0) }}</div>
                    <div class="stats-icon"><i class="fas fa-shopping-cart"></i></div>
                </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
                <div class="stats-card returns">
                    <div class="stats-label">Orders Returned</div>
                    <div class="stats-value">{{ number_format($sales->sum('order_returned') ?? 0) }}</div>
                    <div class="stats-icon"><i class="fas fa-undo"></i></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-3">
            <div class="col-12 col-lg-8">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3"><i class="fas fa-chart-area text-primary"></i> Revenue & Profit Trend</h5>
                    <canvas id="revenueProfitChart" height="120" aria-label="Revenue and profit trend chart"></canvas>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3"><i class="fas fa-chart-pie text-primary"></i> Sales by Hub</h5>
                    <canvas id="hubDistributionChart" height="220" aria-label="Sales by hub chart"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-lg-6">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3"><i class="fas fa-chart-bar text-primary"></i> Orders Analysis</h5>
                    <canvas id="ordersChart" height="140" aria-label="Orders sold vs returned chart"></canvas>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3"><i class="fas fa-percentage text-primary"></i> Profit Margin by Period</h5>
                    <canvas id="profitMarginChart" height="140" aria-label="Profit margin chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" style="display:none;">
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:90px">Photos</th>
                            <th>Period / Date</th>
                            <th>Hub</th>
                            <th>Orders</th>
                            <th>Returns</th>
                            <th>Revenue</th>
                            <th>Cost</th>
                            <th>Profit</th>
                            <th>Margin</th>
                            <th>Details</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="align-middle">
                                    @include('components.photo-display', ['photos' => $sale->photos, 'thumb' => true])
                                </td>

                                <td class="align-middle">
                                    <strong>{{ \Carbon\Carbon::parse($sale->date)->format('F Y') }}</strong><br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</small>
                                </td>

                                <td class="align-middle">
                                    <span class="badge-hub hub-{{ str_replace('.', '-', $sale->hub) }}">
                                        {{ $hubs[$sale->hub] ?? $sale->hub }}
                                    </span>
                                </td>

                                <td class="align-middle text-success fw-bold">
                                    <i class="fas fa-shopping-cart"></i> {{ number_format($sale->order_sold ?? 0) }}
                                </td>

                                <td class="align-middle text-danger fw-bold">
                                    <i class="fas fa-undo"></i> {{ number_format($sale->order_returned ?? 0) }}
                                </td>

                                <td class="align-middle fw-semibold">{{ number_format($sale->total_revenue ?? 0, 2) }} AED</td>

                                <td class="align-middle text-muted">{{ number_format($sale->total_cost ?? 0, 2) }} AED</td>

                                <td class="align-middle {{ ($sale->total_profit ?? 0) >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($sale->total_profit ?? 0, 2) }} AED
                                </td>

                                <td class="align-middle">
                                    @php
                                        $margin = ($sale->total_revenue > 0) ? (($sale->total_profit ?? 0) / $sale->total_revenue) * 100 : 0;
                                    @endphp
                                    <span class="badge {{ $margin >= 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($margin, 1) }}%
                                    </span>
                                </td>

                                <td class="align-middle">
                                    @if($sale->details)
                                        <span class="ellipsis details-short" data-fulltext="{{ $sale->details }}">
                                            {{ \Illuminate\Support\Str::limit($sale->details, 40) }}
                                        </span>
                                        @if(strlen($sale->details) > 40)
                                            <a class="read-more text-primary" title="Read more"><i class="fas fa-chevron-down"></i></a>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info action-btn" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger action-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="no-records">
                                    <i class="fas fa-inbox fa-3x mb-2"></i>
                                    <div>No sales records found.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $sales->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('components.photo-modal')

<!-- Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- UI toggles ---
    function toggleView(view) {
        const chartView = document.getElementById('chartView');
        const tableView = document.getElementById('tableView');
        const chartBtn = document.getElementById('chartViewBtn');
        const tableBtn = document.getElementById('tableViewBtn');

        if (view === 'chart') {
            chartView.style.display = 'block';
            tableView.style.display = 'none';
            chartBtn.classList.add('active');
            tableBtn.classList.remove('active');
            chartBtn.setAttribute('aria-pressed', 'true');
            tableBtn.setAttribute('aria-pressed', 'false');
        } else {
            chartView.style.display = 'none';
            tableView.style.display = 'block';
            chartBtn.classList.remove('active');
            tableBtn.classList.add('active');
            chartBtn.setAttribute('aria-pressed', 'false');
            tableBtn.setAttribute('aria-pressed', 'true');
        }
    }

    // Enable month select only when year selected
    document.getElementById('yearFilter').addEventListener('change', function() {
        document.getElementById('monthFilter').disabled = !this.value;
    });

    // Read more toggle for details
    document.addEventListener('click', function(e){
        if (e.target.closest('.read-more')) {
            const btn = e.target.closest('.read-more');
            const short = btn.previousElementSibling;
            const full = short.getAttribute('data-fulltext') || '';
            if (short.textContent.endsWith('...')) {
                short.textContent = full;
                btn.innerHTML = '<i class="fas fa-chevron-up"></i>';
            } else {
                short.textContent = full.substring(0, 40) + '...';
                btn.innerHTML = '<i class="fas fa-chevron-down"></i>';
            }
        }
    });

    // --- Prepare chart data from server-side $sales ---
    const salesData = {!! json_encode($sales->map(function($sale){
        return [
            'period' => \Carbon\Carbon::parse($sale->date)->format('M Y'),
            'labelDate' => \Carbon\Carbon::parse($sale->date)->format('YYYY-MM-DD'), // for possible future use
            'revenue' => (float) ($sale->total_revenue ?? 0),
            'profit' => (float) ($sale->total_profit ?? 0),
            'cost' => (float) ($sale->total_cost ?? 0),
            'orders_sold' => (int) ($sale->order_sold ?? 0),
            'orders_returned' => (int) ($sale->order_returned ?? 0),
            'hub' => $sale->hub ?? '',
            'profit_margin' => ($sale->total_revenue > 0) ? ((($sale->total_profit ?? 0) / $sale->total_revenue) * 100) : 0
        ];
    })) !!};

    // Defensive: if no data, show empty arrays
    const labels = salesData.map(d => d.period);
    const revenues = salesData.map(d => d.revenue);
    const profits = salesData.map(d => d.profit);
    const costs = salesData.map(d => d.cost);
    const ordersSold = salesData.map(d => d.orders_sold);
    const ordersReturned = salesData.map(d => d.orders_returned);
    const margins = salesData.map(d => Number(d.profit_margin.toFixed(2)));

    // Chart 1: Revenue & Profit (line)
    (function(){
        const ctx = document.getElementById('revenueProfitChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Revenue (AED)',
                        data: revenues,
                        borderColor: '#667eea',
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Profit (AED)',
                        data: profits,
                        borderColor: '#f5576c',
                        tension: 0.35,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(v){ return v.toLocaleString() + ' AED'; }
                        }
                    }
                }
            }
        });
    })();

    // Chart 2: Hub Distribution (doughnut)
    (function(){
        const hubAgg = salesData.reduce((acc, cur) => {
            acc[cur.hub] = (acc[cur.hub] || 0) + cur.revenue;
            return acc;
        }, {});
        const hubLabels = Object.keys(hubAgg);
        const hubValues = Object.values(hubAgg);

        const ctx = document.getElementById('hubDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: hubLabels,
                datasets: [{
                    data: hubValues,
                    backgroundColor: ['#FF9900','#146eb4','#fed402','#28a745','#6c757d']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    })();

    // Chart 3: Orders (bar)
    (function(){
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    { label: 'Orders Sold', data: ordersSold, backgroundColor: '#4facfe' },
                    { label: 'Orders Returned', data: ordersReturned, backgroundColor: '#f5576c' }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } }
            }
        });
    })();

    // Chart 4: Profit Margin (bar)
    (function(){
        const ctx = document.getElementById('profitMarginChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Profit Margin (%)',
                    data: margins,
                    backgroundColor: margins.map(m => m >= 0 ? '#43e97b' : '#f5576c')
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        ticks: { callback: function(v){ return v + '%'; } }
                    }
                }
            }
        });
    })();
</script>
@endsection
