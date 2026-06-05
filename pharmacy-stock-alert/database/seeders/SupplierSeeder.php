<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PharmaCorp International',
                'contact_person' => 'James Mwangi',
                'email' => 'jmwangi@pharmacorp.rw',
                'phone' => '+250 788 100 200',
                'address' => 'KG 123 St, Kigali Heights, Kigali',
            ],
            [
                'name' => 'MediSupply East Africa',
                'contact_person' => 'Sarah Uwimana',
                'email' => 'suwimana@medisupply.rw',
                'phone' => '+250 722 300 400',
                'address' => 'KN 45 Ave, Gaculiro, Kigali',
            ],
            [
                'name' => 'Global Health Distributors',
                'contact_person' => 'Patrick Kagame',
                'email' => 'pkagame@globalhealth.rw',
                'phone' => '+250 733 500 600',
                'address' => 'KG 678 Blvd, Kacyiru, Kigali',
            ],
            [
                'name' => 'Rwanda Pharmaceutical Ltd',
                'contact_person' => 'Diane Mukamana',
                'email' => 'dmukamana@rpl.rw',
                'phone' => '+250 755 700 800',
                'address' => 'KN 90 St, Nyamirambo, Kigali',
            ],
            [
                'name' => 'East African Drug Mart',
                'contact_person' => 'Eric Niyonzima',
                'email' => 'eniyonzima@eadrugmart.rw',
                'phone' => '+250 789 900 100',
                'address' => 'KG 12 Ave, Kimihurura, Kigali',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
