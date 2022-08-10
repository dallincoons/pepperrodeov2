<?php

namespace App\Transformers;

class GroceryListRecipe
{
    public function __construct($id, $title, $categoryId, $categoryTitle)
    {
       $this->id = $id;
       $this->title = $title;
       $this->categoryId = $categoryId;
       $this->categoryTitle = $categoryTitle;
    }

    public function toJson() {
        return [
            'id'  =>  $this->id,
            'title' =>  $this->title,
            'category' => $this->categoryId,
            'category_title' => $this->categoryTitle,
        ];
    }
}
