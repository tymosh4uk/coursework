<?php

namespace App\Service;

use App\Models\Product;
use App\Models\ProductUrl;
use App\Models\Receipt_like;
use Illuminate\Support\Facades\DB;

class LikesService
{
    public function setLike($request) {
        $userId = $request->user_id;
        Receipt_like::with('user', function($user) use ($userId) {
            $user->where('user_id', $userId);
        })->get();
    }
}
