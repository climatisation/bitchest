<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyCrypto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $comment = Comment::find($this->route('comment'));

        // return $comment && $this->user()->can('update', $comment);
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
