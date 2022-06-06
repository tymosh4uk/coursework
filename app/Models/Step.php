<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_receipt',
        'step',
        'step_image',
        'step_description'
    ];

    public function receipt() {
        return $this->belongsTo(Receipt::class, 'id', 'id_receipt');
    }
}
