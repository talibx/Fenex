<!-- resources/views/sales/index.blade.php -->
@extends('layouts.fenex')

@section('title', 'Sales Dashboard')

@section('content')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 1.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .stats-card.revenue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stats-card.profit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stats-card.orders {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stats-card.returns {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .stats-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        top: 20px;
    }

    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .table-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .table-card .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .badge-hub {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .hub-amazon-ae { background: #FF9900; color: white; }
    .hub-amazon-sa { background: #146eb4; color: white; }
    .hub-noon { background: #fed402; color: #333; }
    .hub-local { background: #28a745; color: white; }
    .hub-other { background: #6c757d; color: white; }

    .action-btn {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .view-toggle {
        background: white;
        border-radius: 10px;
        padding: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .view-toggle .btn {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .view-toggle .btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    #tableView {
        display: none;
    }

    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
        justify-content: center;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header with View Toggle -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">
            <i class="fas fa-chart-line text-primary"></i> Sales Dashboard
        </h2>
        
        <div class="d-flex gap-3 align-items-center">
            <div class="view-toggle">
                <button class="btn active" onclick="toggleView('chart')" id="chartViewBtn">
                    <i class="fas fa-chart-bar"></i> Charts
                </button>
                <button class="btn" onclick="toggleView('table')" id="tableViewBtn">
                    <i class="fas fa-table"></i> Table
                </button>
            </div>
            
            <a href="{{ route('sales.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Add New Record
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="filter-card">
        <form action="{{ route('sales.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-store"></i> Hub
                </label>
                <select name="hub" class="form-select">
                    <option value="">All Hubs</option>
                    @foreach($hubs as $key => $value)
                        <option value="{{ $key }}" {{ request('hub') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar-alt"></i> Year
                </label>
                <select name="year" id="yearFilter" class="form-select">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar"></i> Month
                </label>
                <select name="month" id="monthFilter" class="form-select" {{ request('year') ? '' : 'disabled' }}>
                    <option value="">All Months</option>
                    @foreach($months as $index => $name)
                        <option value="{{ $index }}" {{ request('month') == $index ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>
                
                @if(request('year') || request('month') || request('hub'))
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Chart View -->
    <div id="chartView">
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card revenue position-relative">
                    <i class="fas fa-dollar-sign stats-icon"></i>
                    <div class="stats-label">Total Revenue</div>
                    <div class="stats-value">{{ number_format($sales->sum('total_revenue'), 2) }} AED</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card profit position-relative">
                    <i class="fas fa-chart-line stats-icon"></i>
                    <div class="stats-label">Total Profit</div>
                    <div class="stats-value">{{ number_format($sales->sum('total_profit'), 2) }} AED</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card orders position-relative">
                    <i class="fas fa-shopping-cart stats-icon"></i>
                    <div class="stats-label">Orders Sold</div>
                    <div class="stats-value">{{ number_format($sales->sum('order_sold')) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card returns position-relative">
                    <i class="fas fa-undo stats-icon"></i>
                    <div class="stats-label">Orders Returned</div>
                    <div class="stats-value">{{ number_format($sales->sum('order_returned')) }}</div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-area text-primary"></i> Revenue & Profit Trend
                    </h5>
                    <canvas id="revenueProfitChart" height="80"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-pie text-primary"></i> Sales by Hub
                    </h5>
                    <canvas id="hubDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row">
            <div class="col-lg-6">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-bar text-primary"></i> Orders Analysis
                    </h5>
                    <canvas id="ordersChart" height="100"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-percentage text-primary"></i> Profit Margin by Month
                    </h5>
                    <canvas id="profitMarginChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView">
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Photos</th>
                            <th>Period</th>
                            <th>Hub</th>
                            <th>Orders</th>
                            <th>Returns</th>
                            <th>Revenue</th>
                            <th>Cost</th>
                            <th>Profit</th>
                            <th>Margin</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>
                                    @include('components.photo-display', ['photos' => $sale->photos])
                                </td>
                                <td>
                                    <strong>{{ $sale->year->year ?? '—' }}</strong><br>
                                    <small class="text-muted">{{ $sale->month->name_en ?? '—' }}</small>
                                </td>
                                <td>
                                    <span class="badge-hub hub-{{ str_replace('.', '-', $sale->hub) }}">
                                        {{ $hubs[$sale->hub] ?? $sale->hub }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success">
                                    <i class="fas fa-shopping-cart"></i> {{ number_format($sale->order_sold) }}
                                </td>
                                <td class="fw-bold text-danger">
                                    <i class="fas fa-undo"></i> {{ number_format($sale->order_returned) }}
                                </td>
                                <td class="fw-semibold">{{ number_format($sale->total_revenue, 2) }} AED</td>
                                <td class="text-muted">{{ number_format($sale->total_cost, 2) }} AED</td>
                                <td class="{{ $sale->total_profit >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($sale->total_profit, 2) }} AED
                                </td>
                                <td>
                                    @php
                                        $margin = $sale->total_revenue > 0 ? ($sale->total_profit / $sale->total_revenue) * 100 : 0;
                                    @endphp
                                    <span class="badge {{ $margin >= 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($margin, 1) }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="details-text" data-fulltext="{{ $sale->details }}">
                                        {{ Str::limit($sale->details, 40) }}
                                    </span>
                                    @if(strlen($sale->details) > 40)
                                        <a href="javascript:void(0);" class="read-more text-primary">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info action-btn" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger action-btn" 
                                                onclick="return confirm('Delete this record?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    No sales records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $sales->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('components.photo-modal')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle between chart and table view
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
        } else {
            chartView.style.display = 'none';
            tableView.style.display = 'block';
            chartBtn.classList.remove('active');
            tableBtn.classList.add('active');
        }
    }

    // Enable month filter when year is selected
    document.getElementById('yearFilter').addEventListener('change', function() {
        document.getElementById('monthFilter').disabled = !this.value;
    });

    // Read more functionality
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.read-more').forEach(link => {
            link.addEventListener('click', function() {
                const detailsSpan = this.previousElementSibling;
                const fullText = detailsSpan.getAttribute('data-fulltext');
                
                if (detailsSpan.textContent.includes('...')) {
                    detailsSpan.textContent = fullText;
                    this.innerHTML = '<i class="fas fa-chevron-up"></i>';
                } else {
                    detailsSpan.textContent = fullText.substring(0, 40) + '...';
                    this.innerHTML = '<i class="fas fa-chevron-down"></i>';
                }
            });
        });
    });

    // Prepare chart data
    const salesData = {!! json_encode($sales->map(function($sale) {
        return [
            'period' => ($sale->year->year ?? '') . ' ' . ($sale->month->name_en ?? ''),
            'revenue' => $sale->total_revenue,
            'profit' => $sale->total_profit,
            'cost' => $sale->total_cost,
            'orders_sold' => $sale->order_sold,
            'orders_returned' => $sale->order_returned,
            'hub' => $sale->hub,
            'profit_margin' => $sale->total_revenue > 0 ? ($sale->total_profit / $sale->total_revenue) * 100 : 0
        ];
    })) !!};

    // Chart 1: Revenue & Profit Trend
    const ctx1 = document.getElementById('revenueProfitChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: salesData.map(d => d.period),
            datasets: [{
                label: 'Revenue',
                data: salesData.map(d => d.revenue),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Profit',
                data: salesData.map(d => d.profit),
                borderColor: '#f5576c',
                backgroundColor: 'rgba(245, 87, 108, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' AED';
                        }
                    }
                }
            }
        }
    });

    // Chart 2: Hub Distribution (Pie)
    const hubData = salesData.reduce((acc, curr) => {
        acc[curr.hub] = (acc[curr.hub] || 0) + curr.revenue;
        return acc;
    }, {});

    const ctx2 = document.getElementById('hubDistributionChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.keys(hubData),
            datasets: [{
                data: Object.values(hubData),
                backgroundColor: [
                    '#FF9900',
                    '#146eb4',
                    '#fed402',
                    '#28a745',
                    '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Chart 3: Orders Analysis
    const ctx3 = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: salesData.map(d => d.period),
            datasets: [{
                label: 'Orders Sold',
                data: salesData.map(d => d.orders_sold),
                backgroundColor: '#4facfe'
            }, {
                label: 'Orders Returned',
                data: salesData.map(d => d.orders_returned),
                backgroundColor: '#f5576c'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // Chart 4: Profit Margin
    const ctx4 = document.getElementById('profitMarginChart').getContext('2d');
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: salesData.map(d => d.period),
            datasets: [{
                label: 'Profit Margin (%)',
                data: salesData.map(d => d.profit_margin),
                backgroundColor: salesData.map(d => d.profit_margin >= 0 ? '#43e97b' : '#f5576c')
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
</script>

@endsection