<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroceryListCreateRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'items' => ['array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity' => ['integer'],
        ];
    }
}
