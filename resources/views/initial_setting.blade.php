<!DOCTYPE HTML>
<html>
<head>
    <title>初期設定画面</title>
</head>
<body>

<!-- フォームエリア -->
<h2>あなたの収入は？</h2>
<form action="/initial_setting" method="POST">
    収入:<br>
    <input name="income">
    <br>
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 送信 </button>
</form>

</body>
</html>