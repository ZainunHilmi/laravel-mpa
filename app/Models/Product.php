<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'rules',
        'price',
        'sku',
        'stock',
        'category_id',
        'image',
        'is_favorite',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
