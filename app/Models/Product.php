<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUrl;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'bills', 'coins', 'measuring', 'product_url_id'];

    public function product_url() {
        return $this->belongsTo(ProductUrl::class, 'product_url_id', 'id');
    }
}
