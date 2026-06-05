<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = Medicine::all();
        $today = Carbon::today();

        foreach ($medicines as $medicine) {
            // Expired alerts
            if ($medicine->expiry_date < $today->toDateString()) {
                Alert::create([
                    'med_id' => $medicine->med_id,
                    'alert_type' => 'Expired',
                    'date' => $today->toDateString(),
                ]);
            }

            // Expiring Soon alerts
            if ($medicine->expiry_date >= $today->toDateString() &&
                $medicine->expiry_date <= Carbon::now()->addDays(30)->toDateString()) {
                Alert::create([
                    'med_id' => $medicine->med_id,
                    'alert_type' => 'Expiring Soon',
                    'date' => $today->toDateString(),
                ]);
            }

            // Low Stock alerts
            if ($medicine->quantity < 10) {
                Alert::create([
                    'med_id' => $medicine->med_id,
                    'alert_type' => 'Low Stock',
                    'date' => $today->toDateString(),
                ]);
            }
        }
    }
}
