<?php
/**
 * Created by
 * Andrey D. Gluschenko
 * AccessDenied80@gmail.com
 */

namespace App\Http\Requests;

use App\Models\ShortUrl;
use Illuminate\Foundation\Http\FormRequest;

class ShortUrlForm extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'original_url' => 'required|url',
            'max_redirects' => 'required|integer|between:0,1000000',
            'expired_limit' => 'required|integer|between:1,1440',
        ];
    }

    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (ShortUrl::withoutTrashed()->where(['original_url' => $this->url])->exists()) {
                $validator->errors()->add('url', 'This Url link already exists.');
            }
        });
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'original_url' => 'Url link to minify',
            'max_redirects' => 'Limit transfers',
            'expired_limit' => 'Limit time',
        ];
    }
}