<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('category_id', 'name');
        $suppliers = Supplier::pluck('supplier_id', 'name');

        $medicines = [
            [
                'name' => 'Paracetamol',
                'batch_number' => 'PCM-2026-B001',
                'category_id' => $categories['Analgesics'],
                'supplier_id' => $suppliers['PharmaCorp International'],
                'quantity' => 50,
                'expiry_date' => Carbon::now()->subMonths(2)->toDateString(),
            ],
            [
                'name' => 'Ibuprofen',
                'batch_number' => 'IBU-2026-B002',
                'category_id' => $categories['Analgesics'],
                'supplier_id' => $suppliers['PharmaCorp International'],
                'quantity' => 30,
                'expiry_date' => Carbon::now()->addDays(15)->toDateString(),
            ],
            [
                'name' => 'Amoxicillin',
                'batch_number' => 'AMX-2026-B003',
                'category_id' => $categories['Antibiotics'],
                'supplier_id' => $suppliers['MediSupply East Africa'],
                'quantity' => 5,
                'expiry_date' => Carbon::now()->addMonths(6)->toDateString(),
            ],
            [
                'name' => 'Vitamin C',
                'batch_number' => 'VTC-2026-B004',
                'category_id' => $categories['Vitamins & Supplements'],
                'supplier_id' => $suppliers['Global Health Distributors'],
                'quantity' => 100,
                'expiry_date' => Carbon::now()->addMonths(12)->toDateString(),
            ],
            [
                'name' => 'Ciprofloxacin',
                'batch_number' => 'CPF-2026-B005',
                'category_id' => $categories['Antibiotics'],
                'supplier_id' => $suppliers['MediSupply East Africa'],
                'quantity' => 20,
                'expiry_date' => Carbon::now()->subMonth()->toDateString(),
            ],
            [
                'name' => 'Metronidazole',
                'batch_number' => 'MTZ-2026-B006',
                'category_id' => $categories['Antibiotics'],
                'supplier_id' => $suppliers['Rwanda Pharmaceutical Ltd'],
                'quantity' => 3,
                'expiry_date' => Carbon::now()->addMonths(8)->toDateString(),
            ],
            [
                'name' => 'Diazepam',
                'batch_number' => 'DZP-2026-B007',
                'category_id' => $categories['Sedatives'],
                'supplier_id' => $suppliers['Rwanda Pharmaceutical Ltd'],
                'quantity' => 15,
                'expiry_date' => Carbon::now()->addDays(7)->toDateString(),
            ],
            [
                'name' => 'Omeprazole',
                'batch_number' => 'OMP-2026-B008',
                'category_id' => $categories['Antacids'],
                'supplier_id' => $suppliers['East African Drug Mart'],
                'quantity' => 60,
                'expiry_date' => Carbon::now()->addMonths(9)->toDateString(),
            ],
            [
                'name' => 'Loratadine',
                'batch_number' => 'LRT-2026-B009',
                'category_id' => $categories['Antihistamines'],
                'supplier_id' => $suppliers['East African Drug Mart'],
                'quantity' => 8,
                'expiry_date' => Carbon::now()->addMonths(4)->toDateString(),
            ],
            [
                'name' => 'Aspirin',
                'batch_number' => 'ASP-2026-B010',
                'category_id' => $categories['Analgesics'],
                'supplier_id' => $suppliers['PharmaCorp International'],
                'quantity' => 200,
                'expiry_date' => Carbon::now()->subMonths(3)->toDateString(),
            ],
        ];

        foreach ($medicines as $data) {
            Medicine::create($data);
        }
    }
}
