<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt_dislike extends Model
{
    use HasFactory;
    protected $fillable = [
        'receipt_id',
        'user_id',
    ];
}
