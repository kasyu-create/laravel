<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
//ここで関係を記入。どことどこのテーブルの関係かは下で詳細を記入。
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    //Laravelでは、テーブルのデータをモデルと呼ばれるクラスを通して取り扱うことが多い
    //Articleモデルはextends Modelとある通り、Modelクラスを継承。そのため、このままでもモデルとして一通りの機能は使える。
    //Laravelでは、データベースとモデルを関連付ける機能がEloquent ORM(Eloquent Object Relational Mapping)という名前であるため、様々なドキュメントでEloquentという言葉が頻繁に登場。Eloquent、と出てきたらモデルのことを指す。
    protected $fillable = [
        'title',
        'body',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }
    //上記でuse Illuminate\Database\Eloquent\Relations\BelongsTo;と記入したが、これがuserテーブルとarticleテーブルの関係である事をここで記入している。
    //ここで示しているuserはメソッド名（関数名）を表している。
    //: BelongsTo では型宣言を行っている（BelongsToはメソッド型）。型宣言を行うメリットとしては、安全性と可読性。他の型を受け入れる事を防ぐ。読みやすくする為です。
    //$this->belongsTo('App\User')とありますが、この$thisは、Articleクラスのインスタンス自身を指しています。つまり、Articleクラス（設計図）から作られたモノ（newした）を指す。newされたArticleクラスとUserクラスがbelongsToで結ばれたという事となる。
    //しかし、コードではbelongsToメソッドにuser_idやidといったカラム名が一切渡されていないのに、リレーションが成り立っています。
    //これは、usersテーブルの主キーはid、articlesテーブルの外部キーは関連するテーブル名の単数形_id(つまりuser_id)であるという前提のもと、Laravel側で処理をしているためです。
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
