<?php

namespace App\Entities;

use App\Entities\Behavior\OrderByLatest;
use App\Services\GroceryItemCombine;
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
        foreach ($recipe->ingredients as $ingredients) {
            if ($ingredients->listable) {
                $this->items()->save($this->translateIngredient($ingredients, $recipe));
            }
        }
    }

    public function getCombinedItemsAttribute()
    {
        return $this->getCombinedItems();
    }

    public function getCombinedItems()
    {
        $items = app(GroceryItemCombine::class)->combine($this);

        return $items;
    }

    public function translateIngredient(Ingredient $ingredient, Recipe $recipe)
    {
        return new GroceryListItem([
            'description' => $ingredient->description,
            'quantity'    => $ingredient->quantity,
            'recipe_id'   => $recipe->getKey()
        ]);
    }
}
