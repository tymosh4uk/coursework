<?php

namespace App\Service;

use App\Models\Product;
use App\Models\ProductUrl;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getProduct($product) {
        $separator = " \t\n";

        $array_words = [];
        $tok = strtok($product, $separator);

        while($tok) {
            $array_words[] = $tok;
            $tok = strtok($separator);
        }

        $query = DB::table('products')
            ->where('title', 'like', $array_words[0].' %');
        for($i = 1; $i < count($array_words); $i++) {
            $query = $query->where('title', 'LIKE', '%'.$array_words[$i].'%');
        }

        $query = $query->skip(1)->first();

//        $data = DB::table('products')
//            ->where('title', 'like', $product.' %')
//            ->first();

        if($query) {
            return $query;
        }
        return null;
    }

}
