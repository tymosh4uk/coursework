<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductUrl extends Model
{
    use HasFactory;
    protected $fillable = ['link'];

    public function product() {
        return $this->hasOne(Product::class, 'product_url_id', 'id');
    }
}
