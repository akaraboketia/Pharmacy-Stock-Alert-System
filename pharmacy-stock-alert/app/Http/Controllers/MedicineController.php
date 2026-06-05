<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    public function index(Request $request): View
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $today = Carbon::today();
            match ($request->status) {
                'expired' => $query->where('expiry_date', '<', $today),
                'expiring' => $query->whereBetween('expiry_date', [$today, $today->copy()->addDays(30)]),
                'low_stock' => $query->where('quantity', '<', 10),
                'good' => $query->where('expiry_date', '>=', $today)
                    ->where('quantity', '>=', 10),
                default => null,
            };
        }

        $medicines = $query->with(['category', 'supplier'])->latest()->paginate(10)->withQueryString();

        return view('medicines.index', compact('medicines'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('medicines.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,category_id',
            'supplier_id' => 'nullable|exists:suppliers,supplier_id',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine): View
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('medicines.edit', compact('medicine', 'categories', 'suppliers'));
    }

    public function update(Request $request, Medicine $medicine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:categories,category_id',
            'supplier_id' => 'nullable|exists:suppliers,supplier_id',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    public function show(Medicine $medicine): JsonResponse
    {
        $medicine->load('category', 'supplier');
        $today = Carbon::today();
        $expiry = $medicine->expiry_date instanceof Carbon ? $medicine->expiry_date : Carbon::parse($medicine->expiry_date);

        $isExpired = $expiry->lt($today);
        $isExpiring = $expiry->lte($today->copy()->addDays(30)) && !$isExpired;
        $isLowStock = $medicine->quantity < 10;

        $status = $isExpired ? 'Expired' : ($isExpiring ? 'Expiring Soon' : ($isLowStock ? 'Low Stock' : 'Good'));
        $statusColor = $isExpired ? '#dc2626' : ($isExpiring ? '#d97706' : ($isLowStock ? '#e11d48' : '#16a34a'));

        return response()->json([
            'med_id' => $medicine->med_id,
            'name' => $medicine->name,
            'batch_number' => $medicine->batch_number,
            'quantity' => $medicine->quantity,
            'expiry_date' => $expiry->format('Y-m-d'),
            'expiry_formatted' => $expiry->format('d M Y'),
            'created_at' => $medicine->created_at?->format('d M Y'),
            'category' => $medicine->category?->name ?? '—',
            'supplier' => $medicine->supplier?->name ?? '—',
            'status' => $status,
            'status_color' => $statusColor,
        ]);
    }

    public function destroy(Medicine $medicine): RedirectResponse
    {
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Medicine deleted successfully.');
    }
}
