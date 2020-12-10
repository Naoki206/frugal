<!DOCTYPE HTML>
<html>
<head>
    <title>支出編集フォーム</title>
</head>
<body>
<h2>支出編集</h2>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<form action="/edit_expence/{{ $expence->id }}" method="POST">
    値段:
    <input name="price" value={{ $expence->price }}>
    <br>
    メモ:
    <input name="name" value={{ $expence->memo }}>
    <br>
    日時:
    {{ $expence->created_at }}
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 更新 </button>
</form>
<a href="/category_detail/{{ $expence->expence_category_id }}">
    <button class="btn btn-success"> 戻る </button>
</a>
</body>
</html>