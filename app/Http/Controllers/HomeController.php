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
        $user_id = Auth::id();
        $income = DB::table('users')->where('id', $user_id)->value('income');
        if ($income == null) {
            return view('initial_setting');
        };

        //支出追加フォームに渡すカテゴリ一覧
        $categories = DB::table('expence_categories')->where('user_id', '=', $user_id)->get();

        // 日時取得
        $this_month = date("m");
        return view('home')->with([
            'income' => $income,
            'this_month' => $this_month,
            'expence_categories' => $categories,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function initialSetting(Request $request)
    {
        // incomeの更新
        $income = $request->input('income');
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['income' => $income]);

        // TOPページへ遷移させる
        return $this->index();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addExpence(Request $request)
    {
        $price = $request->input('price');
        $name = $request->input('name');
        $category_id = $request->input('category');

        //expencesにインサート
        DB::table('expences')->insert([
            'price' => $price,
            'name' => $name, 
            'expence_categories_id' => $category_id,
        ]);
        
        //TOP画面に遷移
        return $this->index();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addExpenceCategory(Request $request)
    {
        $method = $request->method();
        if ($request->isMethod('get')) {
            // 支出登録ページへ遷移させる
            return view('add_expence_categort_form');
        } else {
            $name = $request->input('name');
            $fixed_cost_flg = $request->input('fixed_cost');
            $maximum_price = $request->input('maximum_price');
            //expencesにインサート
            DB::table('expence_categories')->insert([
                'name' => $name,
                'fixed_cost_flg' => $fixed_cost_flg,
                'maximum_price' => $maximum_price,
                'user_id' => Auth::id(),
            ]);
            // TOPページへ遷移させる
            return $this->index();
        }
    }
}
