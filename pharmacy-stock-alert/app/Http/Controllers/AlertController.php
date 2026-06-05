<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(Request $request): View
    {
        $query = Alert::with('medicine.category', 'medicine.supplier');

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('alert_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->whereHas('medicine', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('resolved_at');
            } elseif ($request->status === 'resolved') {
                $query->whereNotNull('resolved_at');
            }
        }

        $alerts = $query->latest()->paginate(15)->withQueryString();

        // Counts for filter badges
        $totalActive = Alert::whereNull('resolved_at')->count();
        $totalResolved = Alert::whereNotNull('resolved_at')->count();

        return view('alerts.index', compact('alerts', 'totalActive', 'totalResolved'));
    }

    public function generateAlerts(): RedirectResponse
    {
        $medicines = Medicine::all();
        $today = now();
        $count = 0;

        foreach ($medicines as $medicine) {
            // Skip if already has unresolved alert of same type

            // Expired
            if ($medicine->expiry_date < $today->toDateString()) {
                $existing = Alert::where('med_id', $medicine->med_id)
                    ->where('alert_type', 'Expired')
                    ->whereNull('resolved_at')
                    ->exists();

                if (!$existing) {
                    Alert::create([
                        'med_id' => $medicine->med_id,
                        'alert_type' => 'Expired',
                        'date' => $today->toDateString(),
                    ]);
                    $count++;
                }
            }

            // Expiring Soon (within 30 days)
            if ($medicine->expiry_date >= $today->toDateString() &&
                $medicine->expiry_date <= $today->copy()->addDays(30)->toDateString()) {
                $existing = Alert::where('med_id', $medicine->med_id)
                    ->where('alert_type', 'Expiring Soon')
                    ->whereNull('resolved_at')
                    ->exists();

                if (!$existing) {
                    Alert::create([
                        'med_id' => $medicine->med_id,
                        'alert_type' => 'Expiring Soon',
                        'date' => $today->toDateString(),
                    ]);
                    $count++;
                }
            }

            // Low Stock
            if ($medicine->quantity < 10) {
                $existing = Alert::where('med_id', $medicine->med_id)
                    ->where('alert_type', 'Low Stock')
                    ->whereNull('resolved_at')
                    ->exists();

                if (!$existing) {
                    Alert::create([
                        'med_id' => $medicine->med_id,
                        'alert_type' => 'Low Stock',
                        'date' => $today->toDateString(),
                    ]);
                    $count++;
                }
            }
        }

        return redirect()->route('alerts.index')
            ->with('success', "$count new alert(s) generated successfully.");
    }

    public function resolve(Alert $alert): RedirectResponse
    {
        $alert->update(['resolved_at' => now()]);

        return redirect()->route('alerts.index')
            ->with('success', 'Alert resolved successfully.');
    }

    public function restock(Alert $alert): RedirectResponse
    {
        $medicine = $alert->medicine;

        if ($medicine) {
            // Double the quantity as a restock
            $medicine->increment('quantity', 50);

            // Mark alert as resolved
            $alert->update(['resolved_at' => now()]);

            return redirect()->route('alerts.index')
                ->with('success', "Restocked {$medicine->name} with 50 units. Alert resolved.");
        }

        return redirect()->route('alerts.index')
            ->with('error', 'Medicine not found.');
    }

    public function details(Alert $alert): JsonResponse
    {
        $alert->load('medicine.category', 'medicine.supplier');

        return response()->json([
            'alert_id' => $alert->alert_id,
            'alert_type' => $alert->alert_type,
            'date' => $alert->date->format('Y-m-d'),
            'created_at' => $alert->created_at->format('Y-m-d H:i'),
            'resolved_at' => $alert->resolved_at?->format('Y-m-d H:i'),
            'medicine' => $alert->medicine ? [
                'med_id' => $alert->medicine->med_id,
                'name' => $alert->medicine->name,
                'batch_number' => $alert->medicine->batch_number,
                'quantity' => $alert->medicine->quantity,
                'expiry_date' => $alert->medicine->expiry_date->format('Y-m-d'),
                'category' => $alert->medicine->category?->name,
                'supplier' => $alert->medicine->supplier?->name,
            ] : null,
        ]);
    }
}
