<!DOCTYPE HTML>
<html>
<head>
    <title>TOPページ</title>
</head>
<body>
<h1>{{ $this_month }} 月<h1>

<h2>今月の貯金目標額<h2>

<h2>これまでの貯金額<h2>

<!-- 支出フォルダ(変動費)が追加されていないと利用できないようにする。 -->
@if(!$variable_cost_categories->isEmpty())
<!-- 支出フォーム -->
<h2>支出</h2>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="/add_expence" method="POST">
    金額:
    <input name="price">
    メモ:
    <input name="memo">
    カテゴリ:
    <select class="form-control" id="sel01" name="category">
        @foreach ($variable_cost_categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach   
    </select>
    {{ csrf_field() }}
    <button class="btn btn-success"> 追加 </button>
</form>

{{-- 支出フォルダ一覧 --}}
<h3>変動費</h3>
@foreach($variable_cost_categories as $category)
    <a href="/category_detail/{{ $category->id }}">{{ $category->name }}</a>
@endforeach

<h3>固定費</h3>
@foreach($fixed_cost_categories as $category)
    <a href="/category_detail/{{ $category->id }}">{{ $category->name }}</a>
@endforeach
<br><br>

{{-- 支出フォルダ追加フォームここはTOPページにあったら邪魔だからベットページ作る --}}
支出フォルダ
<a href="/add_expence_category">追加</a>
@else
    <br>
    まずは支出フォルダ(変動費)を作成しましょう!
    <a href="/add_expence_category">作成！</a>
@endif

</body>
</html>