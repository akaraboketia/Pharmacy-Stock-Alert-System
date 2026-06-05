<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // Core stats
        $totalMedicines = Medicine::count();
        $expiredMedicines = Medicine::where('expiry_date', '<', $today)->count();
        $expiringSoonMedicines = Medicine::whereBetween('expiry_date', [$today, $today->copy()->addDays(30)])->count();
        $lowStockMedicines = Medicine::where('quantity', '<', 10)->count();
        $outOfStockMedicines = Medicine::where('quantity', '=', 0)->count();
        $inStockMedicines = max(0, $totalMedicines - $expiredMedicines - $expiringSoonMedicines - $lowStockMedicines - $outOfStockMedicines);
        
        // Alert stats
        $totalAlerts = Alert::count();
        $activeAlerts = Alert::whereNull('resolved_at')->count();
        $resolvedAlerts = Alert::whereNotNull('resolved_at')->count();

        // Categories distribution
        $categoryStats = Category::withCount('medicines')->get();

        // Recent alerts grouped by type
        $criticalAlerts = Alert::with('medicine')
            ->where('alert_type', 'Expired')
            ->whereNull('resolved_at')
            ->latest()
            ->take(5)
            ->get();

        $warningAlerts = Alert::with('medicine')
            ->where('alert_type', 'Expiring Soon')
            ->whereNull('resolved_at')
            ->latest()
            ->take(5)
            ->get();

        $infoAlerts = Alert::with('medicine')
            ->where('alert_type', 'Low Stock')
            ->whereNull('resolved_at')
            ->latest()
            ->take(5)
            ->get();

        // Chart data: medicines by status
        $chartLabels = ['Total', 'Expired', 'Expiring Soon', 'Low Stock', 'Out of Stock', 'Good'];
        $chartData = [
            $totalMedicines,
            $expiredMedicines,
            $expiringSoonMedicines,
            $lowStockMedicines,
            $outOfStockMedicines,
            $inStockMedicines,
        ];
        $chartColors = ['#2563eb', '#dc2626', '#f59e0b', '#e11d48', '#6b7280', '#16a34a'];

        // Category chart data
        $catLabels = $categoryStats->pluck('name')->toArray();
        $catData = $categoryStats->pluck('medicines_count')->toArray();
        $catColors = ['#2563eb', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#06b6d4', '#f97316', '#6366f1', '#14b8a6', '#e11d48'];

        // Stock levels by quantity ranges for stock usage chart
        $medicinesByQty = Medicine::all();
        $stockRanges = [
            '0-9' => 0,
            '10-49' => 0,
            '50-99' => 0,
            '100-199' => 0,
            '200+' => 0,
        ];
        foreach ($medicinesByQty as $med) {
            if ($med->quantity <= 0) $stockRanges['0-9']++;
            elseif ($med->quantity < 10) $stockRanges['0-9']++;
            elseif ($med->quantity < 50) $stockRanges['10-49']++;
            elseif ($med->quantity < 100) $stockRanges['50-99']++;
            elseif ($med->quantity < 200) $stockRanges['100-199']++;
            else $stockRanges['200+']++;
        }

        // Expiry forecast data (next 6 months)
        $expiryForecast = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $today->copy()->addMonths($i);
            $count = Medicine::whereBetween('expiry_date', [
                $month->copy()->startOfMonth()->toDateString(),
                $month->copy()->endOfMonth()->toDateString()
            ])->count();
            $expiryForecast[] = [
                'label' => $month->format('M Y'),
                'count' => $count,
            ];
        }

        // Most-used medicines (by supplier count)
        $supplierStats = Supplier::withCount('medicines')->orderBy('medicines_count', 'desc')->take(5)->get();

        // Supplier stats
        $totalSuppliers = Supplier::count();

        // Alert summary counts
        $expiredAlertCount = Alert::where('alert_type', 'Expired')->count();
        $expiringAlertCount = Alert::where('alert_type', 'Expiring Soon')->count();
        $lowStockAlertCount = Alert::where('alert_type', 'Low Stock')->count();

        // Recent alerts for the dashboard table
        $recentAlerts = Alert::with('medicine.category')->latest()->take(10)->get();

        // Pending orders count (calculated as medicines that are low stock and not expired)
        $pendingOrders = Medicine::where('quantity', '<', 10)
            ->where('expiry_date', '>=', $today)
            ->count();

        return view('dashboard.index', compact(
            'totalMedicines',
            'expiredMedicines',
            'expiringSoonMedicines',
            'lowStockMedicines',
            'outOfStockMedicines',
            'inStockMedicines',
            'totalAlerts',
            'activeAlerts',
            'resolvedAlerts',
            'totalSuppliers',
            'criticalAlerts',
            'warningAlerts',
            'infoAlerts',
            'chartLabels',
            'chartData',
            'chartColors',
            'catLabels',
            'catData',
            'catColors',
            'stockRanges',
            'expiryForecast',
            'supplierStats',
            'expiredAlertCount',
            'expiringAlertCount',
            'lowStockAlertCount',
            'categoryStats',
            'recentAlerts',
            'pendingOrders'
        ));
    }
}
