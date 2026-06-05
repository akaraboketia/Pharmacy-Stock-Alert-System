<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pharmacy Stock Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; }
        h1 { font-size: 20px; color: #2563eb; margin-bottom: 4px; }
        h2 { font-size: 14px; color: #64748b; font-weight: normal; margin-top: 0; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #2563eb; margin-bottom: 20px; }
        .header .date { font-size: 10px; color: #94a3b8; }
        .summary { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .summary-box { text-align: center; padding: 10px; background: #f8fafc; border-radius: 6px; flex: 1; margin: 0 4px; }
        .summary-box .num { font-size: 18px; font-weight: bold; color: #2563eb; }
        .summary-box .label { font-size: 8px; text-transform: uppercase; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #2563eb; color: #fff; padding: 8px 10px; text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 6px 10px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 8px; font-weight: bold; text-transform: uppercase; }
        .badge-expired { background: #fee2e2; color: #dc2626; }
        .badge-expiring { background: #fef3c7; color: #d97706; }
        .badge-lowstock { background: #fef2f2; color: #b91c1c; }
        .badge-good { background: #dcfce7; color: #16a34a; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 9px; color: #94a3b8; }
        .page-break { page-break-after: always; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-20 { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pharmacy Stock Report</h1>
        <h2>Pharmacy Stock Alert System</h2>
        <div class="date">Generated: {{ $today->format('F d, Y') }}</div>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="num">{{ $totalMedicines }}</div>
            <div class="label">Total Medicines</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#dc2626;">{{ $expiredMedicines }}</div>
            <div class="label">Expired</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#d97706;">{{ $expiringSoonMedicines }}</div>
            <div class="label">Expiring Soon</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#b91c1c;">{{ $lowStockMedicines }}</div>
            <div class="label">Low Stock</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#6b7280;">{{ $outOfStockMedicines }}</div>
            <div class="label">Out of Stock</div>
        </div>
        <div class="summary-box">
            <div class="num" style="color:#16a34a;">{{ $activeAlerts }}</div>
            <div class="label">Active Alerts</div>
        </div>
        <div class="summary-box">
            <div class="num">{{ $totalSuppliers }}</div>
            <div class="label">Suppliers</div>
        </div>
    </div>

    <h2 style="margin-top:20px;">Complete Inventory List</h2>
    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Category</th>
                <th>Supplier</th>
                <th class="text-center">Qty</th>
                <th>Expiry</th>
                <th>Batch</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicines as $med)
                @php
                    $status = 'good';
                    $statusLabel = 'In Stock';
                    if ($med->expiry_date < $today) { $status = 'expired'; $statusLabel = 'Expired'; }
                    elseif ($med->expiry_date <= $today->copy()->addDays(30)) { $status = 'expiring'; $statusLabel = 'Expiring Soon'; }
                    elseif ($med->quantity < 10) { $status = 'lowstock'; $statusLabel = 'Low Stock'; }
                @endphp
                <tr>
                    <td><strong>{{ $med->name }}</strong></td>
                    <td>{{ $med->category?->name ?? '—' }}</td>
                    <td>{{ $med->supplier?->name ?? '—' }}</td>
                    <td class="text-center">{{ $med->quantity }}</td>
                    <td>{{ $med->expiry_date->format('M d, Y') }}</td>
                    <td>{{ $med->batch_number }}</td>
                    <td><span class="badge badge-{{ $status }}">{{ $statusLabel }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Pharmacy Stock Alert System &mdash; Generated {{ $today->format('F d, Y \\a\\t H:i') }}
    </div>
</body>
</html>
