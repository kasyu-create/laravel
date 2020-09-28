<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        //上記のredirectToメソッドの戻り値によって、リダイレクト先が決まります。もしリダイレクト先をログイン画面以外にしたい場合は、route('login')の部分を変更してください。
    }
}
