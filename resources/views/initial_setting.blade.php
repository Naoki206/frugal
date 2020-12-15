@extends('layout')

@section('content')
<div class="container">

<!-- フォームエリア -->
<h3>収入を入力してスタートしましょう！</h3>
<form action="/initial_setting" method="POST">
    収入:<br>
    <input name="income">
    <br>
    {{ csrf_field() }}
    <br>
    <button class="btn btn-success"> 送信 </button>
</form>

</div>
@endsection