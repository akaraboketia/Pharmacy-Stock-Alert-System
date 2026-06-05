<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $primaryKey = 'alert_id';

    protected $fillable = ['med_id', 'alert_type', 'date'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'resolved_at' => 'datetime',
        ];
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class, 'med_id', 'med_id');
    }
}
