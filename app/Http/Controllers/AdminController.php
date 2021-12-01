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

    public function editReceipt(Request $request) {
//        $receipt = 1;
        $receipt = Receipt::find($request['id_receipt']);
        if($receipt) {
            $receipt->name = $request['name'];
            $receipt->cooking_hours = $request['cooking_hours'];
            $receipt->cooking_minutes = $request['cooking_minutes'];
//            $receipt->category = $request['category'];
//            $receipt->kitchen = $request['kitchen'];
            $receipt->advice = $request['advice'];

            if($request['category']) {
                $category = Category::find($receipt->id_category)->delete();
                $new_category = Category::create([
                    "category" => $request['category']
                ]);
                $receipt->id_category = $new_category->id;
            }
            if($request['kitchen']) {
                $kitchen = Kitchen::find($receipt->id_kitchen)->delete();
                $new_kitchen = Kitchen::create([
                    "kitchen" => $request['kitchen']
                ]);
                $receipt->id_kitchen = $new_kitchen->id;
            }
            if($request['photo']) {
                $image = $request['photo'];
                $name = time() .'_'. $image->getClientOriginalName();
                $request['photo']->storeAs('images', $name, 'public');
                $receipt->main_img = $name;
            }
            $receipt->save();
            return true;
        }
        return false;
    }
}
