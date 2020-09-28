<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //ここはtrueに変更しているが、falseのままだったらエラーとなる。なぜtrueにしたかの詳細は4-4章で記載しています。
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required|max:50',
            'body'=>'required|max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
        //フォームリクエストでは、記事投稿画面や記事更新画面から送信された記事タイトルや記事本文のバリデーションなどを行います。rulesメソッドでは、バリデーションのルールを定義します。
    }
    public function attributes()
    {
        return [
            'title'=>'タイトル',
            'body'=>'本文',
            'tags' => 'タグ',
        ];
        //attributesメソッドでは、バリデーションエラーメッセージに表示される項目名をカスタマイズできます。
    }
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
