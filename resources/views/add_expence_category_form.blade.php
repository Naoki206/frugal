<!DOCTYPE HTML>
<html>
<head>
    <title>支出カテゴリ追加フォーム</title>
</head>
<body>
<h2>支出フォルダ追加フォーム</h2>
<form action="/add_expence_category" method="POST">
    名前:
    <input name="name">
    <br>
    種類:
    <select class="form-control" id="sel01" name="fixed_cost">
        <option value=1>固定費</option> 
        <option value=0 selected>変動費</option> 
    </select>
    <br>
    上限金額/月:
    <input name="maximum_price">
    <br>
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 追加 </button>
</form>
</body>
</html>