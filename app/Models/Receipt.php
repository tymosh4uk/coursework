<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cooking_hours', 'cooking_minutes', 'main_img', 'id_category', 'id_kitchen', 'id_user', 'advice', 'id_step'];
}
