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
        $income = User::where('id', $user_id)->value('income');
        // if ($income == null) {
        //     return view('initial_setting');
        // };

        //変動費、固定費のカテゴリ一覧
        $fixed_cost_categories = $this->getCategories(1, $user_id);
        $variable_cost_categories = $this->getCategories(0, $user_id);

        //それぞれのカテゴリの当月総支出額をインスタンスに持たせる
        foreach ($fixed_cost_categories as $category) {
            $category->sum_expences =  $this->categoryExpencesSum($category->id);
        }
        foreach ($variable_cost_categories as $category) {
            $category->sum_expences =  $this->categoryExpencesSum($category->id);
        }

        //貯金可能金額
        $plan_expence_amount = ExpenceCategory::where('user_id', $user_id)->sum('maximum_price');
        $saving_amount = $income - $plan_expence_amount;

        // 日時取得
        $this_month = date("m");
        return view('home')->with([
            'income' => $income,
            'this_month' => $this_month,
            'fixed_cost_categories' => $fixed_cost_categories,
            'variable_cost_categories' => $variable_cost_categories,
            'saving_amount' => $saving_amount,
        ]);
    }

    /**
     * カテゴリー取得
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCategories($fixed_cost_flg, $user_id) {
        $categories = ExpenceCategory::where('user_id', $user_id)
                                    ->where('fixed_cost_flg', $fixed_cost_flg) 
                                    ->get();
        return $categories;
    }

    /**
     * get total expences
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTotalExpences($fixed_cost_flg, $user_id) {
        $categories = ExpenceCategory::where('user_id', $user_id)->get();
        $total_variable_cost = 0;
        $total_fixed_cost = 0;
        foreach ($categories as $category) {
            //固定費
            if ($category->fixed_cost_flg) {
                $total_fixed_cost += $category->maximum_price;
            }
            //該当expence_category_idを持つ集計を足していく
            $total_variable_cost += Expence::where('expence_category_id', $category->id)->sum('price');
        }

        return array($total_fixed_cost, $total_variable_cost);
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
        $expence->memo = $request->input('memo');
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
        //今月の総利用額
        $sum_expences = $this->categoryExpencesSum($id);
        //該当カテゴリの当月支出データ詳細
        $expences = $this->getThisMonthExpences($id);
        return view('category_detail')->with([
            'expences' => $expences,
            'category' => $category,
            'sum_expences' => $sum_expences,
        ]);
    }

    /**
     * 該当カテゴリの当月総支出額を返す
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryExpencesSum($id) {
        $expences = $this->getThisMonthExpences($id);   
        //今月の総利用額
        $sum_expences = 0;
        foreach ($expences as $expence) {
            $sum_expences += $expence->price;
        }
        return $sum_expences;
    }

    /**
     * 該当カテゴリの当月支出データを返す
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getThisMonthExpences($id) {
        $expences = 
            Expence::whereRaw( 
                "created_at >= DATE_TRUNC('month', now()) " . 
                "AND created_at < DATE_TRUNC('month', now() + '1 months') + '-1 days' " .
                "AND expence_category_id = ? ",
                [$id])
                ->get();  

        return $expences;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editExpenceCategory(Request $request, $id) {
        $method = $request->method();
        if ($request->isMethod('get')) {
            $category = ExpenceCategory::find($id);
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editExpence(Request $request, $id) {
        $method = $request->method();
        $expence = Expence::find($id);
        if ($request->isMethod('get')) {
            // 支出編集ページへ遷移させる
            return view('edit_expence')->with([
                'expence' => $expence,
            ]);
        } else {
            // バリデーション
            $validatedData = $request->validate([
                'memo' => 'required|max:20',
                'price' => 'required|numeric',
            ]);
            //支出更新
            $expence->memo = $request->input('memo');
            $expence->price = $request->input('price');
            $expence->save();
            // カテゴリー詳細へ遷移させる
            return $this->categoryDetail($expence->category_id);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateCategories($id) {
        //該当レコード削除
        // TODO 論理削除に。 & 削除確認ポップを出す。
        DB::table('expence_categories')
            ->where('id' , '=', $id)
            ->delete();
        // TOPページへ遷移させる
        return $this->index();  
    }

    /**
     * 貯金履歴のページ表示
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function savingHistory() {
        $user_id = Auth::id();
        // $first_category_created_at = ExpenceCategory::where('user_id', $user_id)->first()->created_at;
        // $first_category_created_month = date('Y年n月', strtotime($first_category_created_at));
        
    }
}
