@extends('layout')

@section('content')
<div class=container>
    <h3>{{ $category->name }}</h3>
    <a href="/edit_expence_category/{{ $category->id }}">情報編集</a>
    <a href="/delete_expence_category/{{ $category->id }}">削除</a>
    @if (!$category->fixed_cost_flg)
        <p>現在の使用状況</p>
        <p>{{ $sum_expences }}/{{ $category->maximum_price }}¥<p>
        <h3>詳細 </h3>
        @foreach ($expences as $expence)
            <a href="/edit_expence/{{ $expence->id }}">
                {{ $expence->memo }}
                {{ $expence->price }}円
            </a>
                {{ $expence->created_at }}
            <br>
        @endforeach
    @else
        金額:
        {{ $category->maximum_price }}
    @endif
    <br>
</div>

@endsection