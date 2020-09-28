@extends('app')

@section('title', 'ログイン')

@section('content')
  <div class="container">
    <div class="row">
      <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <h1 class="text-center"><a class="text-dark" href="/">memo</a></h1>
        <div class="card mt-3">
          <div class="card-body text-center">
            <h2 class="h3 card-title text-center mt-2">ログイン</h2>

            @include('error_card_list')
            
            <div class="card-text">
              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="md-form">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" required value="{{ old('email') }}">
                </div>

                <div class="md-form">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" required>
                </div>
 
                <input type="hidden" name="remember" id="remember" value="on">
                {{--上記のinputタグは、世の中のWebサービスのログイン画面によく登場する、次回から自動でログインするという説明がされたチェックボックスに相当するものとなります。ただし、本教材のWebサービスではtype属性をcheckboxではなくhiddenとすることでユーザーが直接操作できない隠し項目とし、value属性をonとすることで常にチェックが入ったのと同じ状態にしています。--}}

                {{--上記のinputタグがあることで、ユーザーがログインボタンを押した際にメールアドレスとパスワード以外にもrememberという名前のパラメータがonの状態でPOST送信されます。この結果どうなるかというと、ユーザーがログインした後はログアウト操作を行わない限り、そのブラウザではログイン状態が維持されます。どういった仕組みで実現しているかというと、最初のログイン成功後にブラウザにはremember_web_...という名前のCookieが保存され、Laravelではこれがあれば2回目からのログインを不要にしています。--}}

                <div class="text-left">
                  <a href="{{ route('password.request') }}" class="card-text">パスワードを忘れた方</a>
                </div>

                <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">ログイン</button>

              </form>

              <div class="mt-0">
                <a href="{{ route('register') }}" class="card-text">ユーザー登録はこちら</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection