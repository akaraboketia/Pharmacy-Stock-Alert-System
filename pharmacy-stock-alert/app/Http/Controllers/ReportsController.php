<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Medicine;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // Stock summary
        $totalMedicines = Medicine::count();
        $expiredMedicines = Medicine::where('expiry_date', '<', $today)->count();
        $expiringSoonMedicines = Medicine::whereBetween('expiry_date', [$today, $today->copy()->addDays(30)])->count();
        $lowStockMedicines = Medicine::where('quantity', '<', 10)->count();
        $outOfStockMedicines = Medicine::where('quantity', '=', 0)->count();

        // Alert stats
        $totalAlerts = Alert::count();
        $activeAlerts = Alert::whereNull('resolved_at')->count();
        $resolvedAlerts = Alert::whereNotNull('resolved_at')->count();

        // Expired alerts count
        $expiredAlertCount = Alert::where('alert_type', 'Expired')->count();
        $expiringAlertCount = Alert::where('alert_type', 'Expiring Soon')->count();
        $lowStockAlertCount = Alert::where('alert_type', 'Low Stock')->count();

        // Supplier stats
        $totalSuppliers = Supplier::count();

        // Stock by category
        $medicinesByCategory = Medicine::with('category')
            ->selectRaw('category_id, COUNT(*) as count, SUM(quantity) as total_qty')
            ->groupBy('category_id')
            ->get();

        // Stock usage ranges
        $medicinesByQty = Medicine::all();
        $stockRanges = ['0–9' => 0, '10–49' => 0, '50–99' => 0, '100–199' => 0, '200+' => 0];
        foreach ($medicinesByQty as $med) {
            if ($med->quantity < 10) $stockRanges['0–9']++;
            elseif ($med->quantity < 50) $stockRanges['10–49']++;
            elseif ($med->quantity < 100) $stockRanges['50–99']++;
            elseif ($med->quantity < 200) $stockRanges['100–199']++;
            else $stockRanges['200+']++;
        }

        // Monthly expiry forecast
        $expiryForecast = [];
        for ($i = 0; $i < 6; $i++) {
            $month = $today->copy()->addMonths($i);
            $count = Medicine::whereBetween('expiry_date', [
                $month->copy()->startOfMonth()->toDateString(),
                $month->copy()->endOfMonth()->toDateString()
            ])->count();
            $expiryForecast[] = ['label' => $month->format('M Y'), 'count' => $count];
        }

        // Top suppliers by medicine count
        $topSuppliers = Supplier::withCount('medicines')->orderBy('medicines_count', 'desc')->take(10)->get();

        // Recent alerts
        $recentAlerts = Alert::with('medicine.category')->latest()->take(15)->get();

        // All medicines for the detailed table
        $medicines = Medicine::with('category', 'supplier')->orderBy('name')->get();

        return view('reports.index', compact(
            'totalMedicines', 'expiredMedicines', 'expiringSoonMedicines',
            'lowStockMedicines', 'outOfStockMedicines',
            'totalAlerts', 'activeAlerts', 'resolvedAlerts',
            'expiredAlertCount', 'expiringAlertCount', 'lowStockAlertCount',
            'totalSuppliers', 'medicinesByCategory', 'stockRanges',
            'expiryForecast', 'topSuppliers', 'recentAlerts', 'medicines', 'today'
        ));
    }

    public function exportPdf(Request $request)
    {
        $today = Carbon::today();

        $reportType = $request->query('type', 'stock_summary');

        // Common data
        $totalMedicines = Medicine::count();
        $expiredMedicines = Medicine::where('expiry_date', '<', $today)->count();
        $expiringSoonMedicines = Medicine::whereBetween('expiry_date', [$today, $today->copy()->addDays(30)])->count();
        $lowStockMedicines = Medicine::where('quantity', '<', 10)->count();
        $outOfStockMedicines = Medicine::where('quantity', '=', 0)->count();

        $activeAlerts = Alert::whereNull('resolved_at')->count();
        $totalSuppliers = Supplier::count();

        $medicines = Medicine::with('category', 'supplier')->orderBy('name')->get();

        $data = compact(
            'totalMedicines', 'expiredMedicines', 'expiringSoonMedicines',
            'lowStockMedicines', 'outOfStockMedicines',
            'activeAlerts', 'totalSuppliers', 'medicines', 'today', 'reportType'
        );

        $pdf = Pdf::loadView('reports.pdf', $data);

        return $pdf->download('pharmacy-report-' . $today->format('Y-m-d') . '.pdf');
    }
}
