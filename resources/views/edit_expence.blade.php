@extends('layout')

@section('content')
　<div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">支出編集</div>
          <div class="panel-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="/edit_expence/{{ $expence->id }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">メモ</label>
                <input type="text" class="form-control" name="memo" value={{ $expence->memo }} id="title" />
              </div>
              <div class="form-group">
                <label for="title">金額</label>
                <input type="text" class="form-control" name="price" value={{ $expence->price }}>
              </div>
              <div class="form-group">
                <label for="title">{{ $expence->created_at }}</label>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">更新</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection