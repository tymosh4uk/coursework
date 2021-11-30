<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Receipt;
use App\Models\Kitchen;
use App\Models\Category;

class AdminController extends Controller
{
    public function getChartInfo() {
        $categories = DB::table('categories')
            ->select('categories.category as category', DB::raw('count(*) as total'))
            ->groupBy('categories.category')
            ->get();

        return $categories;
    }

    public function getChartInfoKitchens() {
        $kitchens = DB::table('kitchens')
            ->select('kitchens.kitchen as kitchen', DB::raw('count(*) as total'))
            ->groupBy('kitchens.kitchen')
            ->get();

        return $kitchens;
    }

    public function createCategory(Request $request) {
        if($request->category != null) {
            $category = new Category();
            $category->category = $request->category;
            $category->save();
            return true;
        }
        return false;
    }

    public function createKitchen(Request $request) {
        if($request->kitchen != null) {
            $kitchen = new Kitchen();
            $kitchen->kitchen = $request->kitchen;
            $kitchen->save();
            return true;
        }
        return false;
    }
}
