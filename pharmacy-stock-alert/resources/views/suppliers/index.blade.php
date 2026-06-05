@extends('layouts.app')

@section('title', 'Suppliers - Pharmacy Stock Alert System')
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg>
@endsection
@section('page-title', 'Suppliers')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <p class="text-muted mb-0">Manage your pharmaceutical suppliers and distributors</p>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;vertical-align:middle;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Supplier
    </a>
</div>

<div class="card card-custom mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('suppliers.index') }}" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, contact person, or email..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></button>
                    @if (request('search'))
                        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><path d="M5 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M15 17a2 2 0 1 0 4 0 2 2 0 0 0-4 0Z"/><path d="M5 17H3V6a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v1"/><path d="M9 17h6"/><path d="M15 11H9"/><path d="M19 17h2V9"/><path d="M19 9h-4v8"/><path d="M5 17v1h2"/></svg> Supplier Directory</span>
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $suppliers->total() }} total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Medicines</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="text-muted" style="font-size:0.8rem;">#{{ $supplier->supplier_id }}</td>
                            <td class="fw-semibold">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center"
                                        style="width:32px;height:32px;border-radius:8px;background:var(--primary-light);color:var(--primary);font-size:0.8rem;flex-shrink:0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><line x1="8" y1="6" x2="10" y2="6"/><line x1="14" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="10" y2="10"/><line x1="14" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="10" y2="14"/><line x1="14" y1="14" x2="16" y2="14"/></svg>
                                    </span>
                                    {{ $supplier->name }}
                                </div>
                            </td>
                            <td>{{ $supplier->contact_person ?? '—' }}</td>
                            <td>
                                @if ($supplier->email)
                                    <a href="mailto:{{ $supplier->email }}" style="font-size:0.85rem;color:var(--text-secondary);text-decoration:none;">
                                        {{ $supplier->email }}
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem;">{{ $supplier->phone ?? '—' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                    {{ $supplier->medicines_count }} items
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                    class="btn btn-sm btn-outline-primary btn-icon-sm" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 0 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}"
                                    method="POST" class="d-inline" id="delete-form-{{ $supplier->supplier_id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-icon-sm"
                                        onclick="confirmDelete({{ $supplier->supplier_id }}, '{{ addslashes($supplier->name) }}')"
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="d-block mb-2" style="margin:0 auto;"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                                No suppliers found.
                                <a href="{{ route('suppliers.create') }}" class="d-block mt-2">Add your first supplier</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($suppliers->hasPages())
        <div class="card-footer">
            {{ $suppliers->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Supplier',
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
</script>
@endpush
