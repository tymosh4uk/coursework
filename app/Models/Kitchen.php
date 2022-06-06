<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use HasFactory;
    protected $fillable = ['kitchen'];

    public function receipt() {
        return $this->hasMany(Receipt::class, 'id_kitchen', 'id');
    }
}
