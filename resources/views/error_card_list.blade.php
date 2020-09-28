@if ($errors->any())
{{--$errors変数は、Illuminate\Support\MessageBagクラスのインスタンスであり、バリデーションエラーメッセージを配列で持っています。--}}
{{--MessageBagクラスのanyメソッドを使っていますが、これはエラーメッセージの有無を返します。--}}
  <div class="card-text text-left alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
      {{--エラーメッセージが1件以上ある場合は、MessageBagクラスのallメソッドで全エラーメッセージの配列を取得し、@foreachで繰り返し表示を行なっています。--}}
    </ul>
  </div>
@endif

{{--ここの文がregister.blade.phpで読み込まれている--}}
{{--バリデーションエラーメッセージが日本語で表示するためには下記を見てください resources/lang/ja/validation.php また、言語設定はlaravel/config/app.phpの'locale' => 'en',から'locale' => 'ja', に編集する --}}
{{--上記ファイルでの記載内容（validation.php）は下記URL記載。以下が言語ファイルの内容です。より下の部分をコピペした。https://readouble.com/laravel/6.x/ja/validation-php.html--}}