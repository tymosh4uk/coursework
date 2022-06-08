<?php

namespace App\Service;

use App\Models\Product;
use App\Models\ProductUrl;
use App\Models\Receipt_like;
use App\Models\Receipt_dislike;
use App\Models\Saved;
use Illuminate\Support\Facades\DB;

class LikesService
{
    public function getLikes($request)
    {
        $receipt = $request->receipt;
//        $likes = Receipt_like::with('user', function($user) use ($userId) {
//            $user->where('user_id', $userId);
//        })->get();

        $likes = Receipt_like::where('receipt_id', $receipt)->count();
        $dislikes = Receipt_dislike::where('receipt_id', $receipt)->count();

        if ($likes && $dislikes) {
            return [
                "status" => true,
                "likes" => $likes,
                "dislikes" => $dislikes,
            ];
        }
        return [
            "status" => false,
            "likes" => 0,
            "dislikes" => 0,
        ];
    }

    public function getSaveds($request)
    {
        $receipt = $request->receipt;
        $saveds = Saved::where('id_receipt', $receipt)->count();

        if ($saveds) {
            return [
                "status" => true,
                "saveds" => $saveds,
            ];
        }
        return [
            "status" => false,
            "saveds" => 0,
        ];
    }

    public function setLike($request) {
        $receipt = $request->receipt_id;
        $user = $request->user_id;

        $dislike = Receipt_dislike::where([['receipt_id', '=', $receipt], ['user_id', '=', $user]])->delete();
        $like = Receipt_like::where([['receipt_id', '=', $receipt], ['user_id', '=', $user]])->first();


        $like
            ?
            $like->delete()
            :
            $like = Receipt_like::create([
                'user_id' => $user,
                'receipt_id' => $receipt,
            ]);


        if($like) {
            return [
                'status' => true,
                'like' => $like
            ];
        }

        return [
            'status' => false
        ];
    }

    public function setDislike($request) {
        $receipt = $request->receipt_id;
        $user = $request->user_id;

        $like = Receipt_like::where([['receipt_id', '=', $receipt], ['user_id', '=', $user]])->delete();
        $dislike = Receipt_dislike::where([['receipt_id', '=', $receipt], ['user_id', '=', $user]])->first();

        $dislike
            ?
            $dislike->delete()
            :
            $dislike = Receipt_dislike::create([
                'user_id' => $user,
                'receipt_id' => $receipt,
            ]);

        if($dislike) {
            return [
                'status' => true,
                'dislike' => $dislike
            ];
        }

        return [
            'status' => false
        ];
    }
}
