<?php

namespace App\Http\Controllers;

use App\Article;
//Articleモデルが使えるように設定
use App\Tag;
use App\Http\Requests\ArticleRequest;
//バリデーションを設定したArticleRequest.phpが使えるように修正。
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
        //PHPのクラスでは、__constructメソッドを定義すると、クラスのインスタンスが生成された時に初期処理として特に呼び出さなくても必ず実行されます。詳細は教材5-5へ
        //authorizeResourceメソッドこの詳細も教材5-5へ、上記の記述でArtcleControllerで、ArtclePolicyを使うように設定
    }
    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at');
        //コレクションのメソッドである、sortByDescメソッドを使いcreated_atの降順で並び替え

        return view('articles.index', ['articles' => $articles]);
    }
    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ]);
    }
    public function store(ArticleRequest $request,Article $article)
    {
    //引数$requestはArticleRequestクラスのインスタンスである、ということを宣言(型宣言)
    //ArticleRequestクラスのインスタンス以外のものが渡されるとTypeErrorという例外が発生して処理は中断します。
    //宣言する型の種類には、クラスのインスタンスのほか、整数(int)、文字列(string)、配列(array)などが使えます(他にもあります)。

    //Laravelのコントローラーはメソッドの引数で型宣言を行うと、そのクラスのインスタンスが自動で生成されてメソッド内で使えるようになります。
    //このようにメソッドの内部で他のクラスのインスタンスを生成するのではなく、外で生成されたクラスのインスタンスをメソッドの引数として受け取る流れをDI(Dependency Injection)と言います。
        $article->fill($request->all());
        //リクエストのallメソッドを使うことで、記事投稿画面から送信されたPOSTリクエストのパラメータを以下のように配列で取得できます。
        //["_token" => "CdU7HghsXIOi14n7UnwCeOALRPGiVkMegZmK6RDc","title" => "Techpitとは","body" => "Techpitは「現役エンジニアが作った」学習コンテンツで「作りながら」プログラミングが学べる学習サービスです。",]
        $article->user_id = $request->user()->id;
        $article->save();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });
        return redirect()->route('articles.index');
    }
    public function edit(Article $article)
    {
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });
        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }
    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        //storeアクションに同じ
        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });
        return redirect()->route('articles.index');
    }
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
    public function show(Article $article)
    {
        return view('articles.show',['article'=>$article]);
    }
    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
