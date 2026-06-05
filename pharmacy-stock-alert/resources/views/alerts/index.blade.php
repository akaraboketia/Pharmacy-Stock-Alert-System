@extends('layouts.app')

@section('title', 'Stock Alerts - Pharmacy Stock Alert System')
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
@endsection
@section('page-title', 'Stock Alerts')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Monitor inventory alerts and take action</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('alerts.generate') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg> Generate Alerts
        </a>
    </div>
</div>

<!-- Filter tabs -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('alerts.index') }}"
        class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3Z"/><path d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2Z"/><path d="M8 5a4 4 0 0 1 8 0"/></svg> All
    </a>
    <a href="{{ route('alerts.index', ['status' => 'active'] + request()->except('status')) }}"
        class="btn btn-sm {{ request('status') === 'active' ? 'btn-danger' : 'btn-outline-secondary' }} rounded-pill px-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Active
        @if ($totalActive > 0)
            <span class="badge bg-light text-danger ms-1">{{ $totalActive }}</span>
        @endif
    </a>
    <a href="{{ route('alerts.index', ['status' => 'resolved'] + request()->except('status')) }}"
        class="btn btn-sm {{ request('status') === 'resolved' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Resolved
        @if ($totalResolved > 0)
            <span class="badge bg-light text-success ms-1">{{ $totalResolved }}</span>
        @endif
    </a>
</div>

<!-- Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('alerts.index') }}" class="row g-2 align-items-end">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">Alert Type</label>
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>
                        All Types
                    </option>
                    <option value="Expired" {{ request('type') == 'Expired' ? 'selected' : '' }}>Expired</option>
                    <option value="Expiring Soon" {{ request('type') == 'Expiring Soon' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="Low Stock" {{ request('type') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                    <input type="text" name="search" class="form-control"
                        placeholder="Search by medicine name..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
                    @if (request('search') || request('type') != 'all')
                        <a href="{{ route('alerts.index', request()->only('status')) }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Alerts List -->
<div class="card card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><polyline points="3 6 4 7 6 5"/><polyline points="3 12 4 13 6 11"/><polyline points="3 18 4 19 6 17"/></svg> Alert List</span>
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $alerts->total() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">Severity</th>
                        <th>Medicine</th>
                        <th>Alert Type</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end" style="width:200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alerts as $alert)
                        @php
                            $severityClass = match ($alert->alert_type) {
                                'Expired' => 'critical',
                                'Expiring Soon' => 'warning',
                                'Low Stock' => 'info',
                                default => 'info',
                            };
                            $severityIcon = match ($alert->alert_type) {
                                'Expired' => 'bi-x-circle-fill',
                                'Expiring Soon' => 'bi-clock-fill',
                                'Low Stock' => 'bi-exclamation-diamond-fill',
                                default => 'bi-bell-fill',
                            };
                            $severityColor = match ($alert->alert_type) {
                                'Expired' => '#dc2626',
                                'Expiring Soon' => '#d97706',
                                'Low Stock' => '#2563eb',
                                default => '#64748b',
                            };
                            $isResolved = !is_null($alert->resolved_at);
                        @endphp
                        <tr class="{{ !$isResolved ? 'alert-row-' . $severityClass : 'opacity-75' }}">
                            <td>
                                <div style="width:8px;height:8px;border-radius:50%;background:{{ $severityColor }};display:inline-block;{{ !$isResolved ? 'animation:pulse-dot 2s infinite;' : '' }}"></div>
                            </td>
                            <td class="fw-semibold">{{ $alert->medicine?->name ?? 'Deleted Medicine' }}</td>
                            <td>
                                <span class="badge-status {{ match($alert->alert_type) {
                                    'Expired' => 'badge-expired',
                                    'Expiring Soon' => 'badge-expiring',
                                    'Low Stock' => 'badge-lowstock',
                                    default => 'bg-secondary',
                                } }}">
                                    {{ $alert->alert_type }}
                                </span>
                            </td>
                            <td style="font-size:0.8rem;color:var(--text-secondary);">
                                {{ $alert->medicine?->category?->name ?? '—' }}
                            </td>
                            <td>
                                @if ($alert->medicine)
                                    @if ($alert->medicine->quantity < 5)
                                        <span class="badge bg-danger">{{ $alert->medicine->quantity }}</span>
                                    @elseif ($alert->medicine->quantity < 10)
                                        <span class="badge bg-warning text-dark">{{ $alert->medicine->quantity }}</span>
                                    @else
                                        <span>{{ $alert->medicine->quantity }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $alert->date->format('d M Y') }}</td>
                            <td>
                                @if ($isResolved)
                                    <span class="status-pill pill-good"><span class="status-dot"></span> Resolved</span>
                                @else
                                    <span class="status-pill {{ match($alert->alert_type) {
                                        'Expired' => 'pill-expired',
                                        'Expiring Soon' => 'pill-expiring',
                                        'Low Stock' => 'pill-lowstock',
                                        default => 'pill-lowstock',
                                    } }}"><span class="status-dot"></span> Active</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-icon-sm"
                                        onclick="viewDetails({{ $alert->alert_id }})" title="View Details"
                                        {{ $isResolved ? 'disabled' : '' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>

                                    @if (!$isResolved)
                                        <form action="{{ route('alerts.restock', $alert) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success btn-icon-sm"
                                                title="Restock (add 50 units)"
                                                onclick="return confirmRestock('{{ addslashes($alert->medicine?->name ?? 'this medicine') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('alerts.resolve', $alert) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success btn-icon-sm"
                                                title="Mark as Resolved"
                                                onclick="return confirmResolve('{{ addslashes($alert->medicine?->name ?? 'this medicine') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <p class="fw-semibold mb-1">No alerts found</p>
                                <p style="font-size:0.85rem;">Inventory is healthy. Generate alerts to scan for issues.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($alerts->hasPages())
        <div class="card-footer">
            {{ $alerts->links() }}
        </div>
    @endif
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border:none;border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid var(--border-color);padding:1.25rem 1.5rem;">
                <h5 class="modal-title fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> Alert Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="detailBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Loading details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .alert-row-critical { border-left: 3px solid #dc2626; }
    .alert-row-warning { border-left: 3px solid #d97706; }
    .alert-row-info { border-left: 3px solid #2563eb; }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.5); }
    }
</style>
@endsection

@push('scripts')
<script>
function confirmRestock(name) {
    return Swal.fire({
        title: 'Restock Medicine',
        html: `Add 50 units to <strong>${name}</strong> and resolve this alert?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        confirmButtonText: 'Yes, restock',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then(result => result.isConfirmed);
}

function confirmResolve(name) {
    return Swal.fire({
        title: 'Resolve Alert',
        html: `Mark alert for <strong>${name}</strong> as resolved?`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        confirmButtonText: 'Yes, resolve',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then(result => result.isConfirmed);
}

function viewDetails(alertId) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const body = document.getElementById('detailBody');
    body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Loading details...</p></div>';
    modal.show();

    fetch(`/alerts/${alertId}/details`)
        .then(res => res.json())
        .then(data => {
            const m = data.medicine || {};
            const severityColor = data.alert_type === 'Expired' ? '#dc2626' :
                data.alert_type === 'Expiring Soon' ? '#d97706' : '#2563eb';
            const severityIcon = data.alert_type === 'Expired' ? 'bi-x-circle-fill' :
                data.alert_type === 'Expiring Soon' ? 'bi-clock-fill' : 'bi-exclamation-diamond-fill';

            body.innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;height:100%;">
                            <h6 class="fw-semibold mb-3" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg> Alert Information
                            </h6>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge-status ${data.alert_type === 'Expired' ? 'badge-expired' : data.alert_type === 'Expiring Soon' ? 'badge-expiring' : 'badge-lowstock'}" style="font-size:0.8rem;">
                                    <i class="bi ${severityIcon} me-1"></i> ${data.alert_type}
                                </span>
                            </div>
                            <div style="font-size:0.85rem;">
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Alert ID</span>
                                    <span class="fw-semibold">#${data.alert_id}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Created</span>
                                    <span>${data.date}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Status</span>
                                    <span class="${data.resolved_at ? 'text-success' : 'text-danger'} fw-semibold">${data.resolved_at ? 'Resolved' : 'Active'}</span>
                                </div>
                                ${data.resolved_at ? `
                                <div class="d-flex justify-content-between py-2 border-top" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Resolved At</span>
                                    <span>${data.resolved_at}</span>
                                </div>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;height:100%;">
                            <h6 class="fw-semibold mb-3" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg> Medicine Details
                            </h6>
                            ${m.name ? `
                            <div style="font-size:0.85rem;">
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Name</span>
                                    <span class="fw-semibold">${m.name}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Batch #</span>
                                    <span style="font-family:monospace;">${m.batch_number || '—'}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Category</span>
                                    <span>${m.category || '—'}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Supplier</span>
                                    <span>${m.supplier || '—'}</span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#e2e8f0!important;">
                                    <span class="text-muted">Quantity</span>
                                    <span class="fw-semibold ${m.quantity < 10 ? 'text-danger' : ''}">${m.quantity} units</span>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Expiry Date</span>
                                    <span>${m.expiry_date}</span>
                                </div>
                            </div>` : `<p class="text-muted text-center py-3">Medicine was deleted</p>`}
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3" style="border-top:1px solid #e2e8f0;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    ${!data.resolved_at ? `
                    <form action="/alerts/${data.alert_id}/restock" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'}">
                        <button type="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg> Restock</button>
                    </form>
                    <form action="/alerts/${data.alert_id}/resolve" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'}">
                        <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><polyline points="20 6 9 17 4 12"/></svg> Resolve</button>
                    </form>` : ''}
                </div>
            `;
        })
        .catch(() => {
            body.innerHTML = '<div class="text-center py-4 text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><p>Failed to load details.</p></div>';
        });
}
</script>
@endpush
