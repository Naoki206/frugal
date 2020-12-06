<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //初期設定ができているかチェック入れる。できてない場合設定ページ(本当は認証確認後のみに入れたい)
        $income = DB::table('users')->where('id', Auth::id())->value('income');
        if ($income == null) {
            return view('initial_setting');
        };
        return view('home');
    }

}
