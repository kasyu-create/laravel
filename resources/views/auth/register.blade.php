@extends('app')

@section('title', 'ユーザー登録')

@section('content')
  <div class="container">
    <div class="row">
      <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <h1 class="text-center"><a class="text-dark" href="/">memo</a></h1>
        <div class="card mt-3">
          <div class="card-body text-center">
            <h2 class="h3 card-title text-center mt-2">ユーザー登録</h2>

            @include('error_card_list')

            <div class="card-text">
              <form method="POST" action="{{ route('register') }}">
                @csrf
                {{-- csrfは、Cross-Site Request Forgeries(クロスサイト・リクエスト・フォージェリ)というWebアプリケーションの脆弱性の略称で、上記の@csrfはこの脆弱性からWebサービスを守るためのトークン情報です。 --}}
                {{-- Laravelでは、クライアントからのPOSTメソッドのリクエストを受け付ける際に、リクエスト中のこのトークン情報の内容を見て、不正なリクエストでないかどうかをチェックします。POSTメソッドであるリクエストにこのトークン情報が無いと、Laravelではエラーをレスポンスします。ですので、POST送信を行うBladeには@csrfを含めるようにしてください。 --}}
                <div class="md-form">
                  <label for="name">ユーザー名</label>
                  <input class="form-control" type="text" id="name" name="name" required value="{{ old('name') }}">
                  <small>英数字3〜16文字(登録後の変更はできません)</small>
                </div>
                <div class="md-form">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" required value="{{ old('email') }}" >
                </div>
                {{-- old関数は、引数にパラメータ名を渡すと、直前のリクエストのパラメータ（値と言う意味）を返します。ユーザー登録処理でバリデーションエラーになると再びユーザー登録画面が表示されますが、特に何も対応していなかった場合、全ての項目が空で表示されて入力を最初からやり直さなければなりません。old関数を使うことで、入力した内容が保持された状態でユーザー登録画面が表示されるようになり、ユーザーはエラーになった箇所だけを修正すれば良くなります。 --}}

                {{-- ただし、passwordとpassword_confirmationはold関数を使ってもnullが返ります。そのため、これら入力項目のinputタグに対してはold関数を使っていません。 --}}
                <div class="md-form">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" required>
                </div>
                <div class="md-form">
                  <label for="password_confirmation">パスワード(確認)</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">ユーザー登録</button>
              </form>

              <div class="mt-0">
                <a href="{{ route('login') }}" class="card-text">ログインはこちら</a>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection