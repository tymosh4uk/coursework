<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cooking_hours', 'cooking_minutes', 'main_img', 'id_category', 'id_kitchen', 'id_user', 'advice', 'id_step'];

    public function user() {
        return $this->belongsTo(User::class, 'id', 'id_user');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'id', 'id_category',);
    }

    public function kitchen() {
        return $this->belongsTo(Kitchen::class, 'id', 'id_kitchen');
    }

    public function ingradient() {
        return $this->hasMany(Ingradient::class, 'id_receipt', 'id');
    }

    public function step() {
        return $this->hasMany(Step::class, 'id_receipt', 'id');
    }

}
