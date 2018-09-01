<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'feedUrl' => 'required|unique:sites,feed_url',
            'sourceUrl' => 'required|unique:sites,source_url',
            'crawlable' => 'required',
            'type' => 'required',
        ];
    }
}
