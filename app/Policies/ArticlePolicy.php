<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    //ここに書かれた記述の詳細は5-4章に記載。ここでは、あるユーザーが投稿した記事を、別のユーザーが更新・削除できてしまうという点を修正している。
    //ポリシーを作成しましたが、作成しただけではコントローラーでポリシーは使用されません。ポリシーを使用する方法は様々あるのですが、ここではそのうちの1つの方法を紹介します。それはArticleController.phpにて__construct()で記載しています。
    
    //ポリシーの各メソッドと、コントローラーの各アクションメソッドの対応関係は以下となります。
    //viewAny	index
    //view	show
    //create	create, store
    //update	edit, update
    //destroy	destroy
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
        //?User $userと記述する事で、nullableな型宣言をしている。nullも可能になる。
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function view(?User $user, Article $article)
    {
        return true;
        //上記のviewAnyアクションに同じ
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
        //ポリシーのcreateメソッドでは、update/deleteメソッドと異なり、一律trueを返すようにします。
        //記事投稿画面を表示する段階や、記事投稿処理をこれから行おうとする段階(投稿画面で投稿ボタンを押した段階)では、まだ記事モデルは作成されておらず、update/deleteメソッドのように、ユーザーIDを比較するといったことはできないためです。
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
        //ログイン中のユーザーのIDと記事モデルのユーザーIDが一致すればtrueを、不一致であればfalseを返すようにします。こうすることで、あるユーザーが投稿した記事を他ユーザーが更新・削除することはできなくなります。
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
        //上のupdateに同じ
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
