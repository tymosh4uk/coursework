<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Receipt_comment;

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
        $comment->id_user = $request['id_user'];
        $comment->id_receipt = $request['id_receipt'];
        $comment->comment = $request['comment'];
        $comment->save();

        return true;
    }
}
