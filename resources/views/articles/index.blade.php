@extends('app')
<!-- app.blade.phpをベースとして使うことを宣言 -->

@section('title', '記事一覧')
{{-- app.blade.phpの@yield('title')に対応。この場合titleは記事一覧とする。 --}}

@section('content')
{{-- @section('content')から@endsectionで囲まれた部分は、app.blade.phpの@yield('content')に対応。また下記は@includeを使うことで、別のビューを取り込める --}}
 @include('nav')
  <div class="container">
    @foreach($articles as $article)
    @include('articles.card')
    @endforeach
  </div>
@endsection