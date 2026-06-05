@extends('layouts.app')

@section('title', 'Dashboard - Pharmacy Stock Alert System')
@section('page-title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Real-time pharmacy inventory overview &amp; stock insights</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('medicines.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Medicine
        </a>
        <a href="{{ route('alerts.generate') }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg> Scan Alerts
        </a>
        <a href="{{ route('medicines.index') }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg> View Inventory
        </a>
    </div>
</div>

<!-- ==============================
     KPI CARDS
     ============================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(37,99,235,0.12);color:#2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                    </div>
                    <span class="stat-trend neutral">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg> {{ $totalMedicines }}
                    </span>
                </div>
                <div class="stat-label">Total Medicines</div>
                <div class="stat-value" style="color:#1d4ed8;">{{ $totalMedicines }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(22,163,74,0.12);color:#16a34a;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <span class="stat-trend up">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg> {{ $inStockMedicines }}
                    </span>
                </div>
                <div class="stat-label">In Stock</div>
                <div class="stat-value" style="color:#15803d;">{{ $inStockMedicines }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#fffbeb,#fef3c7);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(245,158,11,0.12);color:#d97706;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <span class="stat-trend down">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5"/><line x1="21" y1="12" x2="9" y2="12"/></svg> {{ $expiringSoonMedicines }}
                    </span>
                </div>
                <div class="stat-label">Expiring Soon</div>
                <div class="stat-value" style="color:#b45309;">{{ $expiringSoonMedicines }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#fdf2f8,#fce7f3);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(225,29,72,0.12);color:#e11d48;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M12 3c-1.5 0-3 .6-4.2 1.7C6.6 5.8 6 7.3 6 8.5c0 1.2.6 2.7 1.8 3.8 1.2 1.1 2.7 1.7 4.2 1.7s3-.6 4.2-1.7c1.2-1.1 1.8-2.6 1.8-3.8 0-1.2-.6-2.7-1.8-3.8C15 3.6 13.5 3 12 3z"/></svg>
                    </div>
                    <span class="stat-trend down">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg> {{ $lowStockMedicines }}
                    </span>
                </div>
                <div class="stat-label">Low Stock</div>
                <div class="stat-value" style="color:#be123c;">{{ $lowStockMedicines }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#fef2f2,#fee2e2);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(220,38,38,0.12);color:#dc2626;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    </div>
                    <span class="stat-trend down">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg> {{ $expiredMedicines }}
                    </span>
                </div>
                <div class="stat-label">Expired</div>
                <div class="stat-value" style="color:#b91c1c;">{{ $expiredMedicines }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-xl">
        <div class="stat-card" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="stat-icon" style="background:rgba(22,163,74,0.12);color:#16a34a;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <span class="stat-trend neutral">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $pendingOrders }}
                    </span>
                </div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value" style="color:#15803d;">{{ $pendingOrders }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ==============================
     MAIN CONTENT ROW
     ============================== -->
<div class="row g-3 mb-4">
    <!-- Inventory Overview Chart -->
    <div class="col-xl-8">
        <div class="card card-custom h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><rect x="4" y="14" width="4" height="6"/><rect x="10" y="10" width="4" height="10"/><rect x="16" y="4" width="4" height="16"/></svg> Inventory Overview
                </span>
                <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size:0.7rem;">{{ $totalMedicines }} total items</span>
            </div>
            <div class="card-body">
                <div style="position:relative;height:240px;">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Summary -->
    <div class="col-xl-4">
        <div class="card card-custom h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3Z"/><path d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2Z"/><path d="M8 5a4 4 0 0 1 8 0"/></svg> Alert Summary
                </span>
                <a href="{{ route('alerts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body d-flex flex-column justify-content-center gap-3">
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#fef2f2;">
                    <span><span class="badge-status badge-expired me-2">●</span> Expired</span>
                    <span class="fw-bold" style="color:#dc2626;">{{ $expiredAlertCount }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#fffbeb;">
                    <span><span class="badge-status badge-expiring me-2">●</span> Expiring Soon</span>
                    <span class="fw-bold" style="color:#d97706;">{{ $expiringAlertCount }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background:#fff1f2;">
                    <span><span class="badge-status badge-lowstock me-2">●</span> Low Stock</span>
                    <span class="fw-bold" style="color:#e11d48;">{{ $lowStockAlertCount }}</span>
                </div>
                <hr style="margin:0.25rem 0;border-color:var(--border-color);">
                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Active Alerts
                    </span>
                    <span class="fw-bold fs-5" style="color:#dc2626;">{{ $activeAlerts }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Resolved
                    </span>
                    <span class="fw-bold fs-5" style="color:#16a34a;">{{ $resolvedAlerts }}</span>
                </div>
                <a href="{{ route('alerts.index') }}" class="btn btn-sm btn-outline-primary w-100 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> View All Alerts
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ==============================
     ANALYTICS SECTION
     ============================== -->
<div class="row g-3 mb-4">
    <!-- Stock Usage Trends -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><rect x="4" y="14" width="4" height="6"/><rect x="10" y="10" width="4" height="10"/><rect x="16" y="4" width="4" height="16"/></svg> Stock Level Distribution
                </span>
            </div>
            <div class="card-body">
                <div style="position:relative;height:220px;">
                    <canvas id="stockDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiry Forecast -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> Expiry Forecast
                </span>
            </div>
            <div class="card-body">
                <div style="position:relative;height:220px;">
                    <canvas id="expiryForecastChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg> Category Distribution
                </span>
            </div>
            <div class="card-body">
                <div style="position:relative;height:220px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==============================
     STOCK ALERTS PANEL
     ============================== -->
<div class="card card-custom mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> Active Alerts
        </span>
        <a href="{{ route('alerts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-3">
        <div class="row g-2">
            <!-- Critical Alerts -->
            <div class="col-md-4">
                <h6 class="d-flex align-items-center gap-1 mb-2 px-1" style="font-size:0.75rem;color:#dc2626;text-transform:uppercase;letter-spacing:0.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Critical — Expired
                </h6>
                @forelse ($criticalAlerts as $alert)
                    <div class="alert-item critical critical-pulse">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $alert->medicine?->name ?? 'Deleted Medicine' }}</div>
                            <div class="alert-desc">Expired • Qty: {{ $alert->medicine?->quantity ?? 'N/A' }}</div>
                        </div>
                        <span class="alert-time">{{ $alert->date->format('d M') }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-1" style="margin:0 auto 4px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        No expired items
                    </div>
                @endforelse
            </div>

            <!-- Warning Alerts -->
            <div class="col-md-4">
                <h6 class="d-flex align-items-center gap-1 mb-2 px-1" style="font-size:0.75rem;color:#d97706;text-transform:uppercase;letter-spacing:0.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Warning — Expiring Soon
                </h6>
                @forelse ($warningAlerts as $alert)
                    <div class="alert-item warning">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $alert->medicine?->name ?? 'Deleted Medicine' }}</div>
                            <div class="alert-desc">Expires {{ $alert->medicine?->expiry_date?->format('d M Y') ?? 'Unknown' }}</div>
                        </div>
                        <span class="alert-time">{{ $alert->date->format('d M') }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-1" style="margin:0 auto 4px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        No expiring items
                    </div>
                @endforelse
            </div>

            <!-- Info Alerts -->
            <div class="col-md-4">
                <h6 class="d-flex align-items-center gap-1 mb-2 px-1" style="font-size:0.75rem;color:#2563eb;text-transform:uppercase;letter-spacing:0.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M12 3c-1.5 0-3 .6-4.2 1.7C6.6 5.8 6 7.3 6 8.5c0 1.2.6 2.7 1.8 3.8 1.2 1.1 2.7 1.7 4.2 1.7s3-.6 4.2-1.7c1.2-1.1 1.8-2.6 1.8-3.8 0-1.2-.6-2.7-1.8-3.8C15 3.6 13.5 3 12 3z"/></svg> Info — Low Stock
                </h6>
                @forelse ($infoAlerts as $alert)
                    <div class="alert-item info">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M12 3c-1.5 0-3 .6-4.2 1.7C6.6 5.8 6 7.3 6 8.5c0 1.2.6 2.7 1.8 3.8 1.2 1.1 2.7 1.7 4.2 1.7s3-.6 4.2-1.7c1.2-1.1 1.8-2.6 1.8-3.8 0-1.2-.6-2.7-1.8-3.8C15 3.6 13.5 3 12 3z"/></svg>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">{{ $alert->medicine?->name ?? 'Deleted Medicine' }}</div>
                            <div class="alert-desc">Only {{ $alert->medicine?->quantity ?? 0 }} units left</div>
                        </div>
                        <span class="alert-time">{{ $alert->date->format('d M') }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3" style="font-size:0.85rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-1" style="margin:0 auto 4px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Stock levels healthy
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ==============================
     BOTTOM ROW: Suppliers + Recent Activity
     ============================== -->
<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg> Top Suppliers
                </span>
            </div>
            <div class="card-body" style="max-height:260px;overflow-y:auto;">
                @forelse ($supplierStats as $sup)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span style="font-size:0.85rem;">{{ $sup->name }}</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $sup->medicines_count }} items</span>
                    </div>
                @empty
                    <p class="text-muted text-center py-3" style="font-size:0.85rem;">No suppliers yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="m15 5-3 3"/><path d="M9 5v7h7"/><path d="M2 6A10 10 0 0 1 22 6v12A10 10 0 0 1 2 18Z"/><path d="M5 16a4 4 0 0 1 8 0"/></svg> Categories
                </span>
            </div>
            <div class="card-body" style="max-height:260px;overflow-y:auto;">
                @foreach ($categoryStats as $cat)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span style="font-size:0.85rem;">{{ $cat->name }}</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $cat->medicines_count }} items</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><polyline points="3 6 4 7 6 5"/><polyline points="3 12 4 13 6 11"/><polyline points="3 18 4 19 6 17"/></svg> Quick Actions
                </span>
            </div>
            <div class="card-body d-flex flex-column gap-2 justify-content-center" style="min-height:260px;">
                <a href="{{ route('medicines.create') }}" class="btn btn-primary w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add New Medicine
                </a>
                <a href="{{ route('medicines.index') }}" class="btn btn-outline-primary w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg> View Inventory
                </a>
                <a href="{{ route('alerts.index') }}" class="btn btn-outline-warning w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> View Alerts
                    @if ($activeAlerts > 0)
                        <span class="badge bg-danger ms-1">{{ $activeAlerts }}</span>
                    @endif
                </a>
                <a href="{{ route('suppliers.create') }}" class="btn btn-outline-secondary w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg> Add Supplier
                </a>
                <a href="{{ route('alerts.generate') }}" class="btn btn-outline-info w-100 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg> Scan for Alerts
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ==============================
     RECENT ACTIVITY TABLE
     ============================== -->
<div class="card card-custom mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg> Recent Activity
        </span>
        <a href="{{ route('alerts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Alert Type</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentAlerts as $alert)
                        <tr>
                            <td class="fw-semibold">{{ $alert->medicine?->name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $badgeClass = match ($alert->alert_type) {
                                        'Expired' => 'badge-expired',
                                        'Expiring Soon' => 'badge-expiring',
                                        'Low Stock' => 'badge-lowstock',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge-status {{ $badgeClass }}">{{ $alert->alert_type }}</span>
                            </td>
                            <td style="font-size:0.85rem;color:var(--text-secondary);">
                                {{ $alert->medicine?->category?->name ?? '—' }}
                            </td>
                            <td>
                                @if ($alert->medicine && $alert->medicine->quantity < 10)
                                    <span class="badge bg-danger bg-opacity-10 text-danger">{{ $alert->medicine->quantity }}</span>
                                @else
                                    <span>{{ $alert->medicine?->quantity ?? '—' }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $alert->date->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                No alerts. Inventory is healthy.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartColors = {
        primary: '#2563eb',
        danger: '#dc2626',
        warning: '#f59e0b',
        success: '#16a34a',
        info: '#0891b2',
        purple: '#8b5cf6',
        pink: '#ec4899',
        orange: '#f97316',
        indigo: '#6366f1',
        teal: '#14b8a6',
        slate: '#64748b',
    };

    // ---- Inventory Bar Chart ----
    const invCtx = document.getElementById('inventoryChart')?.getContext('2d');
    if (invCtx) {
        new Chart(invCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Medicines',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: {!! json_encode($chartColors) !!},
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 32,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        cornerRadius: 8,
                        padding: 10,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0,0,0,0.05)' },
                        ticks: { stepSize: 1, color: '#94a3b8', font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11 } }
                    }
                }
            }
        });
    }

    // ---- Stock Distribution Bar Chart ----
    const distCtx = document.getElementById('stockDistributionChart')?.getContext('2d');
    if (distCtx) {
        new Chart(distCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($stockRanges)) !!},
                datasets: [{
                    label: 'Medicines',
                    data: {!! json_encode(array_values($stockRanges)) !!},
                    backgroundColor: ['#dc2626', '#f59e0b', '#2563eb', '#16a34a', '#0891b2'],
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 28,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        cornerRadius: 8,
                        padding: 8,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.parsed.y + ' medicines';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0,0,0,0.05)' },
                        ticks: { stepSize: 1, color: '#94a3b8', font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 10 } }
                    }
                }
            }
        });
    }

    // ---- Expiry Forecast Line Chart ----
    const forecastCtx = document.getElementById('expiryForecastChart')?.getContext('2d');
    if (forecastCtx) {
        const forecastLabels = {!! json_encode(array_column($expiryForecast, 'label')) !!};
        const forecastData = {!! json_encode(array_column($expiryForecast, 'count')) !!};
        new Chart(forecastCtx, {
            type: 'line',
            data: {
                labels: forecastLabels,
                datasets: [{
                    label: 'Expiring',
                    data: forecastData,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        cornerRadius: 8,
                        padding: 8,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.parsed.y + ' medicines expiring';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, color: 'rgba(0,0,0,0.05)' },
                        ticks: { stepSize: 1, color: '#94a3b8', font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 10 } }
                    }
                }
            }
        });
    }

    // ---- Category Pie Chart ----
    const catCtx = document.getElementById('categoryChart')?.getContext('2d');
    if (catCtx) {
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catData) !!},
                    backgroundColor: {!! json_encode($catColors) !!},
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            boxWidth: 8,
                            boxHeight: 8,
                            usePointStyle: true,
                            font: { size: 9 },
                            color: '#94a3b8',
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        cornerRadius: 8,
                        padding: 8,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = ((ctx.parsed / total) * 100).toFixed(1);
                                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
