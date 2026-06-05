<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';

    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address'];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'supplier_id', 'supplier_id');
    }
}
