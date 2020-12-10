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
@foreach ($category->expences as $expence)
<a href="/edit_expence/{{ $expence->id }}">
    メモ：{{ $expence->memo }}
    値段：{{ $expence->price }}円
</a>
    日時：{{ $expence->created_at }}
<br>
@endforeach

<a href="/edit_expence_category/{{ $category->id }}">フォルダ情報編集</a>
<a href="/delete_expence_category/{{ $category->id }}">フォルダ削除</a>
<a href="/home">戻る</a>

</body>
</html>