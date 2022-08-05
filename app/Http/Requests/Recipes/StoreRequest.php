<?php

namespace App\Http\Requests\Recipes;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title'                => 'string',
            'directions'           => 'string',
            'categories'          => ['array', 'required', "min:1"],
            'user_id'              => 'integer',
            'ingredients'          => 'array',
            'listable_ingredients' => 'array',
        ];
    }
}
