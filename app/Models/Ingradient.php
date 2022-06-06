<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingradient extends Model
{
    use HasFactory;
    protected $fillable = ['id_receipt', 'ingradient', 'count_ingradient', 'type_measuring'];

    public function receipt() {
        return $this->belongsTo(Receipt::class, 'id_receipt', 'id');
    }
}
