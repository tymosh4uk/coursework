<?php

namespace App\Http\Controllers;

use App\Service\ProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Receipt_comment;
use App\Models\Saved;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getAuthStatus() {
        Redirect::back();
        if(!Auth::check()) {
            return false;
        }
        else {
            return Auth::check();
        }
    }

    public function getId() {
        Redirect::back();
        if(!Auth::check()) {
            return false;
        }
        else {
            return Auth::user()->id;
        }
    }

    public function getUserId() {
        if(Auth::check()) {
            return Auth::user()->id;
        }
        return null;
    }

    public function logout(Request $request) {
        Auth::logout();
        Redirect::back();
        return true;
    }

    public function addComment (Request $request) {
        $comment = new Receipt_comment();
        $comment->id_user = Auth::id();
        $comment->id_receipt = $request['id_receipt'];
        $comment->comment = $request['comment'];
        $comment->save();

        return true;
    }

    public function getAllComments (Request $request) {
        $comments = DB::table('receipt_comments')
            ->join('users', 'receipt_comments.id_user', '=', 'users.id')
            ->where('receipt_comments.id_receipt', '=', $request->receipt)
            ->select('receipt_comments.comment as comment','receipt_comments.id_user', 'users.name as name', 'users.surname as surname', 'receipt_comments.created_at as created_at')
            ->orderByDesc('receipt_comments.created_at')
            ->get();

        foreach ($comments as $comment) {

            $comment->created_at =  Carbon::parse($comment->created_at)->format("d-m-Y H:i");
        }

        if(count($comments) == 0) {
            return 0;
        }
        else {
            return $comments;
        }
//        return $comments;
    }

    public function saveReceipt(Request $request) {
        $saved = new Saved();
        $saved->id_user = Auth::id();
        $saved->id_receipt = $request['id_receipt'];
        $saved->save();

        return true;
    }

    public function getSavedById(Request $request) {
        $saved = DB::table('saveds')
            ->where('saveds.id_receipt', '=', $request->receipt)
            ->where('saveds.id_user', '=', Auth::id())
            ->select('saveds.id', 'saveds.id_receipt', 'saveds.id_user')
            ->get();
        if(count($saved) == 0) {
            return 0;
        }
        else {
            return $saved;
        }
    }

    public function removeFromSaved(Request $request) {
//        $saved = DB::table('saveds')
//            ->where('saveds.id_receipt', '=', $request->receipt)
//            ->where('saveds.id_user', '=', Auth::id())
//            ->select('saveds.id', 'saveds.id_receipt', 'saveds.id_user')
//            ->first();
//
//        return $saved->delete();
        return DB::table('saveds')
            ->where('saveds.id_user','=', Auth::id())
            ->where('saveds.id_receipt','=', $request['id_receipt'])
            ->delete();


    }

    public function getAllSaved() {
        $receipts = DB::table('saveds')
            ->join('receipts', 'saveds.id_receipt', '=', 'receipts.id')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->select('receipts.id', 'receipts.name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen')
            ->where('saveds.id_user', '=', Auth::id())
            ->orderBy('receipts.id')
            ->get();




        //dd($receipts, $ingradients);
        return [
            "receipts" => $receipts,
            "ingradients" => $receipts
        ];
    }

    public function getTopReceipts() {
//        $data = DB::select(DB::raw("
//            SELECT receipts.name as name, receipts.cooking_hours, receipts.cooking_minutes, receipts.main_img,
//                   receipts.advice
//            FROM receipts


//            WHERE receipts.id = (SELECT TOP 5 id_receipt
//                                FROM receipt_comments
//                                GROUP BY receipt_comments.id_receipt
//                                ORDER BY COUNT(receipt_comments.id_receipt))"));
        $comments = DB::table('receipt_comments')
            ->select('id_receipt', DB::raw('count(*) as total'))
            ->groupBy('id_receipt')
            ->orderByDesc('total')
            ->take(5)->get();

        $id_comments = array();
        foreach($comments as $arr){
            $id_comments[] = $arr->id_receipt;
        }
        $id_comments_ordered = implode(',', $id_comments);

        $receipts = DB::table('receipts')
            ->select(DB::raw('count(*) as ingradients_count, ingradients.id_receipt'), 'receipts.id','receipts.name as name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen', 'users.name as username', 'users.surname')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->join('users', 'receipts.id_user', '=','users.id')
            ->join('ingradients', 'receipts.id', '=','ingradients.id_receipt')
            ->whereIn('receipts.id', $id_comments)
            ->orderByRaw("FIELD(receipts.id, $id_comments_ordered)")
            ->groupBy('ingradients.id_receipt')
            ->get();
        return $receipts;
    }

    public function findReceipt(Request $request) {
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


        $data = DB::select(DB::raw($sql_query));

        if(count($data) > 0) {
            return $data;
        }
        else {
            false;
        }

//        if($request['name']) {
//            $receipts = DB::table('receipts')
//                ->join('categories', 'receipts.id_category', '=', 'categories.id')
//                ->join('kitchens', 'receipts.id_kitchen', '=', 'kitchens.id')
//                ->join('users', 'receipts.id_user', '=', 'users.id')
//                ->select('receipts.id', 'receipts.name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen', 'users.name as username', 'users.surname')
//                ->where('receipts.name', 'LIKE', '%' . $request['name'] . '%')
//                ->get();
//        }

    }

    public function findProduct(Request $request) {
        $product = $request->product;
        $service = new ProductService();
        $data = $service->getProduct($product);
        return [
           'result' => $data !== null ? $data : null
        ];


    }
}
