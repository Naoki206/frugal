<!DOCTYPE HTML>
<html>
<head>
    <title>カテゴリー詳細</title>
</head>
<body>

<h2>{{ $category->name }}</h2>
@if (!$category->fixed_cost_flg)
    <h3>現在の使用状況<span>(今月の利用金額/上限金額)</span></h3>
    <h3>{{ $sum_expences }}/{{ $category->maximum_price }}¥</h3>
    <h3>詳細 </h3>
    @foreach ($category->expences as $expence)
        <a href="/edit_expence/{{ $expence->id }}">
            メモ：{{ $expence->memo }}
            値段：{{ $expence->price }}円
        </a>
            日時：{{ $expence->created_at }}
        <br>
    @endforeach
@else
    金額:
    {{ $category->maximum_price }}
@endif
<br>

<a href="/edit_expence_category/{{ $category->id }}">フォルダ情報編集</a>
<a href="/delete_expence_category/{{ $category->id }}">フォルダ削除</a>
<a href="/home">戻る</a>

</body>
</html>