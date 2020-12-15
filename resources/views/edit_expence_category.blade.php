@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">支出フォルダ編集</div>
          <div class="panel-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="/edit_expence_category/{{ $category->id }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">名前</label>
                <input type="text" class="form-control" name="name" value={{ $category->name }} id="title" />
              </div>
              <div class="form-group">
                <label for="due_date">種類</label>
                <select class="form-control" id="sel01" name="fixed_cost">
                    @if($category->fixed_cost_flg)
                        <option value=1 selected>固定費</option> 
                        <option value=0>変動費</option> 
                    @else
                        <option value=1>固定費</option> 
                        <option value=0 selected>変動費</option> 
                    @endif
                </select>
              </div>
              <div class="form-group">
                <label for="title">上限金額/月</label>
                <input type="text" class="form-control" name="maximum_price" value={{ $category->maximum_price }}>
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