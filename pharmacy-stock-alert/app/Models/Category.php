<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = ['name', 'description'];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'category_id', 'category_id');
    }
}
