<?php

namespace App\Http\Requests\Recipes;

use Illuminate\Foundation\Http\FormRequest;

class RecipeLinkStore extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function getSourceRecipeID()
    {
        return $this->input('source_recipe_id');
    }

    public function getDestinationID()
    {
        return $this->input('destination_recipe_id');
    }
}
