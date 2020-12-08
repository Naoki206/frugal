<!DOCTYPE HTML>
<html>
<head>
    <title>カテゴリー詳細</title>
</head>
<body>

<h2></h2>
名前:
{{ $category->name }}
<br>
@if ($category->fixed_cost_flg)
    種類:固定費
    金額:
    {{ $category->maximum_price }}
@else
    種類:変動費 
    上限金額:
    {{ $category->maximum_price }}
@endif
<br>
<a href="/edit_expence_category/{{ $category->id }}">編集</a>
<a href="/delete_expence_category/{{ $category->id }}">削除</a>

</body>
</html>