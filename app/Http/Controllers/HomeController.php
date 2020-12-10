<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Expence;
use App\ExpenceCategory;
use App\User;

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
        $fixed_cost_categories = $this->getCategories(1, $user_id);
        $variable_cost_categories = $this->getCategories(0, $user_id);

        //↓DBに二回接続するのと以下のように一回のDB接続でforeachで振り分けするのだったらどっちがよいのだろう。
        // $categories = DB::table('expence_categories')->where('user_id', '=', $user_id)->get();
        // $fixed_cost_categories = array();
        // $variable_cost_categories = array();
        // foreach ($categories as $category) {
        //     if ($category->fixed_cost_flg) {
        //         $fixed_cost_categories[] = $category;
        //     } else {
        //         $variable_cost_categories[] = $category;
        //     }
        // }

        // 日時取得
        $this_month = date("m");
        return view('home')->with([
            'income' => $income,
            'this_month' => $this_month,
            'fixed_cost_categories' => $fixed_cost_categories,
            'variable_cost_categories' => $variable_cost_categories,
            // 'expence_categories' => $categories,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCategories($fixed_cost_flg, $user_id) {
        $categories = 
        DB::table('expence_categories')
            ->where('user_id', '=', $user_id)
            ->where('fixed_cost_flg', '=', $fixed_cost_flg)
            ->get();
        return $categories;
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function initialSetting(Request $request)
    {
        // incomeの更新
        $user = User::find(Auth::id());
        $user->income = $request->input('income');
        $user->save();

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
        // バリデーション
        $validatedData = $request->validate([
            'price' => 'required|numeric',
            'memo' => 'required|max:20',
        ]);

        //expencesにインサート
        $expence = new Expence();
        $expence->price = $request->input('price');
        $expence->name = $request->input('memo');
        $expence->expence_category_id = $request->input('category');
        $expence->save();
        
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
            return view('add_expence_category_form');
        } else {
            // バリデーション
            $validatedData = $request->validate([
                'name' => 'required|max:20',
                'maximum_price' => 'required|numeric',
            ]);
            //expencesにインサート
            $category = new ExpenceCategory();
            $category->fixed_cost_flg = $request->input('fixed_cost');
            $category->name = $request->input('name');
            $category->maximum_price = $request->input('maximum_price');
            $category->user_id= Auth::id();
            $category->save();
        
            // TOPページへ遷移させる
            return $this->index();
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryDetail($id) {
        $category = ExpenceCategory::find($id);

        return view('category_detail')->with([
            'category' => $category,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editExpenceCategory(Request $request, $id) {
        $method = $request->method();
        if ($request->isMethod('get')) {
            $category = ExpenceCategory::find($id)->first();
            // 支出登録ページへ遷移させる
            return view('edit_expence_category')->with([
                'category' => $category,
            ]);
        } else {
            // バリデーション
            $validatedData = $request->validate([
                'name' => 'required|max:20',
                'maximum_price' => 'required|numeric',
            ]);
            //カテゴリ更新
            $category = ExpenceCategory::find($id);
            $category->fixed_cost_flg = $request->input('fixed_cost');
            $category->name = $request->input('name');
            $category->maximum_price = $request->input('maximum_price');
            $category->user_id = Auth::id();
            $category->save();
            // カテゴリー詳細へ遷移させる
            return $this->categoryDetail($id);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteExpenceCategory($id) {
        //該当レコード削除
        // TODO 論理削除に。 & 削除確認ポップを出す。
        DB::table('expence_categories')
            ->where('id' , '=', $id)
            ->delete();
        // TOPページへ遷移させる
        return $this->index();  
    }
}
