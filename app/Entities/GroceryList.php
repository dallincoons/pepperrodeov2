<?php

namespace App\Entities;

use App\Entities\Behavior\OrderByLatest;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GroceryList extends Model implements Transformable
{
    use TransformableTrait, Searchable, OrderByLatest;

    protected $fillable = [
        'title',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(GroceryListItem::class);
    }

    public function addRecipe($recipe)
    {
        foreach ($recipe->items as $item) {
            if ($item->listable) {
                $this->items()->save($this->translateRecipeItem($item, $recipe));
            }
        }
    }

    public function translateRecipeItem(RecipeItem $recipeItem, Recipe $recipe)
    {
        return new GroceryListItem([
            'description' => $recipeItem->description,
            'quantity'    => $recipeItem->quantity,
            'recipe_id'   => $recipe->getKey()
        ]);
    }
}
