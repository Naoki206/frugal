@extends('layout')

@section('content')
<div class="container">
<h2>{{ $this_month }} 月<h2>
    {{-- <h3>今月の貯金目標額:{{ $saving_amount }}</h3>
    @if ($saving_amount < 0)
        支出予定額が収入を上回っています。予定を立て直しましょう！
    @endif --}}
    
    <!-- 支出フォーム -->
    <h4>支出</h4>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(!$variable_cost_categories->isEmpty())
    <form action="/add_expence" method="POST">
        <div class="form-row">
            <div class="form-group col-md-2">
              <label for="inputCity">金額</label>
              <input type="text" class="form-control" id="inputCity" name="price">
            </div>
            <div class="form-group col-md-2">
                <label for="inputCity">メモ</label>
                <input type="text" class="form-control" id="inputCity" name="memo">
            </div>
            <div class="form-group col-md-2">
              <label for="inputState">カテゴリ</label>
              <select id="inputState" class="form-control" name="category">
                @foreach ($variable_cost_categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach   
                {{ csrf_field() }}
              </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputState"></label>
                <button type="submit" class="btn btn-primary col" id="add-expences">追加</button>
            </div>
            <div class="form-group col-md-12"></div>
        </div>
    </form>
    @endif
    
    {{-- 支出フォルダ一覧 --}}
    <br><br><br><br>
    <h4>変動費</h4>
    <div class="row">
        @foreach ($variable_cost_categories as $category)
        <div class="col col-md-2">
          <nav class="panel panel-default">
                <div class="panel-heading">{{ $category->name }}</div>
                <a href="/category_detail/{{ $category->id }}">
                    <div class="list-group">
                       {{ $category->sum_expences }} / {{ $category->maximum_price }} ¥
                    </div>
                </a>
          </nav>
        </div>
        @endforeach
    </div>
    <br>

    <h4>固定費</h4>
    <div class="row">
        @foreach ($fixed_cost_categories as $category)
        <div class="col col-md-2">
          <nav class="panel panel-default">
                <div class="panel-heading">{{ $category->name }}</div>
                <a href="/category_detail/{{ $category->id }}">
                    <div class="list-group">
                        {{ $category->maximum_price }} ¥
                    </div>
                </a>
          </nav>
        </div>
        @endforeach
    </div>
    <br><br>
    
    {{-- 支出フォルダ追加フォームここはTOPページにあったら邪魔だからベットページ作る --}}
    @if($variable_cost_categories->isEmpty())
        <h4>↓まずは支出フォルダ(変動費)を作成しましょう!↓</h4>
    @endif
    支出フォルダ  
    <a href="/add_expence_category">
        <button type="submit" class="btn btn-primary" id="add-expence-category">+</button>
    </a>
</div>
@endsection