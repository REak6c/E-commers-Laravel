<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = ['slug', 'name', 'description', 'logo_url', 'status'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Compatibility shim: $brand->translation->name still works
    public function getTranslationAttribute()
    {
        return $this;
    }
}
