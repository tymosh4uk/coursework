<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt_like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'receipt_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }
}
