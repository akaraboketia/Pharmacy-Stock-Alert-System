<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Antibiotics', 'description' => 'Medicines used to treat bacterial infections'],
            ['name' => 'Analgesics', 'description' => 'Pain relief medications'],
            ['name' => 'Antipyretics', 'description' => 'Fever reducing medications'],
            ['name' => 'Antihistamines', 'description' => 'Allergy relief medications'],
            ['name' => 'Antacids', 'description' => 'Digestive system medications'],
            ['name' => 'Vitamins & Supplements', 'description' => 'Nutritional supplements'],
            ['name' => 'Antidepressants', 'description' => 'Mental health medications'],
            ['name' => 'Antihypertensives', 'description' => 'Blood pressure medications'],
            ['name' => 'Antidiabetics', 'description' => 'Diabetes management medications'],
            ['name' => 'Sedatives', 'description' => 'Tranquilizers and sleep aids'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
