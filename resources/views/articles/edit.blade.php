@extends('app')

@section('title', '記事更新')

@include('nav')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-0">
            @include('error_card_list')
            <div class="card-text">
              <form method="POST" action="{{ route('articles.update', ['article' => $article]) }}">
              {{--上のコードでは、formタグのaction属性に記事更新処理のURLを指定しています。route関数の第二引数には、連想配列形式でルーティングのパラメーターを渡すことができます。--}}
              {{--HTMLのformタグは、PUTメソッドやPATCHメソッドをサポートしていません(DELETEメソッドもサポートしていません)。その為、LaravelのBladeでPATCHメソッド等を使う場合は、formタグではmethod属性を"POST"のままとしつつ、@methodでPATCHメソッド等を指定するようにします。--}}
                @method('PATCH')
                @include('articles.form')
                <button type="submit" class="btn blue-gradient btn-block">更新する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
