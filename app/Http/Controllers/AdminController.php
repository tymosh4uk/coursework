<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Receipt;
use App\Models\Kitchen;
use App\Models\Category;

use App\Exports\ReceiptsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        $receipt = Receipt::find($request['id_receipt']);
        if($receipt) {
            $receipt->name = $request['name'];
            $receipt->cooking_hours = $request['cooking_hours'];
            $receipt->cooking_minutes = $request['cooking_minutes'];
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

    public function findAdminReceipt(Request $request) {
        $sql_query = "SELECT receipts.id, receipts.name as name, receipts.cooking_hours, receipts.cooking_minutes, receipts.main_img as image,
                 receipts.advice, categories.category, kitchens.kitchen, users.name as username, users.surname
                 FROM receipts
                 JOIN categories ON (receipts.id_category = categories.id)
                 JOIN kitchens ON (receipts.id_kitchen = kitchens.id)
                 JOIN users ON (receipts.id_user = users.id)";

        $count = 0;
        $sql_query .= " WHERE";

        if($request['name']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " receipts.name LIKE '%" . $request['name'] . "%'";
            $count++;
        }
        if($request['category']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " categories.category LIKE '%" . $request['category'] . "%'";
            $count++;
        }
        if($request['kitchen']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " kitchens.kitchen LIKE '%" . $request['kitchen'] . "%'";
            $count++;
        }
        if($request['user']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " users.id =" . $request['user'];
            $count++;
        }

        if($request['createdFrom']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " DATE(receipts.created_at) >= '" . $request['createdFrom'] . "'";
            $count++;
        }

        if($request['createdTo']) {
            if($count != 0) {
                $sql_query .= " AND";
            }
            $sql_query .= " DATE(receipts.created_at) <= '" . $request['createdTo'] . "'";
            $count++;
        }

//        return $sql_query;


        $data = DB::select(DB::raw($sql_query));

        if(count($data) > 0) {
            return $data;
        }
        else {
            false;
        }


    }



    //KPZ

    public function receiptExport(){
        return Excel::download(new ReceiptsExport, 'receipts.xlsx');
    }
}
