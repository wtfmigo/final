<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    protected $fillable = [
        'product_category_id', 'name', 'description', 'price'
    ];
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }
}
