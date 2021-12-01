<?php

namespace App\Http\Controllers;

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
        return Auth::user()->id;
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
        return DB::table('saveds')->where('saveds.id_user','=', Auth::id())->where('saveds.id_receipt','=', $request['id_receipt'])->delete();


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
            ->select('receipts.id','receipts.name as name', 'receipts.cooking_hours', 'receipts.cooking_minutes', 'receipts.main_img as image', 'categories.category', 'kitchens.kitchen', 'users.name as username', 'users.surname')
            ->join('categories', 'receipts.id_category', '=','categories.id')
            ->join('kitchens', 'receipts.id_kitchen', '=','kitchens.id')
            ->join('users', 'receipts.id_user', '=','users.id')
            ->whereIn('receipts.id', $id_comments)
            ->orderByRaw("FIELD(receipts.id, $id_comments_ordered)")
            ->get();
        return $receipts;
    }
}
