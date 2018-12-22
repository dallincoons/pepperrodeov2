<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroceryListItemRequest extends FormRequest
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
            'grocery_list_id' => ['required', 'integer'],
            'description'     => ['required', 'string'],
            'new_description'     => ['string'],
            'quantity'        => 'integer',
        ];
    }
}
