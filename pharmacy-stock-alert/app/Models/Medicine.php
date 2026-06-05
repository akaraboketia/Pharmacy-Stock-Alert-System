<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $primaryKey = 'med_id';

    protected $fillable = ['name', 'batch_number', 'category_id', 'supplier_id', 'quantity', 'expiry_date'];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class, 'med_id', 'med_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
