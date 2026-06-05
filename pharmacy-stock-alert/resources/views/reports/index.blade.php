@php
    $pageTitle = 'Reports & Analytics';
    $pageIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="4" y="14" width="4" height="6"/><rect x="10" y="10" width="4" height="10"/><rect x="16" y="4" width="4" height="16"/></svg>';
@endphp

@section('page-icon', $pageIcon)
@section('page-title', $pageTitle)

@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    {{-- Export Button --}}
    <div class="d-flex justify-content-end mb-3" style="animation: fadeIn 0.4s ease;">
        <a href="{{ route('reports.export', ['type' => 'stock_summary']) }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export as PDF
        </a>
    </div>

    <div class="row g-4">
        {{-- Stock Summary Cards --}}
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="4" y="14" width="4" height="6"/><rect x="10" y="10" width="4" height="10"/><rect x="16" y="4" width="4" height="16"/></svg>
                    Stock Summary
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-3 text-center" style="background:var(--primary-50);">
                                <div style="font-size:1.75rem;font-weight:700;color:var(--primary);">{{ $totalMedicines }}</div>
                                <div style="font-size:0.7rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;">Total Medicines</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-3 text-center" style="background:var(--danger-light);">
                                <div style="font-size:1.75rem;font-weight:700;color:var(--danger);">{{ $expiredMedicines }}</div>
                                <div style="font-size:0.7rem;color:var(--danger);text-transform:uppercase;letter-spacing:0.5px;">Expired</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-3 text-center" style="background:var(--warning-light);">
                                <div style="font-size:1.75rem;font-weight:700;color:#d97706;">{{ $expiringSoonMedicines }}</div>
                                <div style="font-size:0.7rem;color:#d97706;text-transform:uppercase;letter-spacing:0.5px;">Expiring Soon</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-3 text-center" style="background:#fef2f2;">
                                <div style="font-size:1.75rem;font-weight:700;color:#b91c1c;">{{ $lowStockMedicines }}</div>
                                <div style="font-size:0.7rem;color:#b91c1c;text-transform:uppercase;letter-spacing:0.5px;">Low Stock</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock Distribution Chart --}}
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Stock Distribution by Range
                </div>
                <div class="card-body">
                    <canvas id="stockRangeChart" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Expiry Forecast Chart --}}
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Expiry Forecast (6 Months)
                </div>
                <div class="card-body">
                    <canvas id="expiryForecastChart" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Top Suppliers --}}
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/></svg>
                    Top Suppliers by Inventory
                </div>
                <div class="card-body">
                    @if($topSuppliers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom">
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th class="text-center">Medicines</th>
                                        <th class="text-end">% Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSuppliers as $supplier)
                                        @php $pct = $totalMedicines > 0 ? round(($supplier->medicines_count / $totalMedicines) * 100, 1) : 0; @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div style="width:32px;height:32px;border-radius:8px;background:var(--primary-50);display:flex;align-items:center;justify-content:center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/></svg>
                                                    </div>
                                                    <strong style="font-size:0.85rem;">{{ $supplier->name }}</strong>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold">{{ $supplier->medicines_count }}</td>
                                            <td class="text-end">
                                                <div class="d-flex align-items-center justify-content-end gap-2">
                                                    <div class="progress" style="width:60px;height:6px;border-radius:3px;">
                                                        <div class="progress-bar" style="width:{{ $pct }}%;background:var(--primary);border-radius:3px;"></div>
                                                    </div>
                                                    <small style="font-size:0.75rem;">{{ $pct }}%</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3" style="font-size:0.85rem;">No suppliers registered yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Alert Summary --}}
        <div class="col-lg-6">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Alert Summary
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="text-center p-3 rounded-3" style="background:var(--danger-light);">
                                <div style="font-size:1.5rem;font-weight:700;color:var(--danger);">{{ $expiredAlertCount }}</div>
                                <div style="font-size:0.65rem;color:var(--danger);text-transform:uppercase;">Expired</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-3 rounded-3" style="background:var(--warning-light);">
                                <div style="font-size:1.5rem;font-weight:700;color:#d97706;">{{ $expiringAlertCount }}</div>
                                <div style="font-size:0.65rem;color:#d97706;text-transform:uppercase;">Expiring</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-3 rounded-3" style="background:#fef2f2;">
                                <div style="font-size:1.5rem;font-weight:700;color:#b91c1c;">{{ $lowStockAlertCount }}</div>
                                <div style="font-size:0.65rem;color:#b91c1c;text-transform:uppercase;">Low Stock</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 rounded-3" style="background:var(--primary-50);">
                                <div style="font-size:1.5rem;font-weight:700;color:var(--primary);">{{ $totalAlerts }}</div>
                                <div style="font-size:0.65rem;color:var(--text-secondary);text-transform:uppercase;">Total Alerts</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 rounded-3" style="background:var(--success-light);">
                                <div style="font-size:1.5rem;font-weight:700;color:var(--success);">{{ $resolvedAlerts }}</div>
                                <div style="font-size:0.65rem;color:var(--success);text-transform:uppercase;">Resolved</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detailed Stock Table --}}
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                    Complete Inventory Report
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Qty</th>
                                    <th>Expiry</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($medicines as $med)
                                    @php
                                        $status = 'good';
                                        $statusLabel = 'In Stock';
                                        if ($med->expiry_date < $today) { $status = 'expired'; $statusLabel = 'Expired'; }
                                        elseif ($med->expiry_date <= $today->copy()->addDays(30)) { $status = 'expiring'; $statusLabel = 'Expiring Soon'; }
                                        elseif ($med->quantity < 10) { $status = 'lowstock'; $statusLabel = 'Low Stock'; }
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong style="font-size:0.85rem;">{{ $med->name }}</strong>
                                            <br><small class="text-muted" style="font-size:0.7rem;">Batch: {{ $med->batch_number }}</small>
                                        </td>
                                        <td style="font-size:0.8rem;">{{ $med->category?->name ?? '—' }}</td>
                                        <td style="font-size:0.8rem;">{{ $med->supplier?->name ?? '—' }}</td>
                                        <td class="text-center fw-bold">{{ $med->quantity }}</td>
                                        <td style="font-size:0.8rem;">{{ $med->expiry_date->format('M d, Y') }}</td>
                                        <td><span class="badge-{{ $status }} badge-status">{{ $statusLabel }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4 text-muted">No medicines registered yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Stock Range Chart
        const stockCtx = document.getElementById('stockRangeChart');
        if (stockCtx) {
            new Chart(stockCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($stockRanges)) !!},
                    datasets: [{
                        label: 'Medicines',
                        data: {!! json_encode(array_values($stockRanges)) !!},
                        backgroundColor: ['#2563eb', '#8b5cf6', '#f59e0b', '#f97316', '#dc2626'],
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // Expiry Forecast Chart
        const expiryCtx = document.getElementById('expiryForecastChart');
        if (expiryCtx) {
            new Chart(expiryCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($expiryForecast, 'label')) !!},
                    datasets: [{
                        label: 'Expiring',
                        data: {!! json_encode(array_column($expiryForecast, 'count')) !!},
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#f59e0b',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
