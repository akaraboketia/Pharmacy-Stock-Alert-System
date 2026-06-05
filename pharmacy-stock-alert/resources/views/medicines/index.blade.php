@extends('layouts.app')

@section('title', 'Inventory - Pharmacy Stock Alert System')
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
@endsection
@section('page-title', 'Inventory')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Manage your pharmacy medicine inventory</p>
    </div>
    <a href="{{ route('medicines.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Medicine
    </a>
</div>

<!-- Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('medicines.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by medicine name..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="good" {{ request('status') == 'good' ? 'selected' : '' }}>Good</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg> Filter</button>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.75rem;color:var(--text-secondary);">&nbsp;</label>
                <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Inventory Table -->
<div class="card card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg> Medicine Inventory</span>
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $medicines->total() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height:600px;">
            <table class="table table-custom table-hover mb-0" id="inventoryTable" style="position:relative;">
                <thead style="position:sticky;top:0;z-index:10;background:var(--bg-body);">
                    <tr>
                        <th style="width:50px;">ID</th>
                        <th>Medicine Name</th>
                        <th>Batch #</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th style="width:80px;">Qty</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th class="text-end" style="width:140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicines as $medicine)
                        @php
                            $today = \Carbon\Carbon::today();
                            $expiry = \Carbon\Carbon::parse($medicine->expiry_date);
                            $isExpired = $expiry->lt($today);
                            $isExpiring = $expiry->lte($today->copy()->addDays(30)) && !$isExpired;
                            $isLowStock = $medicine->quantity < 10;
                            $rowClass = $isExpired ? 'table-danger' : ($isExpiring ? 'table-warning' : ($isLowStock ? 'table-danger-subtle' : ''));
                        @endphp
                        <tr class="{{ $rowClass }}" style="cursor:pointer;" onclick="viewMedicine({{ $medicine->med_id }})">
                            <td class="text-muted" style="font-size:0.8rem;">#{{ $medicine->med_id }}</td>
                            <td class="fw-semibold">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center"
                                        style="width:28px;height:28px;border-radius:8px;background:var(--primary-light);color:var(--primary);font-size:0.7rem;flex-shrink:0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                                    </span>
                                    {{ $medicine->name }}
                                </div>
                            </td>
                            <td style="font-size:0.8rem;font-family:monospace;color:var(--text-secondary);">
                                {{ $medicine->batch_number ?? '—' }}
                            </td>
                            <td>
                                @if ($medicine->category)
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill" style="font-size:0.7rem;">
                                        {{ $medicine->category->name }}
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.8rem;color:var(--text-secondary);">
                                {{ $medicine->supplier->name ?? '—' }}
                            </td>
                            <td>
                                @if ($medicine->quantity == 0)
                                    <span class="badge bg-danger">0</span>
                                @elseif ($medicine->quantity < 5)
                                    <span class="badge bg-danger">{{ $medicine->quantity }}</span>
                                @elseif ($medicine->quantity < 10)
                                    <span class="badge bg-warning text-dark">{{ $medicine->quantity }}</span>
                                @elseif ($medicine->quantity < 25)
                                    <span class="badge bg-info text-dark">{{ $medicine->quantity }}</span>
                                @else
                                    <span>{{ $medicine->quantity }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $expiry->format('d M Y') }}</td>
                            <td>
                                @if ($isExpired)
                                    <span class="status-pill pill-expired"><span class="status-dot"></span> Expired</span>
                                @elseif ($isExpiring)
                                    <span class="status-pill pill-expiring"><span class="status-dot"></span> Expiring</span>
                                @elseif ($isLowStock)
                                    <span class="status-pill pill-lowstock"><span class="status-dot"></span> Low Stock</span>
                                @else
                                    <span class="status-pill pill-good"><span class="status-dot"></span> Good</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end" onclick="event.stopPropagation();">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-icon-sm"
                                        onclick="viewMedicine({{ $medicine->med_id }})" title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                    <a href="{{ route('medicines.edit', $medicine) }}"
                                        class="btn btn-sm btn-outline-primary btn-icon-sm" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 0 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                    </a>
                                    <form action="{{ route('medicines.destroy', $medicine) }}"
                                        method="POST" class="d-inline" id="delete-form-{{ $medicine->med_id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-icon-sm"
                                            onclick="confirmDelete({{ $medicine->med_id }}, '{{ addslashes($medicine->name) }}')"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                                No medicines found.
                                <a href="{{ route('medicines.create') }}" class="d-block mt-2">Add your first medicine</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($medicines->hasPages())
        <div class="card-footer">
            {{ $medicines->links() }}
        </div>
    @endif
</div>

<!-- Medicine Detail Slide Panel (Offcanvas) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="medicineDetailPanel" style="width:480px;border:none;">
    <div class="offcanvas-header" style="border-bottom:1px solid var(--border-color);padding:1.25rem 1.5rem;">
        <h5 class="offcanvas-title fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> Medicine Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-4" id="medicineDetailBody">
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem;"></div>
            <p class="mt-3 text-muted">Loading details...</p>
        </div>
    </div>
</div>

<style>
    .table-responsive::-webkit-scrollbar { width: 6px; height: 6px; }
    .table-responsive::-webkit-scrollbar-track { background: transparent; }
    .table-responsive::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    [data-bs-theme="dark"] .table-responsive::-webkit-scrollbar-thumb { background: #334155; }
    .table-danger-subtle { background: rgba(225,29,72,0.04); }
    [data-bs-theme="dark"] .table-danger-subtle { background: rgba(225,29,72,0.08); }
</style>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Medicine',
        html: `Are you sure you want to delete <strong>${name}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function viewMedicine(medId) {
    const panel = new bootstrap.Offcanvas(document.getElementById('medicineDetailPanel'));
    const body = document.getElementById('medicineDetailBody');
    body.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status" style="width:2.5rem;height:2.5rem;"></div><p class="mt-3 text-muted">Loading details...</p></div>';
    panel.show();

    fetch('/medicines/' + medId)
        .then(res => res.json())
        .then(m => {
            const statusClass = m.status === 'Expired' ? 'pill-expired' :
                m.status === 'Expiring Soon' ? 'pill-expiring' :
                m.status === 'Low Stock' ? 'pill-lowstock' : 'pill-good';

            body.innerHTML = `
                <div class="text-center mb-4">
                    <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#eff6ff,#dbeafe);display:inline-flex;align-items:center;justify-content:center;margin-bottom:0.75rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 14 5-5 5 5"/><path d="m7 19 5-5 5 5"/></svg>
                    </div>
                    <h5 class="fw-bold mb-1">${m.name}</h5>
                    <span class="status-pill ${statusClass}"><span class="status-dot"></span> ${m.status}</span>
                </div>
                <hr style="border-color:var(--border-color);">
                <div style="font-size:0.85rem;">
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Medicine ID</span>
                        <span class="fw-semibold">#${m.med_id}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Batch Number</span>
                        <span style="font-family:monospace;">${m.batch_number || '—'}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Category</span>
                        <span>${m.category}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Supplier</span>
                        <span>${m.supplier}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Quantity</span>
                        <span class="fw-semibold ${m.quantity < 10 ? 'text-danger' : ''}">${m.quantity} units</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;">
                        <span class="text-muted">Expiry Date</span>
                        <span>${m.expiry_formatted}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted">Added On</span>
                        <span>${m.created_at || '—'}</span>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4 pt-3" style="border-top:1px solid var(--border-color);">
                    <a href="/medicines/${m.med_id}/edit" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><path d="M17 3a2.85 2.83 0 0 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg> Edit Medicine
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Close</button>
                </div>
            `;
        })
        .catch(() => {
            body.innerHTML = '<div class="text-center py-5 text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><p>Failed to load medicine details.</p></div>';
        });
}
</script>
@endpush
