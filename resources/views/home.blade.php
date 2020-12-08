<!DOCTYPE HTML>
<html>
<head>
    <title>TOPページ</title>
</head>
<body>
{{ $this_month }} 月

今月の貯金目標額

これまでの貯金額

<!-- 支出フォルダ(変動費)が追加されていないと利用できないようにする。 -->
@if(!$variable_cost_categories->isEmpty())
<!-- 支出フォーム -->
<h2>支出追加</h2>
<form action="/add_expence" method="POST">
    金額:
    <input name="price">
    <br>
    メモ:
    <input name="name">
    <br>
    カテゴリ:
    <select class="form-control" id="sel01" name="category">
        @foreach ($variable_cost_categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach   
    </select>
    <br>
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 送信 </button>
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