<!DOCTYPE HTML>
<html>
<head>
    <title>支出カテゴリ編集フォーム</title>
</head>
<body>
<h2>支出フォルダ編集</h2>
<form action="/edit_expence_category/{{ $category->id }}" method="POST">
    名前:
    <input name="name" value={{ $category->name }}>
    <br>
    種類:
    <select class="form-control" id="sel01" name="fixed_cost">
        @if($category->fixed_cost_flg)
            <option value=1 selected>固定費</option> 
            <option value=0>変動費</option> 
        @else
            <option value=1>固定費</option> 
            <option value=0 selected>変動費</option> 
        @endif
    </select>
    <br>
    上限金額/月:
    <input name="maximum_price" value={{ $category->maximum_price }}>
    <br>
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 更新 </button>
</form>
</body>
</html>